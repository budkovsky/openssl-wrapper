<?php
namespace Budkovsky\OpenSslWrapper\Abstraction;

use Budkovsky\OpenSslWrapper\Enum\Padding as PaddingEnum;
use Budkovsky\OpenSslWrapper\Exception\PaddingException;

abstract class PKeyAbstract implements KeyInterface
{
    /** @var resource */
    protected $keyResource;
    
    public function __destruct()
    {
        openssl_free_key($this->keyResource);
    }
    
    abstract public function load(string $content);

    abstract public function create();

    public function getRaw()
    {}
    
    

    public function decrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): ?string
    {
        if (!PaddingEnum::isValid($padding)) {
            throw new PaddingException(sprintf(
                "Invalid OpenSSL padding parameter for decryption: `%s`. Valid values are: `%s`",
                $padding,
                implode('`, `', PaddingEnum::getAll())
            ));
        }
        
        return $this->executeDecryption($data, $padding);
    }
    
    public function encrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): ?string
    {
        if (!PaddingEnum::isValid($padding)) {
            throw new PaddingException(sprintf(
                "Invalid OpenSSL padding parameter for encryption: `%s`. Valid values are: `%s`",
                $padding,
                implode('`, `', PaddingEnum::getAll())
                ));
        }
        
        return $this->executeEncryption($data, $padding);
    }
   
    abstract protected function executeDecryption(string $data, int $padding): ?string;
    
    abstract protected function executeEncryption(string $data, int $padding): ?string;
}
