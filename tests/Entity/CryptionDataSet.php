<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests\Entity;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\PrivateKey;

class CryptionDataSet implements StaticFactoryInterface
{
    /** @var string */
    private $rawContent;

    /** @var string */
    private $encryptedContent;

    /** @var PrivateKey */
    private $privateKey;

    /** @var string */
    private $method;

    /** @var string */
    private $iv;

    /**
     * @return string
     */
    public function getRawContent(): string
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     * @return CryptionDataSet
     */
    public function setRawContent(string $rawContent): CryptionDataSet
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncryptedContent(): string
    {
        return $this->encryptedContent;
    }

    /**
     * @param string $encryptedContent
     * @return CryptionDataSet
     */
    public function setEncryptedContent(string $encryptedContent): CryptionDataSet
    {
        $this->encryptedContent = $encryptedContent;

        return $this;
    }

    /**
     * @return PrivateKey
     */
    public function getPrivateKey(): PrivateKey
    {
        return $this->privateKey;
    }

    /**
     * @param PrivateKey $privateKey
     * @return CryptionDataSet
     */
    public function setPrivateKey(PrivateKey $privateKey): CryptionDataSet
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): CryptionDataSet
    {
        $this->method = $method;

        return $this;
    }

    public function getIv(): string
    {
        return $this->iv;
    }

    public function setIv(string $iv): CryptionDataSet
    {
        $this->iv = $iv;

        return $this;
    }

    /**
     * Static Factory
     * @return CryptionDataSet
     */
    public static function create(): CryptionDataSet
    {
        return new static();
    }
}
