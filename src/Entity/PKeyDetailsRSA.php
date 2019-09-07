<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * RSA key details entity
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class PKeyDetailsRSA extends PKeyDetails
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

        $this->modulus = $rsaDetails['n'] ?? null;
        $this->publicExponent = $rsaDetails['e'] ?? null;
        $this->privateExponent = $rsaDetails['d'] ?? null;
        $this->prime1 = $rsaDetails['p'] ?? null;
        $this->prime2 = $rsaDetails['q'] ?? null;
        $this->exponent1 = $rsaDetails['dmp1'] ?? null;
        $this->exponent2 = $rsaDetails['dmq1'] ?? null;
        $this->coefficient = $rsaDetails['iqmp'] ?? null;
    }

    /**
     * @return string
     */
    public function getModulus(): ?string
    {
        return $this->modulus;
    }

    /**
     * @return string
     */
    public function getPublicExponent(): ?string
    {
        return $this->publicExponent;
    }

    /**
     * @return string
     */
    public function getPrivateExponent(): ?string
    {
        return $this->privateExponent;
    }

    /**
     * @return string
     */
    public function getPrime1(): ?string
    {
        return $this->prime1;
    }

    /**
     * @return string
     */
    public function getPrime2(): ?string
    {
        return $this->prime2;
    }

    /**
     * @return string
     */
    public function getExponent1(): ?string
    {
        return $this->exponent1;
    }

    /**
     * @return string
     */
    public function getExponent2(): ?string
    {
        return $this->exponent2;
    }

    /**
     * @return string
     */
    public function getCoefficient(): ?string
    {
        return $this->coefficient;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            ['rsa' => [
                'n' => $this->modulus,
                'e' => $this->publicExponent,
                'd' => $this->privateExponent,
                'p' => $this->prime1,
                'q' => $this->prime2,
                'dmp1' => $this->exponent1,
                'dmq1' => $this->exponent2,
                'iqmp' => $this->coefficient
            ]]
        );
    }
}
