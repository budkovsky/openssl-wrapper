<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Exception\ComputeDigestException;
use Budkovsky\ObjectOpenSSL\Entity\CertLocations;

/**
 * OpenSSL object-oriented wrapper for PHP
 * @see https://www.php.net/manual/en/book.openssl.php
 */
class OpenSslWrapper implements StaticFactoryInterface
{
    
    public static function create(): OpenSslWrapper
    {
        return new static;
    }

    /**
     * Gets the cipher iv length
     * @see https://www.php.net/manual/en/function.openssl-cipher-iv-length.php
     * @param string $method
     * @return int
     */
    public static function cipherIvLength(string $method): int
    {
        return openssl_cipher_iv_length($method);
    }

    /** @see https://www.php.net/manual/en/function.openssl-decrypt.php */
    public static function decrypt(
        string $data,
        string $method,
        KeyInterface $key,
        int $options = 0,
        string $iv = '',
        string $tag = '',
        string $aditionalAuthenticationData = ''
    ): ?string {
        //TODO implentation & validation
        return openssl_decrypt(
            $data,
            $method,
            $key->getRaw(),
            $options,
            $iv,
            $tag,
            $aditionalAuthenticationData
        ) ?? null;
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
        if (!in_array($method, static::getMessageDigestMethods(true))) {
            throw new ComputeDigestException("Invalid digest method: $method");
        }
        
        return openssl_digest($data, $method, $rawOutput);
    }
    
    /** @see https://www.php.net/manual/en/function.openssl-decrypt.php */
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
            return openssl_encrypt(
                $data,
                $method,
                $key->getRaw(),
                $options,
                $iv,
                $tag,
                $aditionalAuthenticationData,
                $tagLength
                ) ?? null;
    }
    
    public static function getErrorString(): string
    {
        return openssl_error_string();
    }
    
    public static function getCertLocations(): CertLocations
    {
        return CertLocations::getInstance();
    }
    
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
    public static function getMessageDigestMethods(bool $asliases = false): array 
    {
        return openssl_get_md_methods($asliases);
    }
    
    
    
    
}
