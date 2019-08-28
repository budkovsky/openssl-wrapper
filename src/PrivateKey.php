<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Enum\SignatureAlgorithm;

/**
 * Private key
 * TODO unit tests for methods from PKeyAbstract
 */
class PrivateKey extends PKeyAbstract implements StaticFactoryInterface
{
    /** @var string */
    protected $passphrase = '';

    public function __construct(?ConfigArgs $configArgs = null)
    {
        $this->keyResource = openssl_pkey_new($configArgs ? $configArgs->toArray() : null);
    }

    public function load(string $body, $passphrase = ''): PrivateKey
    {
        $resource = openssl_pkey_get_private($body, $passphrase) ?? null;
        if ($resource === false) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        $this->keyResource = $resource;

        return $this;
    }

    public static function create(?ConfigArgs $configArgs = null): PrivateKey
    {
        return new static($configArgs);
    }

    public function export(string $passphrase = null, ?ConfigArgs $configArgs = null): string
    {
        $output = null;
        $success = openssl_pkey_export(
            $this->keyResource,
            $output,
            $passphrase,
            $configArgs ? $configArgs->toArray() : null
            );
        if (!$success) {
            throw new KeyException(OpenSSL::getErrorString());
        }

        return $output;
    }

    public function exportToFile(string $filePath, ?string $passphrase = null, ?ConfigArgs $configArgs = null): PKeyAbstract
    {
        $success = openssl_pkey_export_to_file(
            $this->keyResource,
            $filePath,
            $passphrase,
            $configArgs ? $configArgs->toArray() : null);
        if (!$success) {
            throw new KeyException(OpenSSL::getErrorString());
        }

        return $this;
    }

    public function getPublicKey(): PublicKey
    {
        return PublicKey::create($this->getDetails()->getKey());
    }

    /**
     * Generate signature
     * @see https://www.php.net/manual/en/function.openssl-sign.php
     * @see \Budkovsky\OpenSslWrapper\Enum\SignatureAlgorithm
     * @param string $content
     * @param int $signatureAlgorithm
     * @return string|NULL
     */
    public function sign(string $content, int $signatureAlgorithm = SignatureAlgorithm::SHA1): ?string
    {
        if (!SignatureAlgorithm::isValid($signatureAlgorithm)) {
            throw new KeyException("Invalid algorithm for verify signature: `$signatureAlgorithm`");
        }
        $signature = null;
        openssl_sign($content, $signature, $this->keyResource, $signatureAlgorithm);

        return $signature ?? null;
    }

    protected function executeEncryption(string $data, int $padding): ?string
    {
        $crypted = null;
        $success = openssl_private_encrypt($data, $crypted, $this->keyResource, $padding);

        return $success ? $crypted : null;
    }

    protected function executeDecryption(string $data, int $padding): ?string
    {
        $decrypted = null;
        $success = openssl_private_decrypt($data, $decrypted, $this->keyResource);

        return $success ? $decrypted : null;
    }
}
