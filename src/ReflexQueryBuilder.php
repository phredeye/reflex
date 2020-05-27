<?php


namespace Phredeye\Reflex;;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

class ReflexQueryBuilder
{
    /**
     * @var ModelReflector
     */
    protected $modelReflector;

    /**
     * @param ModelReflector|null $modelReflector
     */
    public function __construct(ModelReflector $modelReflector = null)
    {
        $this->modelReflector = $modelReflector;
    }

    /**
     * @return QueryBuilder
     * @throws \ReflectionException
     */
    public function createQueryBuilder(): QueryBuilder
    {
        $reflector = $this->getModelReflector();

        $class = $reflector->getModelClassName();
        $fields = $reflector->newModelInstance()->getFillable();
        $includes = $reflector->relations();

        return QueryBuilder::for($class)
            ->allowedFields($fields)
            ->allowedFilters(['*'])
            ->allowedAppends(['*'])
            ->allowedIncludes($includes);
    }

    /**
     * @param $id
     * @param array $relations
     * @return Model
     * @throws \ReflectionException
     */
    public function findWithRelations($id, array $relations = [])  : Model {
        return $this->getModelReflector()
            ->newModelInstance()
            ->newModelQuery()
            ->with($relations)
            ->findOrFail($id);
    }

    /**
     * @return ModelReflector
     */
    public function getModelReflector(): ModelReflector
    {
        return $this->modelReflector;
    }

    /**
     * @param ModelReflector $modelReflector
     * @return ReflexQueryBuilder
     */
    public function setModelReflector(ModelReflector $modelReflector): ReflexQueryBuilder
    {
        $this->modelReflector = $modelReflector;
        return $this;
    }

}

