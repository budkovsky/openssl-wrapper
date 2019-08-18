<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

abstract class EnumAbstract
{
    abstract public static function getAll(): array;
    
    public static function isValid($item): bool
    {
        return in_array($item, static::getAll());
    }
}
