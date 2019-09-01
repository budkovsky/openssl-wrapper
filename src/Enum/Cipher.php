<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * OpenSSL cipher enumeration
 * @see https://www.php.net/manual/en/openssl.ciphers.php
 */
class Cipher extends EnumAbstract
{
    const RC2_40 = OPENSSL_CIPHER_RC2_40;
    const RC2_64 = OPENSSL_CIPHER_RC2_64;
    const RC2_128 = OPENSSL_CIPHER_RC2_128;
    const DES = OPENSSL_CIPHER_DES;
    const DES3 = OPENSSL_CIPHER_3DES;
    const AES_128_CBC = OPENSSL_CIPHER_AES_128_CBC;
    const AES_192_CBC = OPENSSL_CIPHER_AES_192_CBC;
    const AES_256_CBC = OPENSSL_CIPHER_AES_256_CBC;

    /**
     * {@inheritDoc}
     */
    public static function getAll(): array
    {
        return [
            'RC2_40' => self::RC2_40,
            'RC2_64' => self::RC2_64,
            'RC2_128' => self::RC2_128,
            'DES' => self::DES,
            '3DES' => self::DES3,
            'AES_128_CBC' => self::AES_128_CBC,
            'AES_192_CBC' => self::_AES_192_CBC,
            'AES_256_CBC' => self::AES_256_CBC
        ];
    }
}
