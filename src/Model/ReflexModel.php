<?php


namespace Phredeye\Reflex\Model;


use Illuminate\Database\Eloquent\Model;

class ReflexModel extends Model implements ReflexModelInterface
{

    public function storeRules(): array
    {
        return [];
    }

    public function updateRules(): array
    {
        return [];
    }


}
