<?php
namespace Budkovsky\OpenSsslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\Csr;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Entity\CsrSubject;
use Budkovsky\OpenSslWrapper\X509;

class CsrTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Csr::class, new Csr(PrivateKey::create()));
    }
    
    public function testCanBeCreatedByStaticFactory(): void
    {
        $this->assertInstanceOf(Csr::class, Csr::create(PrivateKey::create()));
    }
    
    public function testCanBeCreatedFromPrivateKey(): void
    {
        $csr = new Csr(PrivateKey::create());
        $this->assertInstanceOf(Csr::class, $csr);
        
        $csr = Csr::create(PrivateKey::create());
        $this->assertInstanceOf(Csr::class, $csr);
    }
    
    public function testCanBeExported(): void
    {
        $body = Csr::create(PrivateKey::create())->export();
        $this->assertIsString($body);
        $this->assertNotEmpty($body);
    }
    
    public function testCanBeExportedToFile(): void
    {
        $csr = Csr::create(PrivateKey::create());
        $file = sprintf('%s/%s.pem', $_SERVER['TEMP'], md5(openssl_random_pseudo_bytes(32)));
        $this->assertTrue($csr->exportToFile($file));
        $this->assertIsString(file_get_contents($file));
        $this->assertNotEmpty($file);
        $this->assertEquals($csr->export(), file_get_contents($file));
    }
    
    public function testCanGetPublicKey(): void
    {
        $csr = Csr::create(PrivateKey::create());
        $this->assertInstanceOf(PublicKey::class, $csr->getPublicKey());
        $this->assertIsString($csr->getPublicKey()->export());
        $this->assertNotEmpty($csr->getPublicKey()->export());
    }
    
    public function testCanGetCsrSubject(): void
    {
        $commonName = 'test';
        $csr = Csr::create(
            PrivateKey::create(),
            CsrSubject::create()->setCommonName($commonName)
        );
        
        $this->assertInstanceOf(CsrSubject::class, $csr->getSubject());
        $this->assertNotEmpty($csr->getSubject()->toArray());
        $this->assertEquals($commonName, $csr->getSubject()->getCommonName());
    }
    
    public function testCanSign(): void
    {
        $csr = Csr::create(PrivateKey::create());
        $signingKey = PrivateKey::create();
        $signedCert = $csr->sign($signingKey);
        
        $this->assertInstanceOf(X509::class, $signedCert);
        $this->assertIsString($signedCert->export());
        $this->assertNotEmpty($signedCert->export());
        //TODO validate is certificate really signed
    }
}
