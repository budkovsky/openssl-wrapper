<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * DSA key details entity
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class PKeyDetailsDSA extends PKeyDetails
{
    /**
     * @var string
     */
    private $primeNumber;

    /**
     * @var string
     */
    private $subprime;

    /**
     * @var string
     */
    private $generatorOfSubgroup;

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
        $dsaDetails = $keyDetails['dsa'];
        $this->primeNumber = $dsaDetails['p'] ?? null;
        $this->subprime = $dsaDetails['q'] ?? null;
        $this->generatorOfSubgroup = $dsaDetails['g'] ?? null;
        $this->privateKey = $dsaDetails['priv_key'] ?? null;
        $this->publicKey = $dsaDetails['pub_key'] ?? null;
    }

    /**
     * @return string
     */
    public function getPrimeNumber(): ?string
    {
        return $this->primeNumber;
    }

    /**
     * @return string
     */
    public function getSubprime(): ?string
    {
        return $this->subprime;
    }

    /**
     * @return string
     */
    public function getGeneratorOfSubgroup(): ?string
    {
        return $this->generatorOfSubgroup;
    }

    /**
     * @return string
     */
    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    /**
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
            ['dsa' => [
                'p' => $this->primeNumber,
                'q' => $this->subprime,
                'g' => $this->generatorOfSubgroup,
                'priv_key' => $this->privateKey,
                'pub_key' => $this->publicKey
            ]]
        );
    }
}
