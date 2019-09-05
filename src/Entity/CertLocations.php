<?php
/**
 * 2019 Budkovsky
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

use Budkovsky\OpenSslWrapper\Abstraction\SingletonInterface;

/**
 * CertLocations entity
 * @see https://www.php.net/manual/en/function.openssl-get-cert-locations.php
 */
class CertLocations implements SingletonInterface
{
    /** @var string */
    private $defaultCertFile;

    /** @var string */
    private $defaultCertFileEnv;

    /** @var string */
    private $defaultCertDir;

    /** @var string */
    private $defaultCertDirEnv;

    /** @var string */
    private $defaultPrivateDir;

    /** @var string */
    private $defaultDefaultCertArea;

    /** @var string */
    private $iniCAFile;

    /** @var string */
    private $iniCAPath;

    /**
     * Non public constructor
     */
    private function __construct()
    {
        foreach(openssl_get_cert_locations() as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    private function __clone(){}

    /**
     * Property setter
     * @param string $key
     * @param string $value
     */
    private function setProperty(string $key, string $value): void
    {
        switch ($key) {
            case 'default_cert_file':
                $this->defaultCertFile = $value;
                break;
            case 'default_cert_file_env':
                $this->defaultCertFileEnv = $value;
                break;
            case 'default_cert_dir':
                $this->defaultCertDir = $value;
                break;
            case 'default_cert_dir_env':
                $this->defaultCertDirEnv = $value;
                break;
            case 'default_private_dir':
                $this->defaultPrivateDir = $value;
                break;
            case 'default_default_cert_area':
                $this->defaultDefaultCertArea = $value;
                break;
            case 'ini_cafile':
                $this->iniCAFile = $value;
                break;
            case 'ini_capath':
                $this->iniCAPath = $value;
                break;
            default:
                break;
        }
    }

    /**
     * Singleton instance getter
     * @return CertLocations
     */
    public static function getInstance(): CertLocations
    {
        static $instance;

        if (!$instance) {
            $instance = new static;
        }

        return $instance;
    }

    public function getDefaultCertFile(): string
    {
        return $this->defaultCertFile;
    }

    public function getDefaultCertFileEnv(): string
    {
        return $this->defaultCertFileEnv;
    }

    public function getDefaultCertDir(): string
    {
        return $this->defaultCertDir;
    }

    public function getDefaultCertDirEnv(): string
    {
        return $this->defaultCertDirEnv;
    }

    public function getDefaultPrivateDir(): string
    {
        return $this->defaultPrivateDir;
    }

    public function getDefaultDefaultCertArea(): string
    {
        return $this->defaultDefaultCertArea;
    }

    public function getIniCAFile(): string
    {
        return $this->iniCAFile;
    }

    public function getIniCAPath(): string
    {
        return $this->iniCAPath;
    }
}
