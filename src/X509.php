<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Entity\X509Data;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Enum\X509Purpose as PurposeEnum;
use Budkovsky\OpenSslWrapper\Exception\X509Exception;

class X509 implements KeyInterface
{
    /** @var resource */
    protected $x509Resource;

    /** @var X509Data */
    protected $x509Data;

    /**
     * X509 constructor
     * @param string $content
     */
    public function __construct(
        ?Csr $csr = null,
        ?PrivateKey $privateKey = null,
        int $days = 365,
        ?KeyInterface $caCert = null,
        ?ConfigArgs $configArgs = null,
        int $serial = 0
    ) {
        if(!$csr || !$privateKey) {
            return;
        }

        $this->x509Resource = openssl_csr_sign(
            $csr->export(),
            $caCert ? $caCert->export() : null,
            $privateKey->export(),
            $days,
            $configArgs ? $configArgs->toArray() : null,
            $serial
        ) ?? null;
        $this->setX509Data();
    }

    /**
     * X509 destructor
     */
    public function __destruct()
    {
        if ($this->x509Resource) {
            openssl_x509_free($this->x509Resource);
        }
    }

    /**
     * {@inheritDoc}
     * @param string $content
     * @return X509
     */
    public static function create(
        ?Csr $csr = null,
        ?PrivateKey $privateKey = null,
        int $days = 365,
        ?KeyInterface $caCert = null,
        ?ConfigArgs $configArgs = null,
        int $serial = 0
    ) {
        return new static($csr, $privateKey, $days, $caCert,$configArgs, $serial);
    }

    /**
     * Reads certificate, creates resource, parses X509 data and calculates fingerprint
     * @see https://www.php.net/manual/en/function.openssl-x509-read.php
     * @see https://www.php.net/manual/en/function.openssl-x509-parse.php
     * {@inheritDoc}
     */
    public function load(string $body): X509
    {
        $this->x509Resource = openssl_x509_read($body) ?? null;
        if ($this->x509Resource) {
            $this->setX509Data();
        }

        return $this;
    }

    protected function setX509Data(bool $shortNames = true): X509
    {
        $this->x509Data = new X509Data(openssl_x509_parse($this->x509Resource, $shortNames));

        return $this;
    }

    /**
     * Exports a PKCS#12 Compatible Certificate Store File
     * @see https://www.php.net/manual/en/function.openssl-pkcs12-export-to-file.php
     * @param string $filename
     * @param PrivateKey $privateKey
     * @param string $password
     * @param array $args
     * @return X509|NULL
     */
    public function exportToPkcs12File(string $filename, PrivateKey $privateKey, string $password, array $args = []): ?X509
    {
        //TODO implementation
        //TODO $args to object?
        return openssl_pkcs12_export_to_file($this->x509Resource, $filename, $privateKey->export(), $password, $args) ? $this : null;
    }

    /**
     * Exports a PKCS#12 Compatible Certificate Store File to variable
     * @see https://www.php.net/manual/en/function.openssl-pkcs12-export.php
     * @param PrivateKey $privateKey
     * @param string $password
     * @param array $args
     * @return string|NULL
     */
    public function exportToPkcs12(PrivateKey $privateKey, string $password, array $args=[]): ?string
    {
        //TODO implementation
        //TODO args to object?
        $output = null;
        $success = openssl_pkcs12_export($this->x509Resource, $output, $privateKey->getRaw(), $password, $args);

        return $success ? $output : null;
    }

    /**
     * Exports a certificate as a string
     * @see https://www.php.net/manual/en/function.openssl-x509-export.php
     * {@inheritDoc}
     * @param bool $noText
     * @return string
     */
    public function export(bool $noText = true): string
    {
        $output = null;
        $success = openssl_x509_export($this->x509Resource, $output, $noText);
        if (!$success) {
            throw new KeyException(OpenSSL::getErrorString());
        }

        return $output;
    }

    /**
     * Exports a certificate to file
     * @see https://www.php.net/manual/en/function.openssl-x509-export-to-file.php
     * {@inheritDoc}
     * @param string $filePath
     * @param bool $noText
     * @return X509
     */
    public function exportToFile(string $filePath, bool $noText = true): X509
    {
        $success = openssl_x509_export_to_file($this->x509Resource, $filePath, $noText);
        if (!$success) {
            throw new KeyException(OpenSSL::getErrorString());
        }

        return $this;
    }

    /**
     * Calculates the fingerprint, or digest, of a given X.509 certificate
     * @see https://www.php.net/manual/en/function.openssl-x509-fingerprint.php
     * @param string $hashAlgorithm
     * @param bool $rawOutput
     * @throws KeyException
     * @return string|NULL
     */
    public function getFingerprint(string $hashAlgorithm = 'sha1', bool $rawOutput = false): ?string
    {
        if (!OpenSSL::isDigestMethodValid($hashAlgorithm)) {
            throw new KeyException("Invalid hash algorithm: `$hashAlgorithm`");
        }

        return openssl_x509_fingerprint($this->x509Resource, $hashAlgorithm, $rawOutput) ?? null;
    }

    /**
     * Checks if a private key corresponds to a certificate
     * @see https://www.php.net/manual/en/function.openssl-x509-check-private-key.php
     * @param PrivateKey $privateKey
     * @param string $passphrase
     * @param ConfigArgs $configArgs
     * @return bool
     */
    public function checkPrivateKey(PrivateKey $privateKey, string $passphrase = null, ?ConfigArgs $configArgs = null): bool
    {
        return openssl_x509_check_private_key(
            $this->x509Resource,
            $privateKey->export($passphrase, $configArgs)
        );
    }

    /**
     * Verifies if a certificate can be used for a particular purpose
     * @see https://www.php.net/manual/en/function.openssl-x509-checkpurpose.php
     * @see \Budkovsky\OpenSslWrapper\Enum\X509Purpose
     * @param int $purpose
     * @param array $CAinfo Should be an array of trusted CA files/dirsas described in https://www.php.net/manual/en/openssl.cert.verification.php
     * @param String $untrustedFile If specified, this should be the name of a PEM encoded file holdingcertificates that can be used to help verify the certificate, althoughno trust is placed in the certificates that come from that file.
     * @throws X509Exception
     * @return int Returns TRUE if the certificate can be used for the intended purpose, FALSE if it cannot, or NULL on error
     */
    public function checkpurpose(int $purpose, array $CAinfo = [], ?String $untrustedFile = null): ?bool
    {
        if (!PurposeEnum::isValid($purpose)) {
            throw new X509Exception("Invalid X509 purpose: `$purpose`");
        }
        $result = openssl_x509_checkpurpose($this->x509Resource, $purpose, $CAinfo, $untrustedFile);

        return is_bool($result) ? $result : null;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->export();
    }
}

