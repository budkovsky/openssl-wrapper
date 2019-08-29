<?php
namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\PrivateKey;

class PrivateKeyCollection extends CollectionAbstract
{

    public function add(?PrivateKey $privateKey = null): PrivateKeyCollection
    {
        if ($privateKey !== null) {
            $this->collection[] = $privateKey;
        }

        return $this;
    }
}
