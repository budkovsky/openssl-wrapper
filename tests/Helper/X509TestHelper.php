<?php
namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;
use Budkovsky\OpenSslWrapper\X509;
use Budkovsky\OpenSslWrapper\PrivateKey;

class X509TestHelper
{
    use StaticClassTrait;

    public static function getX509example(): X509
    {
        $privateKey = PrivateKey::create();
        return new X509(
            CsrTestHelper::getCsrExample($privateKey),
            $privateKey
        );
    }
}
