<?php


namespace Phredeye\Reflex\Http;


use Illuminate\Foundation\Http\FormRequest;
use Phredeye\Reflex\Model\ModelReflector;
use function app;
use function strtoupper;

abstract class ReflexFormRequest extends FormRequest
{
    protected ModelReflector $modelReflector;


    /**
     * @return ModelReflector
     */
    abstract public function getModelReflector(): ModelReflector;

    /**
     * @param ModelReflector $modelReflector
     */
    abstract public function setModelReflector(ModelReflector $modelReflector): self;



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
