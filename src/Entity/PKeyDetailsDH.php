<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * DH key details
 */
class PKeyDetailsDH extends PKeyDetails
{
    /**
     * @var string
     */
    private $prime;
    
    /**
     * @var string
     */
    private $generator;
    
    /**
     * @var string
     */
    private $privateKey;
    
    /**
     * @var string
     */
    private $publicKey;
    
    /**
     * {@inheritDoc}
     */
    public function __construct(array $keyDetails)
    {
        parent::__construct($keyDetails);
        
        $dhDetails = $keyDetails['dh'];
        $this->prime = $dhDetails['p'] ?? null;
        $this->generator = $dhDetails['g'] ?? null;
        $this->privateKey = $dhDetails['priv_key'] ?? null;
        $this->publicKey = $dhDetails['pub_key'] ?? null;
    }
    

    /**
     * (p)Prime number(shared) getter
     * @return string
     */
    public function getPrime(): ?string
    {
        return $this->prime;
    }

    /**
     * (g)Generator of Z_p(shared) getter
     * @return string
     */
    public function getGenerator(): ?string
    {
        return $this->generator;
    }

    /**
     * (priv_key)Private DH value getter
     * @return string
     */
    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    /**
     * (pub_key)Public DH value getter
     * @return string
     */
    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            ['dh' => [
                'p' => $this->prime,
                'g' => $this->generator,
                'priv_key' => $this->privateKey,
                'pub_key' => $this->publicKey
            ]]
        );
    }
}

