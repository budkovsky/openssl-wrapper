<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

use Budkovsky\OpenSslWrapper\Abstraction\Arrayable;
use Budkovsky\OpenSslWrapper\Enum\CsrSubjectProperty as PropertyEnum;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;

/**
 * CSR Subject entity
 * @see https://www.php.net/manual/en/function.openssl-csr-new.php
 */
class CsrSubject implements Arrayable, StaticFactoryInterface
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
    protected $organizationalUnitName;

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
            case PropertyEnum::COUNTRY_NAME:
            case PropertyEnum::CA:
                $this->countryName = $value;
                break;
            case PropertyEnum::STATE_OR_PROVINCE_NAME:
            case PropertyEnum::ST:
                $this->stateOrProvince = $value;
                break;
            case PropertyEnum::LOCALITY_NAME:
            case PropertyEnum::L:
                $this->localityName = $value;
                break;
            case PropertyEnum::ORGANIZATION_NAME:
            case PropertyEnum::O:
                $this->organizationName = $value;
                break;
            case PropertyEnum::ORGANIZATIONAL_UNIT_NAME:
            case PropertyEnum::OU:
                $this->organizationUnitName = $value;
                break;
            case PropertyEnum::COMMON_NAME:
            case PropertyEnum::CN:
                $this->commonName = $value;
                break;
            case PropertyEnum::EMAIL_ADDRESS:
                $this->emailAddress = $value;
                break;
            default:
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
    public function getOrganizationalUnitName(): ?string
    {
        return $this->organizationalUnitName;
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
    public function setOrganizationalUnitName(string $organizationalUnitName): CsrSubject
    {
        $this->organizationalUnitName = $organizationalUnitName;
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

    /**
     * Get CSR Subject as an array
     * @see Arrayable
     * {@inheritDoc}
     */
    public function toArray(bool $shortNames = false): array
    {
        $subject = [
        $shortNames ? PropertyEnum::CA : PropertyEnum::COUNTRY_NAME => $this->countryName,
        $shortNames ? PropertyEnum::ST : PropertyEnum::STATE_OR_PROVINCE_NAME => $this->stateOrProvince,
        $shortNames ? PropertyEnum::L : PropertyEnum::LOCALITY_NAME => $this->localityName,
        $shortNames ? PropertyEnum::O : PropertyEnum::ORGANIZATION_NAME => $this->organizationName,
        $shortNames ? PropertyEnum::OU : PropertyEnum::ORGANIZATIONAL_UNIT_NAME => $this->organizationalUnitName,
        $shortNames ? PropertyEnum::CN : PropertyEnum::COMMON_NAME => $this->commonName,
        PropertyEnum::EMAIL_ADDRESS => $this->emailAddress
        ];

        //remove empty field, to avoid error from openssl_csr_new() function
        foreach ($subject as $key => $value) {
            if (!$value) {
                unset($subject[$key]);
            }
        }

        return $subject;
    }

    /**
     * Static factory
     * @param array $subject
     * @return \Budkovsky\OpenSslWrapper\Entity\CsrSubject
     */
    public static function create(array $subject = [])
    {
        return new static($subject);
    }
}
