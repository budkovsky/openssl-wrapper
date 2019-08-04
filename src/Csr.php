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
use Budkovsky\OpenSslWrapper\Abstraction\CsrAbstract;
use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;

/**
 * OpenSSL CSR functions object-oriented wrapper
 */
class Csr extends CsrAbstract
{
    /** @var string */
    protected $csr;
    
    
    /**
     * {@inheritDoc}
     */
    public static function create(): Csr
    {
        return new static;
    }
    /**
     * TODO implement
     * {@inheritDoc}
     */
    public function load(string $content): Csr
    {
        
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
        //TODO set resource or string to $csr variable
        return openssl_csr_export_to_file($this->csr, $outFileName, $notext);
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
        openssl_csr_export($this->csr, $out, $notext);
        
        return $out ?? null;
    }
    
    /**
     * Returns the public key of a CSR
     * @see https://www.php.net/manual/en/function.openssl-csr-get-public-key.php
     * @return KeyInterface|NULL
     */
    public function getPublicKey(): ?KeyInterface
    {
        //TODO implementation
    }
    
    /**
     * Returns the subject of a CSR
     * @param bool $use_shortnames
     * @return CsrSubject
     */
    public function getSubject(bool $use_shortnames = true): CsrSubject
    {
        return new CsrSubject(openssl_csr_get_subject($this->csr));
    }
    
    public static function new(CsrSubject $subject, KeyInterface $key, array $configArgs, array $extraAttribs): Csr
    {
        //TODO implementation
        //TODO array parameters change to types
    }

    /** @see https://www.php.net/manual/en/function.openssl-csr-sign.php */
    public function sign(KeyInterface $caCert, KeyInterface $privKey, int $days, ?ConfigArgs $csrConfigArgs = null, $serial = 0): KeyInterface
    {
        //TODO implementation
    }
    public static function getRaw(): string
    {}
    public function free()
    {}


}
