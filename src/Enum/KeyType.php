<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Enum;

abstract class KeyType
{
    const DSA = OPENSSL_KEYTYPE_DSA; 
    const DH = OPENSSL_KEYTYPE_DH;
    const RSA = OPENSSL_KEYTYPE_RSA;
    const EC = OPENSSL_KEYTYPE_EC;
    
    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [
            'DSA' => self::DSA,
            'DH' => self::DH,
            'RSA' => self::RSA,
            'EC' => self::EC
        ];
    }
}