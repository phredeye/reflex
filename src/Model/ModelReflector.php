<?php


namespace Phredeye\Reflex\Model;


use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionException;
use function class_basename;
use function class_exists;

/**
 * Class ModelReflector
 */
class ModelReflector
{
    /**
     * @var string Fully qualified class name
     */
    protected string $modelClassName;

    /**
     * @var ReflectionClass
     */
    protected ReflectionClass $reflectionClass;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $databaseManager;

    /**
     * ModelReflector constructor.
     * @param string $modelClassName
     * @throws ReflectionException
     */
    public function __construct(string $modelClassName, DatabaseManager $databaseManager)
    {
        $this->modelClassName = $modelClassName;
        $this->reflectionClass = new ReflectionClass($modelClassName);
        $this->databaseManager = $databaseManager;
    }

    /**
     * @return DatabaseManager
     */
    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }

    /**
     * @param DatabaseManager $databaseManager
     */
    public function setDatabaseManager(DatabaseManager $databaseManager): void
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function relations(): array
    {
        return (new ModelRelationReflector($this->modelClassName))->getRelations();
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

    /**
     * @return bool
     */
    public function hasGuessablePolicy(): bool
    {
        return (class_exists($this->guessPolicyClassName()));
    }

    /**
     * @return string
     */
    public function guessPolicyClassName(): string
    {
        return app_path(sprintf("Policies/%sPolicy", $this->getModelBaseName()));
    }

    /**
     * @return string
     */
    public function getModelBaseName(): string
    {
        return class_basename($this->modelClassName);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        $model = $this->newModelInstance();

    }
}
