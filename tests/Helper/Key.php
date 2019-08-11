<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;

class Key
{
    use StaticClassTrait;
    
    public static function generateNewPrivateKeyBody(): string
    {
        $keyResource = openssl_pkey_new();
        $keyBody = null;
        openssl_pkey_export($keyResource, $keyBody);
        
        return $keyBody;
    }
}
