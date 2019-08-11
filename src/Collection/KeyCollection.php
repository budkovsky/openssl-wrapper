<?php

namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;

class KeyCollection extends CollectionAbstract
{

    public function add(KeyInterface $key = null): KeyCollection
    {
        $this->collection[] = $key;
    }
}
