<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\Key as KeyHelper;
use Budkovsky\OpenSslWrapper\PublicKey;

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
        $collection = KeyHelper::encryptRandomContent();
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
        $collection = KeyHelper::encryptRandomContent(true);
        foreach ($collection as $dataSet) {
            /** @var CryptionDataSet $dataSet */
            $this->assertInstanceOf(PrivateKey::class, $dataSet->getKey());
            $this->assertEquals(
                $dataSet->getRawContent(),
                $dataSet->getKey()->decrypt($dataSet->getEncryptedContent())
            );
        }
    }
}
