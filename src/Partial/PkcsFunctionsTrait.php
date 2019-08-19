<?php
namespace Partial;

use Budkovsky\OpenSslWrapper\Wrapper as OpenSSL;
use Budkovsky\OpenSslWrapper\Exception\ComputeDigestException;

trait PkcsFunctionsTrait
{
    /**
     * computes PBKDF2 (Password-Based Key Derivation Function 2), a key derivation function defined in PKCS5 v2
     * @see https://www.php.net/manual/en/function.openssl-pbkdf2.php
     * @param string $password
     * @param string $salt
     * @param int $keyLength
     * @param int $iterations
     * @param string $digestAlgorithm
     **/
    public static function computePbkdf2(
        string $password,
        string $salt,
        int $keyLength,
        int $iterations,
        string $digestAlgorithm = 'sha1'
    ): ?string {
        if (!in_array($digestAlgorithm, OpenSSL::getMessageDigestMethods())) {
            throw new ComputeDigestException("Invalid digest algorithm: `$digestAlgorithm`");
        }
        return openssl_pbkdf2($password, $salt, $keyLength, $iterations, $digestAlgorithm) ?? null;
    }
}
