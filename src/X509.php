<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;

class X509 implements KeyInterface
{
    /** @resource */
    protected $x509Resource;
    
    public function load($content)
    {}

    public function create()
    {}
    public static function getRaw(): string
    {}

    public function exportToPkcs12File(
        string $filename, 
        PrivateKey $privateKey,
        string $password,
        array $args = []
        ): ?X509 {
        //TODO implementation
        //TODO args to object?
            return openssl_pkcs12_export_to_file($this->x509Resource, $filename, $privateKey->getRaw(), $password, $args) ? $this : null;
    }
    
    public function exportToPkcs12(PrivateKey $privateKey, string $password, array $args=[]): ?string
    {
        //TODO implementation
        //TODO args to object?
        $output = null;        
        $success = openssl_pkcs12_export($this->x509Resource, $output, $privateKey->getRaw(), $password, $args);
        
        return $success ? $output : null;
    }
    
    public function free()
    {}

}
