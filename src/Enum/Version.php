<?php
namespace Budkovsky\ObjectOpenSSL\Enum;

use Budkovsky\ObjectOpenSSL\Abstraction\EnumAbstract;

class Version extends EnumAbstract
{

    const TEXT = OPENSSL_VERSION_TEXT;
    const NUMBER = OPENSSL_VERSION_NUMBER;
    
    public function getAll()
    {
        return [
            'TEXT' => self::TEXT,
            'NUMBER' => self::NUMBER
        ];
    }
}
