<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * DSA key details
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class KeyDetailsDSA extends KeyDetails
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
    private $privKey;
    
    /**
     * @var string
     */
    private $pubKey;
    
    /**
     * {@inheritDoc}
     */
    public function __construct(array $keyDetails)
    {
        parent::__construct($keyDetails);
        $dsaDetails = $keyDetails['dsa'];
        $this->primeNumber = $dsaDetails['p'];
        $this->subprime = $dsaDetails['q'];
        $this->generatorOfSubgroup = $dsaDetails['g'];
        $this->privKey = $dsaDetails['priv_key'];
        $this->pubKey = $dsaDetails['pub_key'];
    }

    /**
     * @return string
     */
    public function getPrimeNumber(): string
    {
        return $this->primeNumber;
    }

    /**
     * @return string
     */
    public function getSubprime(): string
    {
        return $this->subprime;
    }

    /**
     * @return string
     */
    public function getGeneratorOfSubgroup(): string
    {
        return $this->generatorOfSubgroup;
    }

    /**
     * @return string
     */
    public function getPrivKey(): string
    {
        return $this->privKey;
    }

    /**
     * @return string
     */
    public function getPubKey(): string
    {
        return $this->pubKey;
    }

}
