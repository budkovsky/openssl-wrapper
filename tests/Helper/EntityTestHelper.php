<?php
namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;

class EntityTestHelper
{
    use StaticClassTrait;

    public static function hasNoPublicProperties(\ReflectionClass $reflector): bool
    {
        $publicProperties = $reflector->getProperties(\ReflectionProperty::IS_PUBLIC);

        return count($publicProperties) === 0;
    }

    public static function hasValidGetters(\ReflectionClass $reflector): bool
    {
        foreach ($reflector->getProperties() as $property) {
            /** @var \ReflectionProperty $property */
            if (!self::hasGetter($reflector, $property)) {
                echo "{$reflector->getName()}::{$property->getName()} doesn't have valid getter";
                return false;
            }
        }

        return true;
    }

    public static function hasValidSetters(\ReflectionClass $reflector): bool
    {
        foreach ($reflector->getProperties() as $property) {
            /** @var \ReflectionProperty $property */
            if (!self::hasSetter($reflector, $property)) {
                echo "{$reflector->getName()}::{$property->getName()} doesn't have valid setter";
                return false;
            }
        }

        return true;
    }

    private static function hasGetter(\ReflectionClass $reflector, \ReflectionProperty $property): bool
    {
        return
            $reflector->hasMethod("get{$property->getName()}")
            || $reflector->hasMethod("is{$property->getName()}");
    }

    private static function hasSetter(\ReflectionClass $reflector, \ReflectionProperty $property): bool
    {
        return $reflector->hasMethod("set{$property->getName()}");
    }
}