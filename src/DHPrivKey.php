<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\PublicKeyAbstract;

class DHPrivKey extends PrivateKey
{
    /** TODO unit tests */
    public function computeKey(PublicKeyAbstract $publicKey): ?string
    {
        return openssl_dh_compute_key($publicKey->getRaw(), $this->keyResource) ?? null;
    }
}
