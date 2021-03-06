<?php
namespace Budkovsky\OpenSslWrapper\Tests\Helper;

use Budkovsky\OpenSslWrapper\Partial\StaticClassTrait;
use Budkovsky\OpenSslWrapper\Tests\Entity\SealDataSet;
use Budkovsky\OpenSslWrapper\Collection\PublicKeyCollection;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet;
use Budkovsky\OpenSslWrapper\Tests\Exception\TestException;
use Budkovsky\OpenSslWrapper\Tests\Collection\CryptionDataSetCollection;

class WrapperTestHelper
{
    use StaticClassTrait;

    public static function getSealDataSet(int $howManyKeys = 10): SealDataSet
    {
        $dataSet = new SealDataSet();
        $dataSet->setData('Lorem ipsum dolor sit amet');
        $dataSet->setMethod('rc4');
        $publicKeys = new PublicKeyCollection();
        for ($i = 0; $i < $howManyKeys; $i++) {
            $privateKey = PrivateKey::create();
            $dataSet->getPrivateKeyCollction()->add($privateKey);
            $publicKeys->add($privateKey->getPublicKey());
        }
        $dataSet->setSealResult(OpenSSL::seal($dataSet->getData(), $publicKeys, $dataSet->getMethod()));

        return $dataSet;
    }

    public static function encryptRandomContent(bool $usePublicKey = false, int $collectionLength = 10): CryptionDataSetCollection
    {
        $collection = new CryptionDataSetCollection();
        for ($i = 0; $i < $collectionLength; $i++) {
            $privateKey = PrivateKey::create();
            $rawContent = bin2hex(OpenSSL::getRandomPseudoBytes(100));
            $method = 'aes-128-cbc';
            $iv = OpenSSL::getRandomPseudoBytes(OpenSSL::cipherIvLength($method));
            $rawKey = $usePublicKey ? $privateKey->getPublicKey()->export() : $privateKey->export();
            $encryptedContent = openssl_encrypt(
                $rawContent,
                $method,
                $rawKey,
                0,
                $iv
            );
            if (!$encryptedContent) {
                throw new TestException('Unexpected error while ecrypt random content');
            }
            $collection->add(
                CryptionDataSet::create()
                    ->setPrivateKey($privateKey)
                    ->setRawContent($rawContent)
                    ->setEncryptedContent($encryptedContent)
                    ->setMethod($method)
                    ->setIv($iv)
            );
        }

        return $collection;
    }
}
