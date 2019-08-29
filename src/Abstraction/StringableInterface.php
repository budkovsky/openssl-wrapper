<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

interface StringableInterface
{
    /**
     * Casts object to the string
     * @return string
     */
    public function __toString(): string;
}

