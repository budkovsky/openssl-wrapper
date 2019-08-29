<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

interface CollectionInterface extends \IteratorAggregate, \Countable, Arrayable
{
    public function set(array $collection);

    /**
     * Adds item to the collection
     */
    public function add();
}
