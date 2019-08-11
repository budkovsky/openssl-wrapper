<?php
namespace Budkovsky\OpenSslWrapper\Abstraction;

interface Arrayable
{
    /**
     * Serialization to an array
     * @return array
     */
    public function toArray(): array;
}
