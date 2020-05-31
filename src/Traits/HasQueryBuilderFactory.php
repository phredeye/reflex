<?php


namespace Phredeye\Reflex\Traits;


use Phredeye\Reflex\Model\ModelReflector;
use Phredeye\Reflex\ReflexQueryBuilderFactory;
use Spatie\QueryBuilder\QueryBuilder;

trait HasQueryBuilderFactory
{
    protected ReflexQueryBuilderFactory $queryBuilderFactory;

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilderFactory->create();
    }

    /**
     * @param ModelReflector $modelReflector
     * @return $this
     */
    public function bootQueryBuilderFactory(ModelReflector $modelReflector): self
    {
        $this->queryBuilderFactory = new ReflexQueryBuilderFactory($modelReflector);
        return $this;
    }


}
