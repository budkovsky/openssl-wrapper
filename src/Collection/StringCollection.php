<?php
declare(strict_types = 1);

namespace Budkovsky\ObjectOpenSSL\Collection;

use Budkovsky\ObjectOpenSSL\Abstraction\CollectionAbstract;

class StringCollection extends CollectionAbstract
{
    /**
     * {@inheritDoc}
     */
    public function add(string $item = ''): StringCollection
    {
        $this->collection[] = $item;
        
        return $this;
    }
}
