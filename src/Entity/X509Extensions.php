<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * X509Extensions entity
 */
class X509Extensions
{
    /**
     * @var string
     */
    protected $basicConstraints;

    /**
     * @var string
     */
    protected $nsCertType;

    /**
     * @var string
     */
    protected $keyUsage;

    /**
     * @var string
     */
    protected $extendedKeyUsage;

    /**
     * The constructor
     * @param array $xtensions Extensions subarray from openssl_x509_parse() result
     */
    public function __construct(array $extensions)
    {
        $this->basicConstraints = $extensions['basicConstraints'] ?? null;
        $this->nsCertType = $extensions['nsCertType'] ?? null;
        $this->keyUsage = $extensions['keyUsage'] ?? null;
        $this->extendedKeyUsage = $extensions['extendedKeyUsage'] ?? null;
    }

    /**
     * @return string
     */
    public function getBasicConstraints(): ?string
    {
        return $this->basicConstraints;
    }

    /**
     * @return string
     */
    public function getNsCertType(): ?string
    {
        return $this->nsCertType;
    }

    /**
     * @return string
     */
    public function getKeyUsage(): ?string
    {
        return $this->keyUsage;
    }

    /**
     * @return string
     */
    public function getExtendedKeyUsage(): ?string
    {
        return $this->extendedKeyUsage;
    }
}
