<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\KeyTestHelper as KeyHelper;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

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

    public function testCanExport(): void
    {
        $keyBody = PrivateKey::create()->export();
        $this->assertIsString($keyBody);
        $this->assertNotEmpty($keyBody);
        $this->assertEquals(
            $keyBody,
            PrivateKey::create()->load($keyBody)->export()
        );
    }

    public function testCanExportToFile(): void
    {
        $filePath = sprintf(
            '%s/%s.pem',
            $_SERVER['TEMP'],
            bin2hex(OpenSSL::getRandomPseudoBytes(16))
        );
        $privateKey = PrivateKey::create();
        $privateKey->exportToFile($filePath);
        $this->assertFileExists($filePath);
        $this->assertNotEmpty(file_get_contents($filePath));
        $this->assertEquals($privateKey->export(), file_get_contents($filePath));
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

    public function testCanSign(): void
    {
        $content = bin2hex(OpenSSL::getRandomPseudoBytes(1000));
        $signature = PrivateKey::create()->sign($content);
        $this->assertIsString($signature);
        $this->assertNotEmpty($signature);
    }
}
