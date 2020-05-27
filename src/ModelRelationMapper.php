<?php


namespace Phredeye\Reflex;;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use ReflectionClass;
use ReflectionMethod;
use ReflectionType;
use function get_class_methods;
use function in_array;
use function is_null;
use function method_exists;

/**
 * Class ModelRelationMapper
 * @package App\ReflexAPI
 */
class ModelRelationMapper
{
    /**
     * @var string model class fully qualified name
     */
    protected $modelClassFQN;

    protected static $relationTypes = [
        HasOne::class,
        HasMany::class,
        BelongsTo::class,
        BelongsToMany::class,
        MorphToMany::class,
        MorphTo::class
    ];

    /**
     * ModelRelationMapper constructor.
     * @param string $modelClassFQN
     */
    public function __construct(string $modelClassFQN)
    {
        $this->modelClassFQN = $modelClassFQN;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getRelations(): array
    {
        $relationTypes = static::$relationTypes;

        return collect(new ReflectionClass($this->modelClassFQN))
            ->filter(function(ReflectionMethod $method) {
                return $method->hasReturnType();
            })
            ->map(function(ReflectionMethod $method) {
                return  $method->getReturnType()->getName();
            })
            ->filter(function($rtName) use($relationTypes) {
                return (!is_null($rtName) && in_array($rtName, $relationTypes));
            })
            ->toArray();
    }

}
