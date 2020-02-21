<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Helper;

use Budkovsky\OpenSslWrapper\Entity\Pkcs12;
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Collection\X509Collection;
use Budkovsky\OpenSslWrapper\X509;

abstract class Pem
{
    public static $certRegexPattern = '/-----BEGIN CERTIFICATE-----*.?-----END CERTIFICATE-----/s';

//     public static function getAsPkcs12(string $body, string $pkeyPassphrase = ''): Pkcs12
//     {
//         $pkcs12 = new Pkcs12();
//         $key = PrivateKey::create()->load($body, $pkeyPassphrase);
//         $certCollection = self::getX509Collection($body);
//     }

    public static function getFromFileAsPkcs12(string $filename): Pkcs12
    {
        return self::getAsPkcs12(\file_get_contents($filename));
    }

//     public static function exportFromPkcs12(Pkcs12 $pkcs12): string
//     {
//     }

//     public static function exportToFileFromPkcs12(Pkcs12 $pkcs12, string $filename): bool
//     {
//         return (bool)\file_put_contents($filename, self::exportFromPkcs12($pkcs12));
//     }

    protected static function getX509Collection(string $body): X509Collection
    {
        $collection = new X509Collection();
        $certBodies = [];
        \preg_match_all(self::$certRegexPattern, $body, $certBodies);
        foreach ($certBodies as $singleCertBody) {
            $collection->add(X509::create()->load($singleCertBody));
        }

        return $collection;
    }

    protected static function getMainCert(X509Collection $collection, PrivateKey $privateKey): ?X509
    {
        foreach ($collection as $x509) {
            /** @var X509 $x509 */
            if ($x509->checkPrivateKey($privateKey)) {
                return $x509->getX509Data()->getName();
            }
        }
    }

//     protected static function getLowestLevelCert(X509Collection $collection): ?X509
//     {
//     }
}
