<?php
namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * SignatureAlgorithm enumeration
 */
class SignatureAlgorithm extends EnumAbstract
{
    const RSA_SHA1 = 'sha1WithRSAEncryption';
    const RSA_SHA224 = 'sha224WithRSAEncryption';
    const RSA_SHA256 = 'sha256WithRSAEncryption';
    const RSA_SHA384 = 'sha384WithRSAEncryption';
    const RSA_SHA512 = 'sha512WithRSAEncryption';

    /**
     * {@inheritDoc}
     */
    public static function getAll(): array
    {
        return [
            'RSA_SHA1' => self::RSA_SHA1,
            'RSA_SHA224' => self::RSA_SHA224,
            'RSA_SHA256' => self::RSA_SHA256,
            'RSA_SHA384' => self::RSA_SHA384,
            'RSA_SHA512' => self::RSA_SHA512
        ];
    }
}
