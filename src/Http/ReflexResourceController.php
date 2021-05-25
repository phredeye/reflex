<?php

namespace Phredeye\Reflex;


use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Phredeye\Reflex\Http\ReflexFormRequest;
use Phredeye\Reflex\Model\ModelReflector;
use Phredeye\Reflex\Model\ReflexRepository;
use Phredeye\Reflex\Traits\HasDataMapper;
use Phredeye\Reflex\Traits\HasModelReflector;
use Phredeye\Reflex\Traits\HasQueryBuilderFactory;
use ReflectionException;

use RuntimeException;
use function abort;
use function request;

/**
 * Class ReflexResourceController
 * @package Phredeye\Reflex
 */
class ReflexResourceController extends Controller
{
    use HasModelReflector;
    use HasDataMapper;
    use HasQueryBuilderFactory;

    /**
     * @var string FQ model class name
     */
    protected string $modelClassName;

    /**
     * ReflexResourceController constructor.
     */
    public function __construct()
    {
        if (empty($this->modelClassName)) {
            throw new RuntimeException(sprintf("modelClassName was not set in %s at line %d", __FILE__, 35));
        }
        if (!class_exists($this->modelClassName)) {
            throw new ModelNotFoundException('modelClassName is not a class that exists.');
        }
        $this->reflexBoot();
    }

    /**
     * initialize Reflex classes
     */
    protected function reflexBoot(): void
    {
        try {
            $this->setModelReflector(new ModelReflector($this->modelClassName));
            $this->setDataMapper(new ReflexRepository($this->getModelReflector()));
            $this->bootQueryBuilderFactory($this->getModelReflector());
        } catch (ReflectionException $e) {
            abort(500, "Server Error while trying to introspect reflex model: " . $this->modelClassName);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->createQueryBuilder()
            ->paginate()
            ->appends(request()->query());
    }


    /**
     * @param ReflexFormRequest $request
     * @return JsonResponse
     */
    public function store(ReflexFormRequest $request): JsonResponse
    {
        $model = $this->getDataMapper()->create($request->validated());
        return new JsonResponse($model);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $model = $this->getDataMapper()->findById($id);

//        $model->load($this->getModelReflector()->relations());

        return response()->json($model);
    }


    /**
     * @param ReflexFormRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ReflexFormRequest $request, $id)
    {
        return new JsonResponse(
            $this->getDataMapper()
                ->update($id, $request->validated())
                ->findById($id)
        );
    }

    /**
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id): Response
    {
        $this->getDataMapper()->delete($id);
        return response()->noContent();
    }
}
