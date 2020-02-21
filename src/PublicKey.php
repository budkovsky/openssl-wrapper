<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Enum\SignatureAlgorithm;

/**
 * Public key
 */
class PublicKey extends PKeyAbstract
{
    /**
     * PublicKey constructor
     * @param string $body
     */
    public function __construct(?string $body = null)
    {
        if ($body) {
            $this->load($body);
        }
    }

    /**
     * Static factory
     * @param string $body
     */
    public static function create(?string $body = null)
    {
        return new static($body);
    }

    public function load(string $body): PublicKey
    {
        $resource = openssl_pkey_get_public($body);
        if ($resource === false) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        $this->keyResource = $resource;

        return $this;
    }

    /**
     * {@inheritDoc}
     * TODO unit tests
     */
    public function export(): string
    {
        return $this->getDetails()->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function exportToFile(string $filePath): PublicKey
    {
        if (!file_put_contents($filePath, $this->export())) {
            throw new KeyException("Error while exporting public to file: `$filePath`");
        }

        return $this;
    }

    /**
     * Verify signature
     * @see https://www.php.net/manual/en/function.openssl-verify.php
     * @param string $content
     * @param string $signature
     * @param string $signatureAlgorithm
     * @throws KeyException
     * @return int
     */
    public function verify(
        string $content,
        string $signature,
        string $signatureAlgorithm = SignatureAlgorithm::RSA_SHA256
    ): int {
        if (!SignatureAlgorithm::isValid($signatureAlgorithm)) {
            throw new KeyException("Invalid algoritm to verify signature: `$signatureAlgorithm`");
        }

        return openssl_verify($content, $signature, $this->keyResource, $signatureAlgorithm);
    }

    /**
     * {@inheritDoc}
     */
    protected function executeEncryption(string $data, int $padding): ?string
    {
        $crypted = null;
        $success = openssl_public_encrypt($data, $crypted, $this->keyResource, $padding);

        return $success ? $crypted : null;
    }

    /**
     * {@inheritDoc}
     */
    protected function executeDecryption(string $data, int $padding): ?string
    {
        $decrypted = null;
        $success = openssl_public_decrypt($data, $decrypted, $this->keyResource, $padding);

        return $success ? $decrypted : null;
    }
}
