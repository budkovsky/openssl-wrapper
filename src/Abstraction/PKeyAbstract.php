<?php
namespace Budkovsky\OpenSslWrapper\Abstraction;

use Budkovsky\OpenSslWrapper\Enum\Padding as PaddingEnum;
use Budkovsky\OpenSslWrapper\Exception\PaddingException;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Entity\PKeyDetails;

abstract class PKeyAbstract implements KeyInterface
{
    /** @var resource */
    protected $keyResource;
    
    public function __destruct()
    {
        openssl_free_key($this->keyResource);
    }
    
    abstract public function load(string $body);

    abstract public static function create();
    
    abstract public function export(): string;
    
    public function getRaw(): string
    {
        return $this->export();
    }
    
    public function exportToFile(string $target, string $passphrase = '', ?ConfigArgs $configArgs = null): PKeyAbstract
    {
        $success = openssl_pkey_export_to_file(
            $this->keyResource, 
            $target, 
            $passphrase, 
            $configArgs ? $configArgs->toArray() : null);
        if (!$success) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        
        return $this;
    }
    
    /**
     * Returns the key details
     * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
     * @return PKeyDetails
     */
    public function getDetails(): PKeyDetails
    {
        return PKeyDetails::factory(openssl_pkey_get_details($this->keyResource));
    }

    public function decrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): string
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
