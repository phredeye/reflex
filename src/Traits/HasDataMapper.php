<?php


namespace Phredeye\Reflex\Traits;


use Phredeye\Reflex\Model\ReflexDataMapper;

trait HasDataMapper
{
    protected ReflexDataMapper $dataMapper;

    /**
     * @return ReflexDataMapper
     */
    public function getDataMapper(): ReflexDataMapper
    {
        return $this->dataMapper;
    }

    /**
     * @param ReflexDataMapper $dataMapper
     * @return self
     */
    public function setDataMapper(ReflexDataMapper $dataMapper): self
    {
        $this->dataMapper = $dataMapper;
        return $this;
    }


}
