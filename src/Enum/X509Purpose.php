<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Enum;

use Budkovsky\OpenSslWrapper\Abstraction\EnumAbstract;

/**
 * X509Purpose enumeration
 * @see https://www.php.net/manual/en/openssl.purpose-check.php
 */
class X509Purpose extends EnumAbstract
{
    const SSL_CLIENT = X509_PURPOSE_SSL_CLIENT;
    const SSL_SERVER = X509_PURPOSE_SSL_SERVER;
    const NS_SSL_SERVER = X509_PURPOSE_NS_SSL_SERVER;
    const SMIME_SIGN = X509_PURPOSE_SMIME_SIGN;
    const SMIME_ENCRYPT = X509_PURPOSE_SMIME_ENCRYPT;
    const CRL_SIGN = X509_PURPOSE_CRL_SIGN;
    const ANY = X509_PURPOSE_ANY;

    /**
     * {@inheritDoc}
     */
    public static function getAll(): array
    {
        return [
            'SSL_CLIENT' => self::SSL_CLIENT,
            'SSL_SERVER' => self::SSL_SERVER,
            'NS_SSL_SERVER' => self::NS_SSL_SERVER,
            'SMIME_SIGN' => self::SMIME_SIGN,
            'SMIME_ENCRYPT' => self::SMIME_ENCRYPT,
            'CRL_SIGN' => self::CRL_SIGN,
            'ANY' => self::ANY
        ];
    }
}
