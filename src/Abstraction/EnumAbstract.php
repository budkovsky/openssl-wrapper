<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

/**
 * Abstract enum
 */
abstract class EnumAbstract
{
    /**
     * Returns enumaration items as an array
     * @return array
     */
    abstract public static function getAll(): array;

    /**
     * Checks is given value valid for the enumeration
     * @param mixed $item
     * @return bool
     */
    public static function isValid($item): bool
    {
        return in_array($item, static::getAll());
    }
}
