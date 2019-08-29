<?php
namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;
use Budkovsky\OpenSslWrapper\Tests\Entity\SealDataSet;
use Budkovsky\OpenSslWrapper\Collection\PublicKeyCollection;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;

class WrapperTestHelper
{
    use StaticClassTrait;

    public static function getSealDataSet(int $howManyKeys = 10): SealDataSet
    {
        $dataSet = new SealDataSet();
        $dataSet->setData('Lorem ipsum dolor sit amet');
        $dataSet->setMethod('RC4');
        $publicKeys = new PublicKeyCollection();
        for ($i = 0; $i < $howManyKeys; $i++) {
            $privateKey = PrivateKey::create();
            $dataSet->getPrivateKeyCollction()->add($privateKey);
            $publicKeys->add($privateKey->getPublicKey());
        }
        $dataSet->setSealResult(OpenSSL::seal($dataSet->getData(), $publicKeys, $dataSet->getMethod()));

        return $dataSet;
    }
}
