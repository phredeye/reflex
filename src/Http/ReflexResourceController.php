<?php

namespace Phredeye\Reflex;
;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use ReflectionException;
use function request;

/**
 * Class ReflexResourceController
 * @package Phredeye\Reflex
 */
abstract class ReflexResourceController extends Controller
{
    use ValidatesRequests;
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * @throws ReflectionException
     */
    public function index()
    {
        return $this->getQueryBuilder()
            ->createQueryBuilder()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * @return ReflexQueryBuilder
     */
    protected function getQueryBuilder(): ReflexQueryBuilder
    {
        return new ReflexQueryBuilder($this->getModelReflector());
    }

    /**
     * Resource Controllers must be able to create a ModelReflector
     * to base the API resource methods around
     * @return ModelReflector
     */
    abstract protected function getModelReflector(): ModelReflector;


    /**
     * @param ReflexFormRequest $request
     * @return JsonResponse
     */
    public function store(ReflexFormRequest  $request): JsonResponse
    {
        $model = $this->getModelReflector()
            ->newModelInstance(request()->all())
            ->save();

        return new JsonResponse($model);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $model = $this->getModelReflector()
            ->newModelInstance()
            ->newModelQuery()
            ->findOrFail($id);

        $model->load($this->getModelReflector()->relations());

        return response()->json($model);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ReflexFormRequest $request, $id)
    {
        $reflexModel = $this->getModelReflector()->newModelInstance();

        $model = $reflexModel->newModelQuery()->findOrFail($id);
        $fillable = $reflexModel->fillable();
        $model->fill($request->only($fillable));
        $model->save();
        return new JsonResponse($model);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = $this->getModelReflector()
            ->newModelInstance()
            ->newModelQuery()
            ->findOrFail($id);

        $model->delete();

        return response()->noContent();
    }
}
