<?php
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\PKeyAbstract;
use Budkovsky\OpenSslWrapper\Exception\KeyException;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

class PublicKey extends PKeyAbstract
{
    public function __construct(?string $keyBody = null)
    {
        if ($keyBody) {
            $this->load($keyBody);
        }
    }
    
    /**
     * Static factory
     * @param string $keyBody
     */
    public static function create(?string $keyBody = null)
    {
        return new static($keyBody);
    }

    public function load(string $keyBody): PublicKey
    {
        $resource = openssl_pkey_get_public($keyBody);
        if ($resource === false) {
            throw new KeyException(OpenSSL::getErrorString());
        }
        $this->keyResource = $resource;
        
        return $this;
    }
    
    /**
     * Verify signature
     * @see https://www.php.net/manual/en/function.openssl-verify.php
     * @param string $data
     * @param string $signature
     * @param string $signatureAlgorithm
     * @throws KeyException
     * @return int
     */
    public function verify(string $data, string $signature, string $signatureAlgorithm = 'sha1'): int
    {
        if (!in_array($signatureAlgorithm, OpenSSL::getMessageDigestMethods(true))) {
            throw new KeyException("Invalid method digest parameter: `$signatureAlgorithm`");
        }
        
        return openssl_verify($data, $signature, $this->keyResource, $signatureAlgorithm);
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
