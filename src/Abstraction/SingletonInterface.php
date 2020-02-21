<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

/**
 * Singleton interface
 *
 * For implementation of `Singleton` design pattern
 */
interface SingletonInterface
{
    /**
     * Single instance getter
     */
    public static function getInstance();
}
