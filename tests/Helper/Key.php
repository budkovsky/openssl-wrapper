<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;
use Budkovsky\OpenSslWrapper\Tests\Collection\CryptionDataSetCollection;
use Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

class Key
{
    use StaticClassTrait;
    
    public static function generateNewPrivateKeyBody(): string
    {
        $keyResource = openssl_pkey_new();
        $keyBody = null;
        openssl_pkey_export($keyResource, $keyBody);
        
        return $keyBody;
    }
    
    public static function encryptRandomContent(bool $usePublicKey = false, int $collectionLength = 10): CryptionDataSetCollection
    {
        $collection = new CryptionDataSetCollection();
        
        for ($i = 0; $i < $collectionLength; $i++) {
            $key = PrivateKey::create();
            $rawContent = OpenSSL::getRandomPseudoBytes(100 + $i);
            $encryptedContent = null;
            if ($usePublicKey) {
                openssl_public_encrypt($rawContent, $encryptedContent, $key->getPublicKey()->export());
            } else {
                openssl_private_encrypt($rawContent, $encryptedContent, $key->export());
            }
            $collection->add(
                CryptionDataSet::create()
                ->setKey($key)
                ->setRawContent($rawContent)
                ->setEncryptedContent($encryptedContent)
                );
        }
        
        return $collection;
    }
}
