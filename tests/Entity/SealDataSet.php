<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests\Entity;

use Budkovsky\OpenSslWrapper\Collection\PublicKeyCollection;
use Budkovsky\OpenSslWrapper\Collection\PrivateKeyCollection;
use Budkovsky\OpenSslWrapper\Entity\SealResult;

class SealDataSet
{
    /** @var string */
    private $data;

    /** @var PrivateKeyCollection */
    private $privateKeyCollction;

    /** @var string */
    private $method;

    /** @var string */
    private $iv;

    /** @var SealResult */
    private $sealResult;

    public function __construct()
    {
        $this->publicKeyCollection = new PublicKeyCollection();
        $this->privateKeyCollction = new PrivateKeyCollection();
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): SealDataSet
    {
        $this->data = $data;

        return $this;
    }

    public function getPrivateKeyCollction(): PrivateKeyCollection
    {
        return $this->privateKeyCollction;
    }

    public function setPrivateKeyCollction(PrivateKeyCollection $privateKeyCollction): SealDataSet
    {
        $this->privateKeyCollction = $privateKeyCollction;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): SealDataSet
    {
        $this->method = $method;

        return $this;
    }

    public function getIv(): ?string
    {
        return $this->iv;
    }

    public function setIv(string $iv): SealDataSet
    {
        $this->iv = $iv;

        return $this;
    }

    public function getSealResult(): SealResult
    {
        return $this->sealResult;
    }

    public function setSealResult(SealResult $sealResult): SealDataSet
    {
        $this->sealResult = $sealResult;

        return $this;
    }

}

