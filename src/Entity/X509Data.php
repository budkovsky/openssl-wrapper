<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * X509Data entity
 * @see https://www.php.net/manual/en/function.openssl-x509-parse.php
 */
class X509Data
{
    /**
     * @var array
     */
    protected $raw;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var X509Subject
     */
    protected $subject;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var X509Issuer
     */
    protected $issuer;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var string
     */
    protected $serialNumber;

    /**
     * @var string
     */
    protected $serialNumberHex;

    /**
     * @var string
     */
    protected $validFrom;

    /**
     * @var string
     */
    protected $validTo;

    /**
     * @var int
     */
    protected $validFromTimeT;

    /**
     * @var int
     */
    protected $validToTimeT;

    /**
     * @var string
     */
    protected $signatureTypeSN;

    /**
     * @var string
     */
    protected $signatureTypeLN;

    /**
     *
     * @var int
     */
    protected $signatureTypeNID;

    /**
     * @var X509Purposes
     */
    protected $purposes;

    /**
     * @var X509Extensions
     */
    protected $extensions;

    /**
     * The constructor
     * @param array $x509Data Result of openssl_x509_parse()
     */
    public function __construct(array $x509Data)
    {
        $this->raw = $x509Data;
        $this->name = $x509Data['name'] ?? null;
        $this->subject = new X509Subject($x509Data['subject']) ?? null;
        $this->hash = $x509Data['hash'] ?? null;
        $this->issuer = new X509Issuer($x509Data['issuer']) ?? null;
        $this->version = $x509Data['version'] ?? null;
        $this->serialNumber = $x509Data['serialNumber'] ?? null;
        $this->serialNumberHex = $x509Data['serialNumberHex'] ?? null;
        $this->validFrom = $x509Data['validFrom'] ?? null;
        $this->validTo = $x509Data['validTo'] ?? null;
        $this->validFromTimeT = $x509Data['validFromTimeT'] ?? null;
        $this->validToTimeT = $x509Data['validToTimeT'] ?? null;
        $this->signatureTypeSN = $x509Data['signatureTypeSN'] ?? null;
        $this->signatureTypeLN = $x509Data['signatureTypeLN'] ?? null;
        $this->signatureTypeNID = $x509Data['signatureTypeNID'] ?? null;
        $this->purposes = new X509Purposes($x509Data['purposes']) ?? null;
        $this->extensions = new X509Extensions($x509Data['extensions']) ?? null;
    }

    /**
     * @return array
     */
    public function getRaw():array
    {
        return $this->raw;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return X509Subject
     */
    public function getSubject(): ?X509Subject
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @return X509Issuer
     */
    public function getIssuer(): ?X509Issuer
    {
        return $this->issuer;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    /**
     * @return string
     */
    public function getSerialNumberHex(): ?string
    {
        return $this->serialNumberHex;
    }

    /**
     * @return string
     */
    public function getValidFrom(): ?string
    {
        return $this->validFrom;
    }

    /**
     * @return string
     */
    public function getValidTo(): ?string
    {
        return $this->validTo;
    }

    /**
     * @return int
     */
    public function getValidFromTimeT(): ?int
    {
        return $this->validFromTimeT;
    }

    /**
     * @return int
     */
    public function getValidToTimeT(): ?int
    {
        return $this->validToTimeT;
    }

    /**
     * @return string
     */
    public function getSignatureTypeSN(): ?string
    {
        return $this->signatureTypeSN;
    }

    /**
     * @return string
     */
    public function getSignatureTypeLN(): ?string
    {
        return $this->signatureTypeLN;
    }

    /**
     * @return int
     */
    public function getSignatureTypeNID(): ?int
    {
        return $this->signatureTypeNID;
    }

    /**
     * @return X509Purposes
     */
    public function getPurposes(): ?X509Purposes
    {
        return $this->purposes;
    }

    /**
     * @return X509Extensions
     */
    public function getExtensions(): ?X509Extensions
    {
        return $this->extensions;
    }
}
