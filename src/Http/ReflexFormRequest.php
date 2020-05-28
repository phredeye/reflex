<?php


namespace Phredeye\Reflex;


use Illuminate\Foundation\Http\FormRequest;
use function strtoupper;

abstract class ReflexFormRequest extends FormRequest
{
    abstract public function getModelReflector() : ModelReflector;


    public function rules() : array  {
        $modelInstance = $this->getModelReflector()->newModelInstance();

        if($this->isMethod('POST')) {
            return $modelInstance->storeRules();
        } else if($this->isMethod('PUT')) {
            return $modelInstance->updateRules();
        }

        return [];
    }

}
