<?php
namespace Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

class Pkcs7Flag extends EnumAbstract
{
    const TEXT = PKCS7_TEXT;
    const BINARY = PKCS7_BINARY;
    const NOINTERN = PKCS7_NOINTERN;
    const NOVERIFY = PKCS7_NOVERIFY;
    const NOCHAIN = PKCS7_NOCHAIN;
    const NOCERTS = PKCS7_NOCERTS;
    const NOATTR = PKCS7_NOATTR;
    const DETACHED = PKCS7_DETACHED;
    const NOSIGS = PKCS7_NOSIGS;
    
    public static function getAll(): array
    {
        return [
            'TEXT' => self::TEXT,
            'BINARY' => self::BINARY,
            'NOINTERN' => self::NOINTERN,
            'NOVERIFY' => self::NOVERIFY,
            'NOCHAIN' => self::NOCHAIN,
            'NOCERTS' => self::NOCERTS,
            'NOATTR' => self::NOATTR,
            'DETACHED' => self::DETACHED,
            'NOSIGS' => self::NOSIGS
        ];
    }
}
