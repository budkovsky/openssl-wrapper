<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Entity\CsrSubject;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;
use Budkovsky\OpenSslWrapper\Csr;

class CsrTestHelper
{
    use StaticClassTrait;

    public static function getCsrExample(
        ?PrivateKey $privateKey= null,
        ?CsrSubject $subject = null,
        ?ConfigArgs $configArgs = null,
        ?array $extraAttribs = []
    ): Csr {
        return new Csr(
            $privateKey ?? PrivateKey::create($configArgs ?? null),
            $subject ?? self::getCsrSubjectExample(),
            $configArgs ?? self::getConfigArgsExample(),
            $extraAttribs
        );
    }

    private static function getCsrSubjectExample(): CsrSubject
    {
        return CsrSubject::create()
            ->setCommonName('johnwayne.poland.com')
            ->setCountryName('PL')
            ->setEmailAddress('johnwayne@johnwayne.poland.com')
            ->setLocalityName('Warsaw')
            ->setOrganizationName('ACME Ltd')
            ->setOrganizationalUnitName('ITDepartment')
            ->setStateOrProvince('mazowieckie')
        ;
    }

    private static function getConfigArgsExample(): ConfigArgs
    {
        return ConfigArgs::create();
    }
}
