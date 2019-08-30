<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Tests\Helper\MethodTestHelper as MethodsHelper;
use Budkovsky\OpenSslWrapper\Exception\OpenSSLWrapperException;
use Budkovsky\OpenSslWrapper\Entity\SealResult;
use Budkovsky\OpenSslWrapper\Tests\Helper\WrapperTestHelper;

final class WrapperTest extends TestCase
{
    public function testCanGetDigestMethods(): void
    {
        $methodList = OpenSSL::getDigestMethods(true);
        $this->assertIsArray($methodList);
        $this->assertNotEmpty($methodList);
        foreach ($methodList as $method) {
            $this->assertContains($method, openssl_get_md_methods(true));
        }
    }

    public function testCanGetCipherMethods(): void
    {
        $methodList = OpenSSL::getCipherMethods(true);
        $this->assertIsArray($methodList);
        $this->assertNotEmpty($methodList);
        foreach ($methodList as $method) {
            $this->assertContains($method, openssl_get_cipher_methods(true));
        }
    }

    public function testCanGetCurveNames(): void
    {
        $list = OpenSSL::getCurveNames();
        $this->assertIsArray($list);
        $this->assertNotEmpty($list);
        foreach ($list as $curveName) {
            $this->assertContains($curveName, openssl_get_curve_names());
        }
    }

    public function testCanGetCipherIvLength(): void
    {
        foreach (OpenSSL::getCipherMethods(true) as $method) {
            $this->assertIsInt(OpenSSL::cipherIvLength($method));
            $this->assertEquals(
                openssl_cipher_iv_length($method),
                OpenSSL::cipherIvLength($method)
            );
        }
        $this->expectException(OpenSSLWrapperException::class);
        OpenSSL::cipherIvLength('ABCD');
    }

    public function testCanValidateDigestMethod(): void
    {
        for ($i=0; $i<1000; $i++) {
            $this->assertContains(
                MethodsHelper::getRandomDigestMethod(),
                openssl_get_md_methods()
            );
            $this->assertContains(
                MethodsHelper::getRandomDigestMethod(true),
                openssl_get_md_methods(true)
            );
        }
    }

    public function testCanValidateCipherMethod(): void
    {
        for ($i=0; $i<1000; $i++) {
            $this->assertContains(
                MethodsHelper::getRandomCipherMethod(),
                openssl_get_cipher_methods()
            );
            $this->assertContains(
                MethodsHelper::getRandomCipherMethod(true),
                openssl_get_cipher_methods(true)
            );
        }
    }

    public function testCanGetCertLocations(): void
    {
        $certLocations = openssl_get_cert_locations();
        $this->assertEquals(
            $certLocations['default_cert_file'],
            OpenSSL::getCertLocations()->getDefaultCertFile()
        );
        $this->assertEquals(
            $certLocations['default_cert_file_env'],
            OpenSSL::getCertLocations()->getDefaultCertFileEnv()
        );
        $this->assertEquals(
            $certLocations['default_cert_dir'],
            OpenSSL::getCertLocations()->getDefaultCertDir()
        );
        $this->assertEquals(
            $certLocations['default_cert_dir_env'],
            OpenSSL::getCertLocations()->getDefaultCertDirEnv()
        );
        $this->assertEquals(
            $certLocations['default_private_dir'],
            OpenSSL::getCertLocations()->getDefaultPrivateDir()
        );
        $this->assertEquals(
            $certLocations['default_default_cert_area'],
            OpenSSL::getCertLocations()->getDefaultDefaultCertArea()
        );
        $this->assertEquals(
            $certLocations['ini_cafile'],
            OpenSSL::getCertLocations()->getIniCAFile()
        );
        $this->assertEquals(
            $certLocations['ini_capath'],
            OpenSSL::getCertLocations()->getIniCAPath()
        );
    }

    public function testCanGetRandomPseudoBytes(): void
    {
        $collection = [];
        for ($length=10; $length<=100; $length++) {
            $pseudoBytes1 = OpenSSL::getRandomPseudoBytes($length);
            $pseudoBytes2 = OpenSSL::getRandomPseudoBytes($length);
            $pseudoBytes3 = OpenSSL::getRandomPseudoBytes($length);

            $this->assertTrue(is_string($pseudoBytes1));
            $this->assertTrue(is_string($pseudoBytes2));
            $this->assertTrue(is_string($pseudoBytes3));

            $this->assertEquals($length, strlen($pseudoBytes1));
            $this->assertEquals($length, strlen($pseudoBytes2));
            $this->assertEquals($length, strlen($pseudoBytes3));

            if ($this->assertNotContains($pseudoBytes1, $collection)) {
                $collection[] = $pseudoBytes1;
            }
            if ($this->assertNotContains($pseudoBytes2, $collection)) {
                $collection[] = $pseudoBytes2;
            }
            if ($this->assertNotContains($pseudoBytes3, $collection)) {
                $collection[] = $pseudoBytes3;
            }
        }
    }

    public function testCanComputeDigest(): void
    {
        foreach (OpenSSL::getDigestMethods(true) as $method) {
            $randomPseudoBytes = OpenSSL::getRandomPseudoBytes(rand(10, 100));
            $this->assertEquals(
                openssl_digest($randomPseudoBytes, $method, false),
                OpenSSL::computeDigest($randomPseudoBytes, $method, false)
            );
            $this->assertEquals(
                openssl_digest($randomPseudoBytes, $method, true),
                OpenSSL::computeDigest($randomPseudoBytes, $method, true)
            );
        }
    }

    /** @see https://stackoverflow.com/questions/41952509/openssl-encrypt-returns-false */
    public function testCanGetErrorString(): void
    {
        //it should generate openssl error
        openssl_encrypt('1234', 'aes-128-cbc', 'kGJeGF2hEQ', OPENSSL_ZERO_PADDING, '1234123412341234');

        $errorString = OpenSSL::getErrorString();

        $this->assertNotFalse($errorString);
        $this->assertIsString($errorString);
        $this->assertNotEmpty($errorString);
    }

    public function testCanSeal(): void
    {
        $dataSet = WrapperTestHelper::getSealDataSet();
        $this->assertInstanceOf(SealResult::class, $dataSet->getSealResult());
        $this->assertGreaterThan(0, $dataSet->getSealResult()->getDataLength());
        $this->assertIsString($dataSet->getSealResult()->getSealedData());
        $this->assertNotEmpty($dataSet->getSealResult()->getSealedData());
        $this->assertGreaterThan(0, $dataSet->getSealResult()->getEnvKeys()->count());
    }

    public function testCanOpenSealedData(): void
    {
        $dataSet = WrapperTestHelper::getSealDataSet();
        foreach ($dataSet->getPrivateKeyCollction() as $index => $privateKey) {
            $openData = OpenSSL::unseal(
                $dataSet->getSealResult()->getSealedData(),
                $dataSet->getSealResult()->getEnvKeys()->toArray()[$index],
                $privateKey,
                null,
                $dataSet->getMethod()
            );
            $this->assertIsString($openData);
            $this->assertNotEmpty($openData);
            $this->assertEquals($dataSet->getData(), $openData);
        }
    }

    public function testCanEncryptByPublicKey(): void
    {
        $collection = WrapperTestHelper::encryptRandomContent(true);
        foreach ($collection as $dataSet) {
            /** @var \Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet $dataSet */
            $encryptedContent = OpenSSL::encrypt(
                $dataSet->getRawContent(),
                $dataSet->getMethod(),
                $dataSet->getKey()->getPublicKey(),
                $dataSet->getIv()
            );
            $this->assertIsString($encryptedContent);
            $this->assertNotEmpty($encryptedContent);
            $this->assertEquals($dataSet->getEncryptedContent(), $encryptedContent);
            $this->assertNotEquals($dataSet->getRawContent(), $encryptedContent);
        }
    }

    public function testCanEncryptByPrivateKey(): void
    {
        $collection = WrapperTestHelper::encryptRandomContent(false);
        foreach ($collection as $dataSet) {
            /** @var \Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet $dataSet */
            $encryptedContent = OpenSSL::encrypt(
                $dataSet->getRawContent(),
                $dataSet->getMethod(),
                $dataSet->getKey(),
                $dataSet->getIv()
            );
            $this->assertIsString($encryptedContent);
            $this->assertNotEmpty($encryptedContent);
            $this->assertEquals($dataSet->getEncryptedContent(), $encryptedContent);
            $this->assertNotEquals($dataSet->getRawContent(), $encryptedContent);
        }
    }

//     public function testCanDecryptByPublicKey(): void
//     {
//         $collection = WrapperTestHelper::encryptRandomContent(false, 1);
//         foreach ($collection as $dataSet) {
//             /** @var \Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet $dataSet */
//             var_dump($dataSet->getRawContent(), $dataSet->getKey()->export());
//             $decryptedContent = OpenSSL::decrypt(
//                 $dataSet->getEncryptedContent(),
//                 $dataSet->getMethod(),
//                 $dataSet->getKey(),
//                 $dataSet->getIv()
//             );
//             $this->assertIsString($decryptedContent);
//             $this->assertNotEmpty($decryptedContent);
//             $this->assertEquals($dataSet->getRawContent(), $decryptedContent);
//             $this->assertNotEquals($dataSet->getEncryptedContent(), $decryptedContent);
//         }
//     }
}
