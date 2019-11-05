<?php
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\Arrayable;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Abstraction\StringableInterface;
use Budkovsky\OpenSslWrapper\Partial\Pkcs12Trait;
use Budkovsky\OpenSslWrapper\Entity\Pkcs12;

/**
 * PKCS12 keystore
 *
 * @see https://en.wikipedia.org/wiki/PKCS_12
 */
class Keystore implements StaticFactoryInterface, Arrayable, StringableInterface
{
    use Pkcs12Trait;

    /**
     * Keystore password
     * @var string
     */
    private $password;

    public function __construct()
    {
        $this->pkcs12 = new Pkcs12();
    }

    public static function create(): Keystore
    {
        return new static;
    }

    public function setPassword(string $password): Keystore
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see https://www.php.net/manual/en/function.openssl-pkcs12-read.php
     *
     * @param string $body
     * @param string $password
     * @param string $privateKeyPassphrase
     * @return Keystore
     */
    public function import(string $body, ?string $password = null, ?string $privateKeyPassphrase = null): Keystore
    {
        if ($password !== null) {
            $this->password = $password;
        }

        $certs = [];
        \openssl_pkcs12_read($body, $certs, $this->password ?? '');

        if (isset($certs['pkey'])) {
            $this->pkcs12->setPrivateKey(
                PrivateKey::create()->load($certs['pkey'], $privateKeyPassphrase ?? '')
            );

        }
        if (isset($certs['cert'])) {
            $this->pkcs12->setCertificate(
                X509::create()->load($certs['cert'])
            );
        }

        if (isset($certs['extracerts']) && \is_array($certs['extracerts'])) {
            foreach ($certs['extracerts'] as $extraCertBody) {
                $this->pkcs12->addExtraCert(X509::create()->load($extraCertBody));
            }
        }

        return $this;
    }

    /**
     * @param string $filename
     * @param string $password
     * @param string $privateKeyPassphrase
     * @return Keystore
     */
    public function importFromFile(string $filename, ?string $password = null, ?string $privateKeyPassphrase = null): Keystore
    {
        return $this->import(\file_get_contents($filename), $password, $privateKeyPassphrase);
    }

    /**
     * @see https://www.php.net/manual/en/function.openssl-pkcs12-export.php
     *
     * @param string $password
     * @param string $friendlyName
     * @return string
     */
    public function export(?string $password = null, ?string $friendlyName = null): string
    {
        if ($password !== null) {
            $this->password = $password;
        }

        $output = null;

        \openssl_pkcs12_export(
            $this->pkcs12->getCertificate()->export(),
            $output,
            $this->pkcs12->getPrivateKey()->export(),
            $this->password ?? '',
            \array_merge(
                $this->pkcs12->getExtraCerts() ? ['extracerts' => $this->pkcs12->getExtraCerts()->toArray()] : [],
                $friendlyName ? ['friendlyname' => $friendlyName] : []
            )
        );

        return $output;
    }

    /**
     * @see https://www.php.net/manual/en/function.openssl-pkcs12-export-to-file.php
     *
     * @param string $filename
     * @param string $password
     * @param string $friendlyName
     * @return KeyStore
     */
    public function exportToFile(string $filename, ?string $password = null, ?string $friendlyName = null): KeyStore
    {
        \file_put_contents($filename, $this->export($password, $friendlyName));

        return $this;
    }

    public function __toString(): string
    {
        return \implode("\n", $this->toArray());
    }

    public function toArray(bool $withPrivateKey = false): array
    {
        $result = [];

        if ($withPrivateKey && $this->privateKey !== null) {
            $result[] = $this->privateKey->export();
        }
        if ($this->certificate !== null) {
            $result[] = $this->certificate->export();
        }
        if ($this->extraCerts !== null) {
            foreach ($this->extraCerts as $cert) {
                /** @var X509 $cert */
                $result[] = $cert->export();
            }
        }

        return $result;
    }
}
