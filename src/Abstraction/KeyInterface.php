<?php
/**
 * 2019 Budkovsky
 * @see https://github.com/budkovsky/object-openssl
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Abstraction;

/**
 * Interface for key/certificate types
 * @see https://www.php.net/manual/en/openssl.certparams.php
 */
interface KeyInterface
{
    /**
     * Static factory
     * @return KeyInterface
     */
    public static function create();
    
    /**
     * Load key to the object
     * @param string $content PEM key string
     * @return KeyInterface
     */
    public function load(string $content);
    
    /**
     * Return raw key string
     * @return string
     */
    public static function getRaw(): string;
    
    /**
     * @see https://www.php.net/manual/en/function.openssl-free-key.php
     * @see https://www.php.net/manual/en/function.openssl-pkey-free.php
     */
    public function free();
    
    /** @see https://www.php.net/manual/en/function.openssl-decrypt.php */
    public function decrypt(string $data, string $method);
    
    /** @see https://www.php.net/manual/en/function.openssl-encrypt.php */
    public function encrypt(string $data, string $method);
}
