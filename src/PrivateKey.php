<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

class PrivateKey extends PKeyAbstract implements StaticFactoryInterface
{

    public function load(string $content, $passphrase = ''): PrivateKey
    {
        $resource = openssl_pkey_get_private($content, $passphrase) ?? null;
        if ($resource === false) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        $this->keyResource = $resource;
        
        return $this;
    }
    
    public function create(): PrivateKey
    {
        return new static();
    }

    public static function new(ConfigArgs $configArgs = []): ?PrivateKey
    {
        $resource = openssl_pkey_new($configArgs);
        
        $privateKey = new PrivateKey();
        $privateKey->keyResource = $resource;
        
        return $privateKey;
    }
    public function encrypt(string $data, string $method)
    {}

    public function decrypt(string $data, string $method)
    {}

    public static function getRaw(): string
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
