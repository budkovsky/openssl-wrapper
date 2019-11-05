<?php
namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\Keystore;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Csr;
use Budkovsky\OpenSslWrapper\X509;
use Budkovsky\OpenSslWrapper\PublicKey;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Entity\CsrSubject;

class KeystoreTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Keystore::class, new Keystore());
    }

    public function testCanBeCreatedByStaticFactory(): void
    {
        $this->assertInstanceOf(Keystore::class, Keystore::create());
    }

    public function testCanBeImportedFromFile(): void
    {
        $keystore = Keystore::create()->importFromFile(__DIR__.'/../docs/example/pkijs_pkcs12.p12');

        $this->assertNotEmpty($keystore->getPrivateKey()->export());
        $this->assertIsString($keystore->getPrivateKey()->export());
        $this->assertRegExp(
            '/^-----BEGIN PRIVATE KEY-----.*?-----END PRIVATE KEY-----$/s',
            $keystore->getPrivateKey()->export()
        );

        $this->assertNotEmpty($keystore->getCertificate()->export());
        $this->assertIsString($keystore->getCertificate()->export());
        $this->assertRegExp(
            '/^-----BEGIN CERTIFICATE-----.*?-----END CERTIFICATE-----$/s',
            $keystore->getCertificate()->export()
        );
    }

    public function testCanBeExportedToFile(): void
    {
        $privateKey = new PrivateKey();

        $keystore = Keystore::create()
            ->setPrivateKey($privateKey)
            ->setCertificate(Csr::create($privateKey)->sign($privateKey))
        ;

        $filename = \sprintf('/tmp/%s.p12', \uniqid());

        $keystore->exportToFile($filename);

        $this->assertNotEmpty(\realpath($filename));
        $this->assertIsString(\realpath($filename));
        $this->assertNotEmpty(\file_get_contents($filename));
    }

    public function testCanBeExportedToP12(): void
    {
        $key = new PrivateKey();
        $certificate = Csr::create(
                $key,
                CsrSubject::create()
                ->setCommonName($name = ('testowski'))
                ->setStateOrProvince('Oklahoma OKH')
                ->setOrganizationName('ACME Ltd')
            )
            ->sign($key)
        ;
       Keystore::create()
            ->setPrivateKey($key)
            ->setCertificate($certificate)
            ->exportToFile($filename = sprintf('tmp/KS-%s.p12', \uniqid()))
        ;

        var_dump(\base64_encode(\file_get_contents($filename))); die;
    }
}
