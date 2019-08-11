<?php
/**
 * 2019 Budkovsky
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

interface SingletonInterface
{
    public static function getInstance();
}

