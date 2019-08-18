<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSsslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\Key as KeyHelper;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Tests\Collection\CryptionDataSetCollection;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet;

class PrivateKeyTest extends TestCase
{
    public function testCanGenerateNewKey(): void
    {
        $this->assertIsString((new PrivateKey())->export());
    }
    
    public function testCanGenerateNewKeyByStaticFactory(): void
    {
        $this->assertIsString(PrivateKey::create()->export());
    }
    
    public function testCanLoadKeyFromString(): void
    {
        $privateKeyBody = KeyHelper::generateNewPrivateKeyBody();

        $key = PrivateKey::create()->load($privateKeyBody);

        $this->assertInstanceOf(PrivateKey::class, $key);
        $this->assertEquals(
            $privateKeyBody, 
            $key->export()
        );
    }
    
    public function testCanGetPublicKey(): void
    {
        $privateKey = PrivateKey::create();
        
        $this->assertInstanceOf(PublicKey::class, $privateKey->getPublicKey());
    }
    
    public function testCanEncrypt(): void
    {
        $collection = $this->encryptRandomContent();
        foreach ($collection as $dataSet) {
            /** @var CryptionDataSet $dataSet */
            $this->assertInstanceOf(PrivateKey::class, $dataSet->getKey());
            $this->assertEquals(
                $dataSet->getEncryptedContent(), 
                $dataSet->getKey()->encrypt($dataSet->getRawContent())
            );
        }
    }
    
    public function testCanDecrypt(): void
    {
        $collection = $this->encryptRandomContent(true);
        foreach ($collection as $dataSet) {
            /** @var CryptionDataSet $dataSet */
            $this->assertInstanceOf(PrivateKey::class, $dataSet->getKey());
            $this->assertEquals(
                $dataSet->getRawContent(), 
                $dataSet->getKey()->decrypt($dataSet->getEncryptedContent())
            );
        }
    }
    
    protected function encryptRandomContent(bool $usePublicKey = false, int $collectionLength = 10): CryptionDataSetCollection
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
