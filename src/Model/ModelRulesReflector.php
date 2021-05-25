<?php


namespace Phredeye\Reflex\Model;


use Phredeye\Reflex\Traits\HasModelReflector;

class ModelRulesReflector
{
    use HasModelReflector;

    public function __construct(ModelReflector $modelReflector)
    {
        $this->setModelReflector($modelReflector);
    }

    public function getCreateRules() : array {

    }

    public function getUpdateRules() : array {

    }

    public function getDeleteRules() : array {
        // grab key(s) , map types and all required
    }

}
