<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Partial;

use Budkovsky\OpenSslWrapper\Exception\StaticClassException;

trait StaticClassTrait
{
    private function __construct()
    {
        throw new StaticClassException(sprintf(
            "`%s` class can't be instantionable, is designed for static use",
            __CLASS__
        ));
    }
}
