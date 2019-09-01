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
     * Loads key from a string
     * @param string $body PEM key string
     */
    public function load(string $body);

    /**
     * Returns key string
     * @return string
     */
    public function export(): string;

    /**
     * Exports key string to a file
     * @param string $filePath Path for file to export
     */
    public function exportToFile(string $filePath);
}
