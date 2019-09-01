<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;

class StringCollection extends CollectionAbstract implements StaticFactoryInterface
{
    /**
     * {@inheritDoc}
     * @param string $item
     * @return StringCollection
     */
    public function add(string $item = ''): StringCollection
    {
        $this->collection[] = $item;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @param array $collection
     * @return StringCollection
     */
    public static function create(array $collection = []): StringCollection
    {
        $stringCollection = new static();
        $stringCollection->set($collection);

        return $stringCollection;
    }
}
