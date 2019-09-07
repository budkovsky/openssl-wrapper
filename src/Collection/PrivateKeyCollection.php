<?php
namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\PrivateKey;

/**
 * PrivateKeyCollection
 */
class PrivateKeyCollection extends CollectionAbstract
{
    /**
     * {@inheritDoc}
     * @param PrivateKey $privateKey
     * @return PrivateKeyCollection
     */
    public function add(?PrivateKey $privateKey = null): PrivateKeyCollection
    {
        if ($privateKey !== null) {
            $this->collection[] = $privateKey;
        }

        return $this;
    }
}
