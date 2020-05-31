<?php


namespace Phredeye\Reflex\Http;


use Illuminate\Foundation\Http\FormRequest;
use Phredeye\Reflex\Model\ModelReflector;
use function app;
use function strtoupper;

abstract class ReflexFormRequest extends FormRequest
{
    protected ModelReflector $modelReflector;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $reflector = app()->get('request.model.reflector');
        $this->setModelReflector($reflector);
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
     */
    public function setModelReflector(ModelReflector $modelReflector): self
    {
        $this->modelReflector = $modelReflector;
        return $this;
    }



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
