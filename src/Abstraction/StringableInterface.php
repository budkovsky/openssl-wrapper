<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

/**
 * Stringable interface
 */
interface StringableInterface
{
    /**
     * Casts object to the string
     * @return string
     */
    public function __toString(): string;
}

