<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\Tests\Helper\EntityTestHelper;
use Budkovsky\OpenSslWrapper\Entity\CertLocations;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;

class EntityTest extends TestCase
{
    public function testIs_CertLocations_Valid_Entity(): void
    {
        $reflector = new \ReflectionClass(CertLocations::class);
        $this->assertTrue(EntityTestHelper::hasNoPublicProperties($reflector));
        $this->assertTrue(EntityTestHelper::hasValidGetters($reflector));
        //$this->assertTrue(EntityTestHelper::hasValidSetters($reflector));
    }

    public function testIs_ConfigArgs_ValidEntity(): void
    {
        $reflector = new \ReflectionClass(ConfigArgs::class);
        $this->assertTrue(EntityTestHelper::hasNoPublicProperties($reflector));
        $this->assertTrue(EntityTestHelper::hasValidGetters($reflector));
        $this->assertTrue(EntityTestHelper::hasValidSetters($reflector));
    }
}
