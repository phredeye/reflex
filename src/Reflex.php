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
}

