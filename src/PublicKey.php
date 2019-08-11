<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

class PublicKey extends PKeyAbstract
{

    public function create()
    {}

    public function load(string $content): PublicKey
    {
        $resource = openssl_pkey_get_public($content);
        if ($resource === false) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        $this->keyResource = $resource;
        
        return $this;
    }

    protected function executeEncryption(string $data, int $padding): ?string
    {
        $crypted = null;
        $success = openssl_public_encrypt($data, $crypted, $this->keyResource, $padding);
        
        return $success ? $crypted : null;
    }

    protected function executeDecryption(string $data, int $padding)
    {
        $decrypted = null;
        $success = openssl_public_decrypt($data, $decrypted, $this->keyResource, $padding);
        
        return $success ? $decrypted : null;
    }
}

