<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Partial;

/**
 * For implementation of StaticFactory
 * @see \Budkovsky\ObjectOpenSSL\Abstraction\StaticFactory
 *
 */
trait StaticFactoryTrait
{
    public static function create()
    {
        return new static;
    }
}
