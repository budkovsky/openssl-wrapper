<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

use Budkovsky\OpenSslWrapper\X509;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Collection\X509Collection;

/**
 * PKCS12 key/certificate container
 *
 * @see https://en.wikipedia.org/wiki/PKCS_12
 */
class Pkcs12
{
    /** @var X509 */
    private $certificate;

    /** @var PrivateKey */
    private $privateKey;

    /** @var X509Collection */
    private $extraCerts;

    public function getCertificate(): ?X509
    {
        return $this->certificate;
    }

    public function getPrivateKey(): ?PrivateKey
    {
        return $this->privateKey;
    }

    public function getExtraCerts(): ?X509Collection
    {
        return $this->extraCerts;
    }

    public function setCertificate(X509 $certificate): Pkcs12
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function setPrivateKey(PrivateKey $key): Pkcs12
    {
        $this->privateKey = $key;

        return $this;
    }

    public function setExtraCerts(X509Collection $certs): Pkcs12
    {
        $this->extraCerts = $certs;

        return $this;
    }

    public function addExtraCert(X509 $cert): Pkcs12
    {
        if (!$this->extraCerts) {
            $this->extraCerts = new X509Collection();
        }
        $this->extraCerts->add($cert);

        return $this;
    }
}
