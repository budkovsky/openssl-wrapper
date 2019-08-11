<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSsslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Tests\Helper\Key as KeyHelper;
use Budkovsky\OpenSslWrapper\Entity\CsrSubject;
use Budkovsky\OpenSslWrapper\PublicKey;

class PrivateKeyTest extends TestCase
{
    public function testCanGenerateNewKey(): void
    {
        $this->assertIsString((new PrivateKey(true))->export());
    }
    
    public function testCanGenerateNewKeyByStaticFactory(): void
    {
        $this->assertIsString(PrivateKey::create(true)->export());
    }
    
    public function testCanLoadKeyFromString(): void
    {
        $privateKeyBody = KeyHelper::generateNewPrivateKeyBody();

        $key = PrivateKey::create()->load($privateKeyBody);
        $this->assertInstanceOf(PrivateKey::class, $key);
        $this->assertEquals(
            $privateKeyBody, 
            $key->export('', ConfigArgs::create()->setEncryptKey(false))
        );
    }
    
    public function testCanGetPublicKey(): void
    {
        $privateKey = PrivateKey::create(
            true, 
            ConfigArgs::create()->setEncryptKey(false)
        );
        
        $this->assertInstanceOf(
            PublicKey::class, 
            $privateKey->getPublicKey(CsrSubject::create()->setCommonName('test'))
        );
        
    }
}

