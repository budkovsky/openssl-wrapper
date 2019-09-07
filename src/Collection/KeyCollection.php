<?php
declare(strcit_types = 1);

namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;

/**
 * Collection of KeyInterface objects
 */
class KeyCollection extends CollectionAbstract implements StaticFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function add(KeyInterface $key = null): KeyCollection
    {
        $this->collection[] = $key;
    }

    /**
     * Static Factory
     * @param array $collection optional
     * @return KeyCollection
     */
    public static function create(?array $collection = null): KeyCollection
    {
        $keyCollection = new static();
        if ($collection) {
            $keyCollection->set($collection);
        }

        return $keyCollection;
    }
}
