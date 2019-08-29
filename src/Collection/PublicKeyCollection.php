<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;

class PublicKeyCollection extends CollectionAbstract
{

    /**
     * Adds public key to the collection
     * @param PublicKey $publicKey
     * @return PublicKeyCollection
     */
    public function add(?PublicKey $publicKey = null): PublicKeyCollection
    {
        if ($publicKey !== null) {
            $this->collection[] = $publicKey;
        }

        return $this;
    }
}
