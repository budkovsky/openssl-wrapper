<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;

/**
 * PublicKeyCollection
 */
class PublicKeyCollection extends CollectionAbstract
{

    /**
     * {@inheritDoc}
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
