<?php
namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\Spki;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Enum\SignatureAlgorithm;

class SpkiTest extends TestCase
{

    public function testCanBeCreated(): void
    {
        $spki = new Spki(PrivateKey::create());
        $this->assertInstanceOf(Spki::class, $spki);

        $spki = new Spki(PrivateKey::create(), 'asdasda');
        $this->assertInstanceOf(Spki::class, $spki);

        foreach (SignatureAlgorithm::getAll() as $method) {
            $spki = new Spki(PrivateKey::create(), null, $method);
            $this->assertInstanceOf(Spki::class, $spki);
        }
    }

    public function testCanBeCreatedByStaticFactory(): void
    {
        $this->assertInstanceOf(Spki::class, Spki::create(PrivateKey::create()));
        $this->assertInstanceOf(Spki::class, Spki::create(PrivateKey::create(), 'qwesdfrty'));

        foreach (SignatureAlgorithm::getAll() as $method) {
            $this->assertInstanceOf(Spki::class, Spki::create(PrivateKey::create(), null, $method));
        }
    }

    public function testCanLoadFromString(): void
    {
        // TODO test
    }

    public function testCanVerify(): void
    {
        // TODO test
    }

    public function testCanExport(): void
    {
        // TODO test
    }

    public function testCanExportChallenge(): void
    {
        // TODO test
    }
}

