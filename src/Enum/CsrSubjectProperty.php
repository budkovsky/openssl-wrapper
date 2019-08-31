<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * CSR property enumeration
 * @see https://www.php.net/manual/en/function.openssl-csr-get-subject.php
 */
abstract class CsrSubjectProperty extends EnumAbstract
{

    //full property names
    const COUNTRY_NAME = 'countryName';
    const STATE_OR_PROVINCE_NAME = 'stateOrProvinceName';
    const LOCALITY_NAME = 'localityName';
    const ORGANIZATION_NAME = 'organizationName';
    const ORGANIZATIONAL_UNIT_NAME = 'organizationalUnitName';
    const COMMON_NAME = 'commonName';

    //short property names
    const CA = 'CA';
    const ST = 'ST';
    const L = 'L';
    const O = 'O';
    const OU = 'OU';
    const CN = 'CN';

    //both short and fullname property modes use 'emailAddress' property
    const EMAIL_ADDRESS = 'emailAddress';

    /**
     * Property short name list
     * @var array
     */
    private const PROPERTY_SHORT_NAMES = [
        self::CA,
        self::ST,
        self::L,
        self::O,
        self::OU,
        self::CN,
        self::EMAIL_ADDRESS
    ];

    /**
     * Property full name list
     * @var array
     */
    private const PROPERTY_FULL_NAMES = [
        self::COUNTRY_NAME,
        self::STATE_OR_PROVINCE_NAME,
        self::LOCALITY_NAME,
        self::ORGANIZATION_NAME,
        self::ORGANIZATION_UNIT_NAME,
        self::COMMON_NAME,
        self::EMAIL_ADDRESS
    ];

    /**
     * @param boolean $shortNames
     * @return array
     */
    public static function getAll($shortNames = false): array
    {
        return $shortNames ? self::PROPERTY_SHORT_NAMES : self::PROPERTY_FULL_NAMES;
    }

    /**
     * Is item a valid property name for CSR Subject?
     * @param string $propertyName
     * @param boolean $shortNames
     * @return bool
     */
    public static function isValid($item, $shortNames = false): bool
    {
        return in_array($item, self::getAll($shortNames));
    }

}

