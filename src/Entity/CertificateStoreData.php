<?php
namespace Entity;

use Collection\KeyCollection;
use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\PrivateKey;

class CertificateStoreData
{
    /** @var KeyInterface */
    private $certificate;
    
    /** @var PrivateKey */
    private $privateKey;
    
    /** @var KeyCollection */
    private $extraCerts;

    /**
     * @return KeyInterface
     */
    public function getCertificate(): KeyInterface
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
    public function getPrivateKey(): PrivateKey
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
    public function getExtraCerts(): KeyCollection
    {
        return $this->extraCerts;
    }

    /**
     * extraCerts
     * @param KeyCollection $extraCerts
     * @return CertificateStoreData
     */
    public function setExtraCerts(KeyCollection $extraCerts): CertificateStoreData
    {
        $this->extraCerts = $extraCerts;
        
        return $this;
    }
}
