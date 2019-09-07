<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\X509;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\CsrTestHelper;
use Budkovsky\OpenSslWrapper\Tests\Helper\X509TestHelper;
use Budkovsky\OpenSslWrapper\Exception\OpenSSLWrapperException;

class X509Test extends TestCase
{
    public function testCanBeCreatedAsEmptybject(): void
    {
        $this->assertInstanceOf(X509::class, new X509());
        $this->assertInstanceOf(X509::class, X509::create());
    }

    public function testCaneCreatedFromCsrSign(): void
    {
        $privateKey = PrivateKey::create();
        $this->assertInstanceOf(
            X509::class,
            new X509(CsrTestHelper::getCsrExample($privateKey), $privateKey)
        );
        $anotherPrivateKey = PrivateKey::create();
        $this->assertInstanceOf(
            X509::class,
            X509::create(CsrTestHelper::getCsrExample($anotherPrivateKey), $anotherPrivateKey)
        );
    }

    public function testCanBeCreatedFromString(): void
    {
        $body = file_get_contents(__DIR__.'/asset/x509example.cert');
        $x509 = X509::create()->load($body);
        $this->assertInstanceOf(X509::class, $x509);
        $this->assertEquals($body, $x509->export());
    }

    public function testCanExport(): void
    {
        $export = X509TestHelper::getX509example()->export();
        $this->assertIsString($export);
        $this->assertNotEmpty($export);
    }

    public function testCanExportToFile(): void
    {
        $x509 = X509TestHelper::getX509example();
        $filePath = sprintf(
            '%s/%s.cert',
            sys_get_temp_dir(),
            bin2hex(openssl_random_pseudo_bytes(10))
        );
        $x509->exportToFile($filePath);
        $this->assertFileExists($filePath);
        $this->assertNotEmpty(file_get_contents($filePath));
        $this->assertEquals($x509->export(), file_get_contents($filePath));
    }

    public function testCanExportToPkcs12(): void
    {
        //TODO tests
        $this->markTestIncomplete('incomplete test: export PKCS12');
    }

    public function testCanExportToPkcs12File(): void
    {
        //TODO tests
        $this->markTestIncomplete('incomplete test: export PKCS12 to file');
    }

    public function testCanGetFingerprint(): void
    {
        $x509 = X509TestHelper::getX509example();
        $this->assertIsString($x509->getFingerprint());
        $this->assertEquals(40, strlen($x509->getFingerprint('sha1')));
        $this->assertEquals(32, strlen($x509->getFingerprint('md5')));
    }

    public function testCanCheckPrivateKey(): void
    {
        $privateKey = PrivateKey::create();
        $x509 = new X509(CsrTestHelper::getCsrExample($privateKey), $privateKey);

        $this->assertTrue($x509->checkPrivateKey($privateKey));
        $this->assertFalse($x509->checkPrivateKey(PrivateKey::create()));
    }

    public function testCanCheckPurpose(): void
    {
        $this->markTestIncomplete('incomplete test: X509 check purpose');
        throw new OpenSSLWrapperException('Not implemented: '.__METHOD__);
    }
}
