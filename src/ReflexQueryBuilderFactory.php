<?php


namespace Phredeye\Reflex;

use Illuminate\Database\Eloquent\Model;
use Phredeye\Reflex\Model\ModelReflector;
use ReflectionException;
use Spatie\QueryBuilder\QueryBuilder;

class ReflexQueryBuilderFactory
{
    /**
     * @var ModelReflector
     */
    protected ModelReflector $modelReflector;

    /**
     * @param ModelReflector $modelReflector
     */
    public function __construct(ModelReflector $modelReflector)
    {
        $this->modelReflector = $modelReflector;
    }

    /**
     * @return QueryBuilder
     */
    public function create(): QueryBuilder
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
     * @return ModelReflector
     */
    public function getModelReflector(): ModelReflector
    {
        return $this->modelReflector;
    }

    /**
     * @param ModelReflector $modelReflector
     * @return ReflexQueryBuilderFactory
     */
    public function setModelReflector(ModelReflector $modelReflector): ReflexQueryBuilderFactory
    {
        $this->modelReflector = $modelReflector;
        return $this;
    }


}

