<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

class CsrSubject
{
    /** @var string */
    protected $countryName;
    
    /** @var string */
    protected $stateOrProvince;
    
    /** @var string */
    protected $localityName;
    
    /** @var string */
    protected $organizationName;
    
    /** @var string */
    protected $organizationUnitName;
    
    /** @var string */
    protected $commonName;
    
    /** @var string */
    protected $emailAddress;
    
    /**
     * The constructor
     * @param array $subject
     */
    public function __construct(array $subject = [])
    {
        foreach ($subject as $key => $value) {
            $this->setProperty($key, $value);
        }  
    }
    
    /**
     * Property setter
     * @param string $key
     * @param string $value
     */
    protected function setProperty(string $key, string $value): void
    {
        switch ($key) {
            case 'countryName':
            case 'CA':
                $this->countryName = $value;
                break;
            case 'stateOrProvinceName':
            case 'ST':
                $this->stateOrProvince = $value;
                break;
            case 'localityName':
            case 'L':
                $this->localityName = $value;
                break;
            case 'organizationName':
            case 'O':
                $this->organizationName = $value;
                break;
            case 'organizationalUnitName':
            case 'OU':
                $this->organizationUnitName = $value;
                break;
            case 'commonName':
            case 'CN':
                $this->commonName = $value;
                break;
            case 'emailAddress':
                $this->emailAddress = $value;
                break;
        }
    }
    
    /** @return string */
    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    /** @return string */
    public function getStateOrProvince(): ?string
    {
        return $this->stateOrProvince;
    }

    /** @return string */
    public function getLocalityName(): ?string
    {
        return $this->localityName;
    }

    /** @return string */
    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }

    /** @return string */
    public function getOrganizationUnitName(): ?string
    {
        return $this->organizationUnitName;
    }

    /** @return string */
    public function getCommonName(): ?string
    {
        return $this->commonName;
    }

    /** @return string */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }
    
    /**
     * @param string $countryName
     * @return CsrSubject
     */
    public function setCountryName(string $countryName): CsrSubject
    {
        $this->countryName = $countryName;
        return $this;
    }

    /**
     * @param string $stateOrProvince
     * @return CsrSubject
     */
    public function setStateOrProvince(string $stateOrProvince): CsrSubject
    {
        $this->stateOrProvince = $stateOrProvince;
        return $this;
    }

    /**
     * @param string $localityName
     * @return CsrSubject
     */
    public function setLocalityName(string $localityName): CsrSubject
    {
        $this->localityName = $localityName;
        return $this;
    }

    /**
     * @param string $organizationName
     * @return CsrSubject
     */
    public function setOrganizationName(string $organizationName): CsrSubject
    {
        $this->organizationName = $organizationName;
        return $this;
    }

    /**
     * @param string $organizationUnitName
     * @return CsrSubject
     */
    public function setOrganizationUnitName(string $organizationUnitName): CsrSubject
    {
        $this->organizationUnitName = $organizationUnitName;
        return $this;
    }

    /**
     * @param string $commonName
     * @return CsrSubject
     */
    public function setCommonName(string $commonName): CsrSubject
    {
        $this->commonName = $commonName;
        
        return $this;
    }

    /**
     * @param string $emailAddress
     * @return CsrSubject
     */
    public function setEmailAddress(string $emailAddress): CsrSubject
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }
}
