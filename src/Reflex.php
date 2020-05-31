<?php

namespace Phredeye\Reflex;

use Phredeye\Reflex\Model\ModelReflector;

class Reflex
{
    public function registerRequestModelReflector(string $modelClassName): self
    {
        app()->register(config("reflex.requestForm.containerKey"), function () use ($modelClassName) {
            return new ModelReflector($modelClassName);
        });

        return $this;
    }

    /**
     * @param $modelClassName
     * @return ModelReflector
     * @throws \ReflectionException
     */
    public function createModelReflector($modelClassName): ModelReflector
    {
        return new ModelReflector($modelClassName);
    }
}
