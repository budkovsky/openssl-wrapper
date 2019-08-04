<?php
declare(strict_types = 1);

namespace Budkovsky\ObjectOpenSSL\Abstraction;

abstract class CollectionAbstract implements \IteratorAggregate, \Countable, CollectionInterface
{
    /**
     * Collection trait, implements methods for IteratorAggregate, Countable interfaces
     * When use, implement add() method with proper type hinting for collection's items
     */
    protected $collection = [];
    
    /**
     * {@inheritDoc}
     * @see \IteratorAggregate::getIterator()
     * @see http://php.net/manual/en/class.iteratoraggregate.php
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * {@inheritDoc}
     * @see \Countable::count()
     * @see http://php.net/manual/en/class.countable.php
     */
    public function count(): int
    {
        return count($this->collection);
    }

    public function set(array $collection)
    {
        $this->collection = [];
        
        foreach ($collection as $item) {
            $this->add($item);
        }
    }
}
