<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Exception\ComputeDigestException;
use Budkovsky\OpenSslWrapper\Entity\CertLocations;
use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;
use Budkovsky\OpenSslWrapper\Collection\PublicKeyCollection;
use Budkovsky\OpenSslWrapper\Entity\SealResult;
use Budkovsky\OpenSslWrapper\Collection\StringCollection;
use Budkovsky\OpenSslWrapper\Exception\OpenSSLWrapperException;

/**
 * OpenSSL object-oriented wrapper for PHP
 * @see https://www.php.net/manual/en/book.openssl.php
 */
class Wrapper
{
    use StaticClassTrait;

    /**
     * Gets the cipher iv length  for given method
     * @see https://www.php.net/manual/en/function.openssl-cipher-iv-length.php
     * @param string $method
     * @return int
     */
    public static function cipherIvLength(string $method): int
    {
        if (!static::isCipherMethodValid($method)) {
            throw new OpenSSLWrapperException("Invalid cipher method `$method`");
        }

        return openssl_cipher_iv_length($method);
    }

    /**
     * Computes a digest
     * @see https://www.php.net/manual/en/function.openssl-digest.php
     * @param string $data
     * @param string $method
     * @param bool $rawOutput
     * @throws ComputeDigestException
     * @return string
     */
    public static function computeDigest(string $data, string $method, bool $rawOutput = false): string
    {
        if (!in_array($method, static::getDigestMethods(true))) {
            throw new ComputeDigestException("Invalid digest method: $method");
        }

        return openssl_digest($data, $method, $rawOutput);
    }

    /**
     * TODO unit tests
     * @see https://www.php.net/manual/en/function.openssl-decrypt.php
     */
    public static function decrypt(
        string $data,
        string $method,
        KeyInterface $key,
        int $options = 0,
        string $iv = '',
        string $tag = '',
        string $aditionalAuthenticationData = ''
    ): ?string {
        //TODO validation
        return openssl_decrypt($data, $method, $key->export(), $options, $iv, $tag, $aditionalAuthenticationData) ?? null;
    }

    /**
     * Encrypts data
     * TODO unit tests
     * @see https://www.php.net/manual/en/function.openssl-decrypt.php
     * @param string $data
     * @param string $method
     * @param KeyInterface $key
     * @param int $options
     * @param string $iv
     * @param string $tag
     * @param string $aditionalAuthenticationData
     * @param int $tagLength
     * @return string|NULL
     */
    public static function encrypt(
        string $data,
        string $method,
        KeyInterface $key,
        int $options = 0,
        string $iv = '',
        string $tag = '',
        string $aditionalAuthenticationData = '',
        int $tagLength = 16
    ): ?string {
        //TODO implentation & validation
        return openssl_encrypt($data, $method, $key->export(), $options, $iv, $tag, $aditionalAuthenticationData, $tagLength) ?? null;
    }

    /**
     * Return openSSL error message
     * @see https://www.php.net/manual/en/function.openssl-error-string.php
     * @return string
     */
    public static function getErrorString(): ?string
    {
        return openssl_error_string() ?? null;
    }

    /**
     * Retrieve the available certificate locations
     * @see https://www.php.net/manual/en/function.openssl-get-cert-locations.php
     * @return CertLocations
     */
    public static function getCertLocations(): CertLocations
    {
        return CertLocations::getInstance();
    }

    /**
     * Gets available cipher methods
     * @see https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
     * @param bool $aliases
     * @return array
     */
    public static function getCipherMethods(bool $aliases = false): array
    {
        return openssl_get_cipher_methods($aliases);
    }

    /**
     * @see https://www.php.net/manual/en/function.openssl-get-curve-names.php
     * @return array
     */
    public static function getCurveNames(): array
    {
        return openssl_get_curve_names();
    }

    /**
     * Gets available digest methods
     * @see https://www.php.net/manual/en/function.openssl-get-md-methods.php
     * @param bool $asliases
     * @return array
     */
    public static function getDigestMethods(bool $asliases = false): array
    {
        return openssl_get_md_methods($asliases);
    }

    /**
     * Validates digest method
     * @param string $digestMethod
     * @return bool
     */
    public static function isDigestMethodValid(string $digestMethod): bool
    {
        return in_array($digestMethod, self::getDigestMethods(true));
    }

    /**
     * Validates cipher method
     * @param string $cipherMethod
     * @return bool
     */
    public static function isCipherMethodValid(string $cipherMethod): bool
    {
        return in_array($cipherMethod, self::getCipherMethods(true));
    }

    /**
     * Generate a pseudo-random string of bytes
     * @see https://www.php.net/manual/en/function.openssl-encrypt.php
     * @param int $length
     * @param bool $cryptoStrong
     * @return string|NULL
     */
    public static function getRandomPseudoBytes(int $length, bool $cryptoStrong = true): ?string
    {
        return openssl_random_pseudo_bytes($length, $cryptoStrong) ?? null;
    }

    /**
     * Seal (encrypt) data
     * @see https://www.php.net/manual/en/function.openssl-seal.php
     * TODO unit tests
     * @param string $data
     * @param PublicKeyCollection $publicKeyCollection
     * @param string $method
     * @param string $iv
     * @return SealResult|NULL Returns SealResult on success or NULL on error
     */
    public function seal(string $data, PublicKeyCollection $publicKeys, string $method = 'RC4', ?string $iv = null): ?SealResult
    {
        if (!static::isCipherMethodValid($method)) {
            throw new OpenSSLWrapperException("Invalid cipher method: `$method`");
        }

        $sealedData = null;
        $envKeys = null;
        $sealedDataLength = openssl_seal($data, $sealedData, $envKeys, $publicKeys, $method, $iv);

        return $sealedDataLength === false ? null :
            SealResult::create()
                ->setDataLength($sealedDataLength)
                ->setSealedData($sealedData)
                ->setEnvKeys(StringCollection::create($envKeys))
        ;
    }

    /**
     * Opens sealed data
     * @see https://www.php.net/manual/en/function.openssl-open.php
     * TODO unit tests
     * @param string $sealedData
     * @param string $envKey
     * @param PrivateKey $privateKey
     * @param string $passphrase
     * @param string $method
     * @param string $iv
     * @return string|NULL
     */
    public function unseal(string $sealedData, string $envKey, PrivateKey $privateKey, string $passphrase = null, string $method = 'RC4', string $iv = null): ?string
    {
        $openData = null;

        return openssl_open($sealedData, $openData, $envKey, $privateKey->export($passphrase), $method, $iv) ? $openData : null;
    }
}
