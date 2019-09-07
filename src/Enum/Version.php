<?php
namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * Version enumeration
 */
class Version extends EnumAbstract
{
    const TEXT = OPENSSL_VERSION_TEXT;
    const NUMBER = OPENSSL_VERSION_NUMBER;

    /**
     * {@inheritDoc}
     */
    public static function getAll()
    {
        return [
            'TEXT' => self::TEXT,
            'NUMBER' => self::NUMBER
        ];
    }
}
