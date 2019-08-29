<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

abstract class CollectionAbstract implements CollectionInterface
{
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

    /**
     * Sets whole collection, replaces old one, if exists
     * {@inheritDoc}
     */
    public function set(array $collection)
    {
        $this->collection = [];

        foreach ($collection as $item) {
            $this->add($item);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->collection;
    }
}
