<?php


namespace Phredeye\Reflex\Model;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use function in_array;
use function is_null;

/**
 * Class ModelRelationReflector
 * @package App\ReflexAPI
 */
class ModelRelationReflector
{
    protected static array $relationTypes = [
        HasOne::class,
        HasMany::class,
        BelongsTo::class,
        BelongsToMany::class,
        MorphToMany::class,
        MorphTo::class
    ];
    /**
     * @var string model class fully qualified name
     */
    protected string $modelClassFQN;

    /**
     * ModelRelationReflector constructor.
     * @param string $modelClassFQN
     */
    public function __construct(string $modelClassFQN)
    {
        $this->modelClassFQN = $modelClassFQN;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getRelations(): array
    {
        $relationTypes = static::$relationTypes;

        return collect(new ReflectionClass($this->modelClassFQN))
            ->filter(function (ReflectionMethod $method) {
                return $method->hasReturnType();
            })
            ->map(function (ReflectionMethod $method) {
                return $method->getReturnType()->getName();
            })
            ->filter(function ($rtName) use ($relationTypes) {
                return (!is_null($rtName) && in_array($rtName, $relationTypes));
            })
            ->toArray();
    }

}
