<?php

namespace Phredeye\Reflex;;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReflectionException;

/**
 * Class ResourceController
 * @package App\ReflexAPI
 */
abstract class ResourceController extends Controller
{
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
     * @return array
     */
    protected function getStoreRules() : array {
        return [];
    }

    /**
     * @return array
     */
    protected function getUpdateRules(): array {
        return [];
    }


    /**
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function store(): JsonResponse
    {
        $model = $this->getModelReflector()
            ->newModelInstance()
            ->newModelQuery()
            ->create(request()->all());

        return new JsonResponse($model);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $with = request()->query('include', []);
        $model = $this->getModelReflector()->find($id, $with);
        return response()->json($model);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->getModelReflector()->find($id);
        $fillable = $this->getModelReflector()->getFillableFields();
        $model->fill($request->only($fillable));
        $model->save();
        return new JsonResponse($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */

    public function destroy($id)
    {
        $this->getModelReflector()
            ->find($id)
            ->delete();

        return response()->noContent();
    }
}
