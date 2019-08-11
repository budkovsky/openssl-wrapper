<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

interface CollectionInterface
{
    public function set(array $collection);
    
    public function add();
}
