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
interface KeyInterface extends StaticFactoryInterface, StringableInterface
{
    /**
     * Load key from string to the object
     * @param string $body PEM key string
     * @return KeyInterface
     */
    public function load(string $body);

    /**
     * Returns raw key string
     * @return string
     */
    public function export(): string;

    /**
     * Exports raw key string to a file
     * @param string $filePath Path for file to export
     */
    public function exportToFile(string $filePath);

    /**
     * @see https://www.php.net/manual/en/function.openssl-free-key.php
     * @see https://www.php.net/manual/en/function.openssl-pkey-free.php
     */
}
