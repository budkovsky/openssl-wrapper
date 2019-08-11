<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Entity\X509Data;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

class X509 implements KeyInterface
{
    /** @var resource */
    protected $x509Resource;
    
    /** @var X509Data */
    protected $x509Data;
    
    /**
     * The Constructor
     * @param string $content
     */
    public function __construct(
        bool $new = false, 
        ?Csr $csr = null, 
        ?PrivateKey $privateKey = null, 
        int $days = 365,
        ?KeyInterface $caCert = null,
        ?ConfigArgs $configArgs = null,
        int $serial = 0
    ) {
        if (!$new) {
            return;
        }
            
        if(!$csr || !$privateKey) {
            throw new KeyException('CSR or PrivateKey not set, both are needed parameters to create a new X509 certificate');
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
     * The Destructor
     */
    public function __destruct()
    {
        openssl_x509_free($this->x509Resource);
    }


    /**
     * {@inheritDoc}
     * @param string  $content
     * @return X509
     */
    public static function create(
        bool $new = false,
        ?Csr $csr = null,
        ?PrivateKey $privateKey = null,
        int $days = 365,
        ?KeyInterface $caCert = null,
        ?ConfigArgs $configArgs = null,
        int $serial = 0
    ) {
        return new static($new, $csr, $privateKey, $days, $caCert,$configArgs, $serial);
    }
    
    /**
     * Reads certificate, creates resource, parses X509 data and calculates fingerprint
     * @see https://www.php.net/manual/en/function.openssl-x509-read.php
     * @see https://www.php.net/manual/en/function.openssl-x509-parse.php
     * {@inheritDoc}
     */
    public function load(string $content): X509
    {
        $this->x509Resource = openssl_x509_read($content) ?? null;
        if ($this->x509Resource) {
            $this->setX509Data();
        }
        
        return $this;
    }
    
    protected function setX509Data(bool $shortNames = true): X509
    {
        $this->x509Data = new X509Data(openssl_x509_parse($this->x509Resource, $shortNames));
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
        //TODO args to object?
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
}
