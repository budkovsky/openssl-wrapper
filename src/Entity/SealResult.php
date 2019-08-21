<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

use Budkovsky\OpenSslWrapper\Collection\StringCollection;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;

/**
 * OpenSSL Seal result data container
 * @see https://www.php.net/manual/en/function.openssl-seal.php
 */
class SealResult implements StaticFactoryInterface
{
    /** @var int */
    private $dataLength;
    
    /** @var string */
    private $sealedData;
    
    /** @var StringCollection */
    private $envKeys;

    /**
     * The constructor of SealResult entity
     * Sets empty StringCollection for `envKeys` property
     */
    public function __construct()
    {
        $this->envKeys = new StringCollection();
    }
    
    /**
     * Static Factory
     * @return SealResult
     */
    public static function create(): SealResult
    {
        return new static();
    }
    
    /**
     * @return int
     */
    public function getDataLength(): ?int
    {
        return $this->dataLength;
    }

    /**
     * @param int $dataLength
     * @return \Budkovsky\OpenSslWrapper\Entity\SealResult
     */
    public function setDataLength(int $dataLength): SealResult
    {
        $this->dataLength = $dataLength;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getSealedData(): ?string
    {
        return $this->sealedData;
    }

    /**
     * @param string $sealedData
     * @return SealResult
     */
    public function setSealedData(string $sealedData): SealResult
    {
        $this->sealedData = $sealedData;
        
        return $this;
    }

    /**
     * @return StringCollection
     */
    public function getEnvKeys(): StringCollection
    {
        return $this->envKeys;
    }

    /**
     * @param StringCollection $stringCollection
     * @return SealResult
     */
    public function setEnvKeys(StringCollection $stringCollection): SealResult
    {
        $this->envKeys = $stringCollection;
        
        return $this;
    }
}
