<?php


namespace Phredeye\Reflex;;


interface ReflexModelInterface
{
    /**
     * Returns rules for creating this model
     * @return array
     */
    public function storeRules() : array;

    /**
     * Returns rules for updating this model
     * @return array
     */
    public function updateRules() : array;
}
