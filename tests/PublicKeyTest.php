<?php
namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\Key as KeyHelper;

class PublicKeyTest extends TestCase
{
    public function testCanBeCreatedFromPrivateKey(): void
    {
        $this->assertInstanceOf(PublicKey::class, PrivateKey::create()->getPublicKey());
    }

    public function testCanBeLoadedFromString(): void
    {
        $this->assertInstanceOf(
            PublicKey::class,
            new PublicKey(KeyHelper::generateNewPublicKeyBody())
        );
        $this->assertInstanceOf(
            PublicKey::class,
            PublicKey::create(KeyHelper::generateNewPublicKeyBody())
        );
        $this->assertInstanceOf(
            PublicKey::class,
            PublicKey::create()->load(KeyHelper::generateNewPublicKeyBody())
        );
    }

    public function testCanExport(): void
    {
        //TODO unit tests
    }

    public function testCanExportToFile(): void
    {
        //TODO unit tests
    }

    public function testCanEncrypt(): void
    {
        $collection = KeyHelper::encryptRandomContent(true, 10);
        foreach ($collection as $dataSet) {
            /** @var CryptionDataSet $dataSet */
            $this->assertInstanceOf(PublicKey::class, $dataSet->getKey()->getPublicKey());
            $this->assertIsString($dataSet->getEncryptedContent());
            $this->assertNotEmpty($dataSet->getEncryptedContent());
            $this->assertEquals(
                $dataSet->getRawContent(),
                $dataSet->getKey()->decrypt(
                    $dataSet->getKey()->getPublicKey()->encrypt($dataSet->getRawContent())
                )
            );
        }
    }

    public function testCanDecrypt(): void
    {
        $collection = KeyHelper::encryptRandomContent();
        foreach ($collection as $dataSet) {
            /** @var CryptionDataSet $dataSet */
            $this->assertInstanceOf(PublicKey::class, $dataSet->getKey()->getPublicKey());
            $this->assertIsString($dataSet->getRawContent());
            $this->assertNotEmpty($dataSet->getRawContent());
            $this->assertEquals(
                $dataSet->getRawContent(),
                $dataSet->getKey()->getPublicKey()->decrypt($dataSet->getEncryptedContent())
            );
        }
    }

    public function testCanVerify(): void
    {
        //TODO tests
    }
}
