<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Tests;

use PHPUnit\Framework\TestCase;
use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Tests\Helper\Methods as MethodsHelper;

final class WrapperTest extends TestCase
{
    public function testCanGetDigestMethods(): void
    {
        foreach (OpenSSL::getDigestMethods(true) as $method) {
            $this->assertContains($method, openssl_get_md_methods(true));
        }
    }
    
    public function testCanGetCipherMethods(): void
    {
        foreach (OpenSSL::getCipherMethods(true) as $method) {
            $this->assertContains($method, openssl_get_cipher_methods(true));
        }
    }
    
    public function testCanGetCipherIvLength(): void
    {
        foreach (OpenSSL::getCipherMethods(true) as $method) {
            $this->assertEquals(
                openssl_cipher_iv_length($method),
                OpenSSL::cipherIvLength($method)
            );
        }
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
}
