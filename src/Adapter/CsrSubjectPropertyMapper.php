<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Adapter;

use Budkovsky\OpenSslWrapper\Enum\CsrSubjectProperty as PropertyEnum;
use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;

/**
 * CSR Subject property mapper
 * @static
 * @see https://www.php.net/manual/en/function.openssl-csr-get-subject.php
 */
class CsrSubjectPropertyMapper
{
    use StaticClassTrait;
    
    /**
     * Full to short property name mapper
     * @var array
     */
    private const TO_SHORT_NAME_MAPPER = [
        PropertyEnum::COUNTRY_NAME => PropertyEnum::CA,
        PropertyEnum::STATE_OR_PROVINCE_NAME => PropertyEnum::ST,
        PropertyEnum::LOCALITY_NAME => PropertyEnum::L,
        PropertyEnum::ORGANIZATION_NAME => PropertyEnum::O,
        PropertyEnum::ORGANIZATION_UNIT_NAME => PropertyEnum::OU,
        PropertyEnum::COMMON_NAME => PropertyEnum::CN,
        PropertyEnum::EMAIL_ADDRESS => PropertyEnum::EMAIL_ADDRESS
    ];
    
    /**
     * Short to full property name mapper
     * @var array
     */
    private const TO_FULL_NAME_MAPPER = [
        PropertyEnum::CA => PropertyEnum::COUNTRY_NAME,
        PropertyEnum::ST => PropertyEnum::STATE_OR_PROVINCE_NAME,
        PropertyEnum::L => PropertyEnum::LOCALITY_NAME,
        PropertyEnum::O => PropertyEnum::ORGANIZATION_NAME,
        PropertyEnum::OU => PropertyEnum::ORGANIZATION_UNIT_NAME,
        PropertyEnum::CN => PropertyEnum::COUNTRY_NAME,
        PropertyEnum::EMAIL_ADDRESS => PropertyEnum::EMAIL_ADDRESS
    ];
    
    /**
     * Map from full to short property name
     * @param string $propertyFullName
     * @return string|NULL
     */
    final public static function toShortName(string $propertyFullName): ?string
    {
        return PropertyEnum::isValid($propertyFullName) ?
            self::TO_SHORT_NAME_MAPPER[$propertyFullName] : null;
    }
    
    /**
     * Map from short to full property name
     * @param string $propertyShortName
     * @return string|NULL
     */
    final public static function toFullName(string $propertyShortName): ?string
    {
        return PropertyEnum::isValid($propertyShortName, true) ?
            self::TO_FULL_NAME_MAPPER[$propertyShortName] : null;
    }
}
