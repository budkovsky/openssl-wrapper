<?php
namespace Budkovsky\OpenSslWrapper\Entity;

use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Collection\KeyCollection;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Collection\PublicKeyCollection;
/**
 * @see https://www.php.net/manual/en/function.openssl-pkcs12-read.php
 */
class CertificateStoreData
{
    /** @var KeyInterface */
    private $certificate;

    /** @var PrivateKey */
    private $privateKey;

    /** @var PublicKeyCollection */
    private $extraCerts;

    /**
     * The Constructor
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->certificate = $data['cert'] ? PublicKey::create($data[cert]) : null;
        $this->privateKey = $data['pkey'] ? PrivateKey::create()->load($data['pkey']) : null;

        if ($data['extracerts'] && is_array($data['extracerts'])) {
            $this->extraCerts = new PublicKeyCollection();
            foreach ($data['extracerts'] as $certBody) {
                $this->extraCerts->add(PublicKey::create($certBody));
            }
        }
    }

    /**
     * @return KeyInterface
     */
    public function getCertificate(): ?KeyInterface
    {
        return $this->certificate;
    }

    /**
     * @param KeyInterface $certificate
     * @return CertificateStoreData
     */
    public function setCertificate(KeyInterface $certificate): CertificateStoreData
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * privateKey
     * @return PrivateKey
     *
     */
    public function getPrivateKey(): ?PrivateKey
    {
        return $this->privateKey;
    }

    /**
     * privateKey
     * @param PrivateKey $privateKey
     * @return CertificateStoreData
     */
    public function setPrivateKey(PrivateKey $privateKey): CertificateStoreData
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * extraCerts
     * @return KeyCollection
     */
    public function getExtraCerts(): ?KeyCollection
    {
        return $this->extraCerts;
    }

    /**
     * extraCerts
     * @param KeyCollection $extraCerts
     * @return CertificateStoreData
     */
    public function setExtraCerts(PublicKeyCollection $extraCerts): CertificateStoreData
    {
        $this->extraCerts = $extraCerts;

        return $this;
    }
}
