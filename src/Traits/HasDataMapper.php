<?php


namespace Phredeye\Reflex\Traits;


use Phredeye\Reflex\Model\ReflexRepository;

trait HasDataMapper
{
    protected ReflexRepository $dataMapper;

    /**
     * @return ReflexRepository
     */
    public function getDataMapper(): ReflexRepository
    {
        return $this->dataMapper;
    }

    /**
     * @param ReflexRepository $dataMapper
     * @return self
     */
    public function setDataMapper(ReflexRepository $dataMapper): self
    {
        $this->dataMapper = $dataMapper;
        return $this;
    }


}
