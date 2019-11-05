<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Partial;

use Budkovsky\OpenSslWrapper\X509;
use Budkovsky\OpenSslWrapper\Entity\Pkcs12;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Collection\X509Collection;

trait Pkcs12Trait
{
    /** @var Pkcs12 */
    protected $pkcs12;

    public function getCertificate(): ?X509
    {
        return $this->pkcs12->getCertificate();
    }

    public function getPrivateKey(): ?PrivateKey
    {
        return $this->pkcs12->getPrivateKey();
    }

    public function getExtraCerts(): ?X509Collection
    {
        return $this->pkcs12->getExtraCerts();
    }

    public function setCertificate(X509 $certificate): self
    {
        $this->pkcs12->setCertificate($certificate);

        return $this;
    }

    public function setPrivateKey(PrivateKey $key): self
    {
        $this->pkcs12->setPrivateKey($key);

        return $this;
    }

    public function setExtraCerts(X509Collection $certs): self
    {
        $this->pkcs12->setExtraCerts($certs);

        return $this;
    }

    public function addExtraCert(X509 $cert): self
    {
        $this->pkcs12->addExtraCert($cert);

        return $this;
    }
}

