<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\X509;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Tests\Helper\CsrTestHelper;

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
//         $anotherPrivateKey = PrivateKey::create();
//         $this->assertInstanceOf(
//             X509::class,
//             X509::create(
//                 CsrTestHelper::getCsrExample($anotherPrivateKey),
//                 $anotherPrivateKey
//             )
//         );
    }

}
