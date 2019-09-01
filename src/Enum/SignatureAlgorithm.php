<?php
namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * SignatureAlgorithm enumeration
 */
class SignatureAlgorithm extends EnumAbstract
{

    //const DSS1 = OPENSSL_ALGO_DSS1;
    const SHA1 = OPENSSL_ALGO_SHA1;
    const SHA224 = OPENSSL_ALGO_SHA224;
    const SHA256 = OPENSSL_ALGO_SHA256;
    const SHA384 = OPENSSL_ALGO_SHA384;
    const SHA512 = OPENSSL_ALGO_SHA512;
    const RMD160 = OPENSSL_ALGO_RMD160;
    const MD5 = OPENSSL_ALGO_MD5;
    const MD4 = OPENSSL_ALGO_MD4;
    //const MD2 = OPENSSL_ALGO_MD2;

    /**
     * {@inheritDoc}
     */
    public static function getAll(): array
    {
        return [
            //'DSS1' => self::DSS1,
            'SHA1' => self::SHA1,
            //'SHA224' => self::SHA224,
            'SHA256' => self::SHA256,
            'SHA384' => self::SHA384,
            'SHA512' => self::SHA512,
            'RMD160' => self::RMD160,
            'MD5' => self::MD5,
            'MD4' => self::MD4,
            //'MD2' => self::MD2
        ];
    }
}
