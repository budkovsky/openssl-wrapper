<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;

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
