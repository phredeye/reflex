<?php


namespace Phredeye\Reflex;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionMethod;
use function get_class;

/**
 * Class ModelReflector
 */
class ModelReflector
{
    /**
     * @var string Fully qualified class name
     */
    protected $modelClassName;

    /**
     * @var ReflectionClass
     */
    protected $reflectionClass;

    /**
     * ModelReflector constructor.
     * @param string $modelClassName
     * @throws \ReflectionException
     */
    public function __construct(string $modelClassName)
    {
        $this->modelClassName = $modelClassName;
        $this->reflectionClass = new ReflectionClass($modelClassName);
    }

    public function relations(): array
    {
        return (new ModelRelationMapper($this->modelClassName))->getRelations();
    }

    /**
     * @return string
     */
    public function getModelClassName(): string
    {
        return $this->modelClassName;
    }

    /**
     * @param string $modelClassName
     * @return ModelReflector
     */
    public function setModelClassName(string $modelClassName): ModelReflector
    {
        $this->modelClassName = $modelClassName;
        return $this;
    }


    /**
     * @return array
     */
    public function getFillable(): array
    {
        return $this->newModelInstance()->getFillable();
    }

    /**
     * @param array $args
     * @return Model
     */
    public function newModelInstance(array $args = []): Model
    {
        /** @var Model $model */
        $model = $this->reflectionClass->newInstance($args);
        return $model;
    }



}
