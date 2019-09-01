<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

/**
 * Static factory interface
 */
interface StaticFactoryInterface
{
    /**
     * Creates new object by static method
     */
    public static function create();
}
