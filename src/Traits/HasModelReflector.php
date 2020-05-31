<?php


namespace Phredeye\Reflex\Traits;


use Phredeye\Reflex\Model\ModelReflector;

trait HasModelReflector
{
    /**
     * @var ModelReflector
     */
    protected ModelReflector $modelReflector;

    /**
     * @return ModelReflector
     */
    public function getModelReflector(): ModelReflector
    {
        return $this->modelReflector;
    }

    /**
     * @param ModelReflector $modelReflector
     * @return self
     */
    public function setModelReflector(ModelReflector $modelReflector): self
    {
        $this->modelReflector = $modelReflector;
        return $this;
    }
}
