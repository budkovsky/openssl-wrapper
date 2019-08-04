<?php
/**
 * 2019 Budkovsky
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Enum;

abstract class CryptOption
{
    const RAW_DATA = OPENSSL_RAW_DATA;
    const ZERO_PADDING = OPENSSL_ZERO_PADDING;
    
    public static function getAll(): array
    {
        return [
            'RAW_DATA' => self::RAW_DATA,
            'ZERO_PADDING' => self::ZERO_PADDING
        ];
    }
}
