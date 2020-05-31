<?php


namespace Phredeye\Reflex\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Phredeye\Reflex\Traits\HasModelReflector;


class ReflexDataMapper
{
    use HasModelReflector;

    protected array $with = [];

    public function __construct(ModelReflector $modelReflector, array $eagerLoadRelations = [])
    {
        $this->setModelReflector($modelReflector);
        $this->with = $eagerLoadRelations;
    }

    public function query(): Builder
    {
        $query = $this->getModelReflector()->newModelInstance()->newModelQuery();
        if (!empty($this->with)) {
            return $query->with($this->with);
        }
        return $query;
    }

    public function create(array $data): Model
    {
        $model = $this->getModelReflector()->newModelInstance($data);
        $model->save();
        return $model;
    }

    public function update($id, array $data): self
    {
        $this->findById($id)->update($data);
        return $this;
    }

    public function findById($id): Model
    {
        $query = $this->getModelReflector()
            ->newModelInstance()
            ->newModelQuery();

        if (!empty($this->with)) {
            $query = $query->with($this->with);
        }

        return $query->findOrFail($id);
    }

    public function delete($id): self
    {
        $this->findById($id)->delete();
        return $this;
    }
}
