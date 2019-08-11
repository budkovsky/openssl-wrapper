<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

interface CollectionInterface extends \IteratorAggregate, \Countable
{
    public function set(array $collection);
    
    public function add();
}
