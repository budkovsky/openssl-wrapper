<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests\Entity;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\PrivateKey;

class CryptionDataSet implements StaticFactoryInterface
{
    /** @var string */
    private $rawContent;

    /** @var string */
    private $encryptedContent;

    /** @var PrivateKey */
    private $key;

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
     * @return PKeyAbstract
     */
    public function getKey(): PrivateKey
    {
        return $this->key;
    }

    /**
     * @param PKeyAbstract $key
     * @return CryptionDataSet
     */
    public function setKey(PrivateKey $key): CryptionDataSet
    {
        $this->key = $key;

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
