<?php
/**
 * 2019 Budkovsky
 * @see https://www.php.net/manual/en/openssl.certparams.php
 * @see https://www.php.net/manual/en/ref.openssl.php
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Entity\CsrSubject;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;

/**
 * Certificate Signing Request
 */
class Csr implements StaticFactoryInterface
{
    /** @var string */
    protected $csrResource;
    
    public function __construct( 
        PrivateKey $privateKey, 
        ?CsrSubject $subject = null, 
        ?string $passphrase = null,
        ?ConfigArgs $configArgs = null, 
        ?array $extraAttribs = null
    ) {
        $privateKeyBody = $privateKey->export($passphrase); //must be set to variable for passing by reference
        $this->csrResource = openssl_csr_new(
            $subject ? $subject->toArray() : [], 
            $privateKeyBody, 
            $configArgs ? $configArgs->toArray() : null,
            $extraAttribs
        );
    }
    
    /**
     * Static factory
     * {@inheritDoc}
     */
    public static function create(
        PrivateKey $privateKey = null,
        ?CsrSubject $subject = null,
        ?string $passphrase = null,
        ?ConfigArgs $configArgs = null,
        ?array $extraAttribs = null): Csr
    {
        return new static($privateKey, $subject, $passphrase, $configArgs, $extraAttribs);
    }
    
    /**
     * Exports a CSR to a file
     * https://www.php.net/manual/en/function.openssl-csr-export-to-file.php
     * @param string $outFileName
     * @param bool $notext
     * @return bool
     */
    public function exportToFile(string $outFileName, bool $notext = true) : bool
    {
        return openssl_csr_export_to_file($this->csrResource, $outFileName, $notext);
    }
    
    /**
     * Exports a CSR as a string
     * @see https://www.php.net/manual/en/function.openssl-csr-export.php
     * @param bool $notext
     * @return string|NULL
     */
    public function export(bool $notext = true): ?string
    {
        $out = null;
        openssl_csr_export($this->csrResource, $out, $notext);
        
        return $out ?? null;
    }
    
    /**
     * Returns the public key of a CSR
     * @see https://www.php.net/manual/en/function.openssl-csr-get-public-key.php
     * @return PublicKey|NULL
     */
    public function getPublicKey(bool $shortNames = true): ?PublicKey
    {
        $publicKeyDetails = openssl_pkey_get_details(
            openssl_csr_get_public_key($this->csrResource, $shortNames)
        );
        return PublicKey::create($publicKeyDetails['key']) ;
    }
    
    /**
     * Returns the subject of a CSR
     * @param bool $use_shortnames
     * @return CsrSubject
     */
    public function getSubject(bool $use_shortnames = true): CsrSubject
    {
        return new CsrSubject(openssl_csr_get_subject($this->csrResource));
    }
    
    /** @see https://www.php.net/manual/en/function.openssl-csr-sign.php */
    public function sign(
        PrivateKey $privateKey, 
        int $days = 365, 
        KeyInterface $caCert = null, 
        ?ConfigArgs 
        $configArgs = null, 
    $serial = 0): X509 {
        return X509::create(
            true, $this, $privateKey, $days, $caCert, $configArgs, $serial
        );
    }
}
