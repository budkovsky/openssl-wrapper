<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * Container of "subject" data from X509 certificate
 */
class X509Subject
{
    /**
     * @var string
     */
    private $countryName;

    /**
     *
     * @var string
     */
    private $stateOrProvinceName;

    /**
     * @var string
     */
    private $localityName;

    /**
     * @var string
     */
    private $organizationName;

    /**
     * @var string
     */
    private $organizationalUnitName;

    /**
     * @var string
     */
    private $commonName;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * The constructor
     * @param array $identity Subject subarray from openssl_x509_parse() result
     */
    public function __construct(array $identity)
    {
        $this->setLongNames($identity);
        $this->setShortNames($identity);
    }
    
    /**
     * Parse and set long name fields
     * @param array $identity
     */
    protected function setLongNames(array $identity): void
    {
        $this->countryName = $identity['countryName'] ?? null;
        $this->stateOrProvinceName = $identity['stateOrProvinceName'] ?? null;
        $this->localityName = $identity['localityName'] ?? null;
        $this->organizationName = $identity['organizationName'] ?? null;
        $this->organizationalUnitName = $identity['organizationalUnitName'] ?? null;
        $this->commonName = $identity['commonName'] ?? null;
        $this->emailAddress = $identity['emailAddress'] ?? null;
    }
    
    /**
     * Parse and set short name fields
     * @param array $identity
     */
    protected function setShortNames(array $identity): void
    {
        $this->countryName = $identity['C'] ?? null;
        $this->stateOrProvinceName = $identity['ST'] ?? null;
        $this->localityName = $identity['L'] ?? null;
        $this->organizationName = $identity['O'] ?? null;
        $this->organizationalUnitName = $identity['OU'] ?? null;
        $this->commonName = $identity['CN'] ?? null;
    }
    
    /**
     * @return string
     */
    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getStateOrProvinceName(): ?string
    {
        return $this->stateOrProvinceName;
    }

    /**
     * @return string
     */
    public function getLocalityName(): ?string
    {
        return $this->localityName;
    }

    /**
     * @return string
     */
    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }

    /**
     * @return string
     */
    public function getOrganizationalUnitName(): ?string
    {
        return $this->organizationalUnitName;
    }

    /**
     * @return string
     */
    public function getCommonName(): ?string
    {
        return $this->commonName;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }
   
    /**
     * @return string
     */
    public function getC(): ?string
    {
        return $this->getCountryName();
    }
    
    /**
     * @return string
     */
    public function getST(): ?string
    {
        return $this->getStateOrProvinceName();
    }
    
    /**
     * @return string
     */
    public function getL(): ?string
    {
        return $this->getLocalityName();
    }
    
    /**
     * @return string
     */
    public function getO(): ?string
    {
        return $this->getOrganizationName();
    }
    
    /**
     * @return string
     */
    public function getOU(): ?string
    {
        return $this->getOrganizationalUnitName();
    }
    
    /**
     * @return string
     */
    public function getCN(): ?string
    {
        return $this->getCommonName();
    }
}
