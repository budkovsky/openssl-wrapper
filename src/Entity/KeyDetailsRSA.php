<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * RSA key details
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class KeyDetailsRSA extends KeyDetails
{
    /**
     * @var string
     */
    private $modulus;
    
    /**
     * @var string
     */
    private $publicExponent;
    
    /**
     * @var string
     */
    private $privateExponent;
    
    /**
     * @var string
     */
    private $prime1;
    
    /**
     * @var string
     */
    private $prime2;
    
    /**
     * @var string
     */
    private $exponent1;
    
    /**
     * @var string
     */
    private $exponent2;
    
    /**
     * @var string
     */
    private $coefficient;
    
    /**
     * {@inheritDoc}
     */
    public function __construct(array $keyDetails)
    {
        parent::__construct($keyDetails);
        $rsaDetails = $keyDetails['rsa'];
        
        $this->modulus = $rsaDetails['n'];
        $this->publicExponent = $rsaDetails['e'];
        $this->privateExponent = $rsaDetails['d'];
        $this->prime1 = $rsaDetails['p'];
        $this->prime2 = $rsaDetails['q'];
        $this->exponent1 = $rsaDetails['dmp1'];
        $this->exponent2 = $rsaDetails['dmq1'];
        $this->coefficient = $rsaDetails['iqmp'];
    }

    /**
     * @return string
     */
    public function getModulus(): string
    {
        return $this->modulus;
    }
  
    /**
     * @return string
     */
    public function getPublicExponent(): string
    {
        return $this->publicExponent;
    }

    /**
     * @return string
     */
    public function getPrivateExponent(): string
    {
        return $this->privateExponent;
    }

    /**
     * @return string
     */
    public function getPrime1(): string
    {
        return $this->prime1;
    }

    /**
     * @return string
     */
    public function getPrime2(): string
    {
        return $this->prime2;
    }

    /**
     * @return string
     */
    public function getExponent1(): string
    {
        return $this->exponent1;
    }

    /**
     * @return string
     */
    public function getExponent2(): string
    {
        return $this->exponent2;
    }

    /**
     * @return string
     */
    public function getCoefficient(): string
    {
        return $this->coefficient;
    }
    
    /**
     * Alias for self::getModulus()
     * @return string
     */
    public function getN(): string
    {
        return $this->getModulus();
    }
    
    /**
     * Alias for self::getPublicExponent()
     * @return string
     */
    public function getE(): string
    {
        return $this->getPublicExponent();
    }
    
    /**
     * Alias for self::privateExponent()
     * @return string
     */
    public function getD():string
    {
        return $this->privateExponent();
    }
    
    /**
     * Alias for self::getPrime1()
     * @return string
     */
    public function getP(): string
    {
        return $this->getPrime1();
    }
    
    /**
     * Alias for self::getPrime2()
     * @return string
     */
    public function getQ(): string
    {
        return $this->getPrime2();
    }
    
    /**
     * Alias for self::getExponent1()
     * @return string
     */
    public function getDmp1(): string
    {
        return $this->getExponent1();
    }
    
    /**
     * Alias for self::getExponent2()
     * @return string
     */
    public function getDmq1(): string
    {
        return $this->getExponent2();
    }
    
    /**
     * Alias for self::getCoefficient()
     * @return string
     */
    public function getIqmp(): string
    {
        return $this->getCoefficient();
    }
}
