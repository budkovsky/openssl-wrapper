<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Entity\CsrSubject;

class PrivateKey extends PKeyAbstract implements StaticFactoryInterface
{
    /** @var string */
    protected $passphrase = ''; 
    
    public function __construct(bool $generateNew = false, ?ConfigArgs $configArgs = null)
    {
        if ($generateNew) {
            $this->keyResource = openssl_pkey_new($configArgs ? $configArgs->toArray() : null);
        }
    }
    
    public function load(string $content, $passphrase = ''): PrivateKey
    {
        $resource = openssl_pkey_get_private($content, $passphrase) ?? null;
        if ($resource === false) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        $this->keyResource = $resource;
        
        return $this;
    }
    
    public static function create(bool $generateNew = false, ?ConfigArgs $configArgs = null): PrivateKey
    {
        return new static($generateNew, $configArgs);
    }
    
    public function encrypt(string $data, string $method)
    {}

    public function getPublicKey(CsrSubject $csrSubject, $shortNames = true, int $days=365, ?ConfigArgs $configArgs = null, ?array $extraAttribs = null): PublicKey
    {
        $csr = Csr::create(true, $csrSubject, $this, $this->passphrase, $configArgs, $extraAttribs);
        
        return $csr->getPublicKey($shortNames);
    }

//     public function getX509(CsrSubject $csrSubject, $shortNames = true, int $days=365, ?ConfigArgs $configArgs = null, ?array $extraAttribs = null): X509
//     {
//         return X509::create()
//     }
    
    public function decrypt(string $data, string $method)
    {}
    
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
