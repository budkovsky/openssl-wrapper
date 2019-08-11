<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\KeyInterface;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;

class PrivateKey implements KeyInterface, StaticFactoryInterface
{
    /** @var resource */
    protected $keyResource;
    
    public function __construct()
    {
        
    }
    
    public function __destruct()
    {
        openssl_free_key($this->keyResource);
    }
    
    public function load(string $content, $passphrase = ''): PrivateKey
    {
        //TODO implement validation and error reporting
        $this->keyResource = openssl_pkey_get_private($content, $passphrase) ?? null;
        
        return $this;
    }
    
    public function create(): PrivateKey
    {
        return new static;
    }
    
    public function getRaw(): string
    {
        
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
    {
        
    }
}
