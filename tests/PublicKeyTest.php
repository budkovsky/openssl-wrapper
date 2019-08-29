<?php
namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\KeyTestHelper as KeyHelper;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

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
        $publicKey = PrivateKey::create()->getPublicKey();
        $this->assertIsString($publicKey->export());
        $this->assertNotEmpty($publicKey->export());
    }

    public function testCanExportToFile(): void
    {
        $publicKey = PrivateKey::create()->getPublicKey();
        $filePath = sprintf(
            '%s/%s.pem',
            $_SERVER['TEMP'],
            bin2hex(OpenSSL::getRandomPseudoBytes(10))
        );
        $publicKey->exportToFile($filePath);
        $this->assertFileExists($filePath);
        $this->assertNotEmpty(file_get_contents($filePath));
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
        $content = bin2hex(OpenSSL::getRandomPseudoBytes(1000));
        $privateKey = PrivateKey::create();
        $signature = $privateKey->sign($content);
        $this->assertEquals(1, $privateKey->getPublicKey()->verify($content, $signature));
    }
}
