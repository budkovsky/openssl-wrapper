<?php
namespace Budkovsky\OpenSsslWrapper\Tests\Helper;

abstract class Methods
{
    public static function getRandomDigestMethod($aliases = false): string
    {
        $methodList = openssl_get_md_methods($aliases);
        $randomKey = rand(0, count($methodList)-1);

        return $methodList[$randomKey];
    }
    
    public static function getRandomCipherMethod($aliases = false): string
    {
        $methodList = openssl_get_cipher_methods($aliases);
        $randomKey = rand(0, count($methodList)-1);
        
        return $methodList[$randomKey];
    }
}