<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * Padding enumeration
 */
class Padding extends EnumAbstract
{
    const PKCS1_PADDING = OPENSSL_PKCS1_PADDING;
    const SSLV23_PADDING = OPENSSL_SSLV23_PADDING;
    const NO_PADDING = OPENSSL_NO_PADDING;
    const PKCS1_OAEP_PADDING = OPENSSL_PKCS1_OAEP_PADDING;

    /**
     * {@inheritDoc}
     */
    public static function getAll(): array
    {
        return [
            'PKCS1_PADDING' => self::PKCS1_PADDING,
            'SSLV23_PADDING' => self::SSLV23_PADDING,
            'NO_PADDING' => self::NO_PADDING,
            'PKCS1_OAEP_PADDING' => self::PKCS1_OAEP_PADDING
        ];
    }
}
