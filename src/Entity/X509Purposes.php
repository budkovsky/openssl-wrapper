<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 *X509Purposes entity
 */
class X509Purposes
{
    /**
     * @var bool
     */
    protected $sslClient;

    /**
     * @var bool
     */
    protected $sslClientCA;

    /**
     * @var bool
     */
    protected $sslServer;

    /**
     * @var bool
     */
    protected $sslServerCA;

    /**
     * @var bool
     */
    protected $netscapeSslServer;

    /**
     * @var bool
     */
    protected $netscapeSslServerCA;

    /**
     * @var bool
     */
    protected $smimeSigning;

    /**
     * @var bool
     */
    protected $smimeSigningCA;

    /**
     * @var bool
     */
    protected $smimeEncryption;

    /**
     * @var bool
     */
    protected $smimeEncryptionCA;

    /**
     * @var bool
     */
    protected $crlSigning;

    /**
     * @var bool
     */
    protected $crlSigningCA;

    /**
     * @var bool
     */
    protected $anyPurpose;

    /**
     * @var bool
     */
    protected $anyPurposeCA;

    /**
     * @var bool
     */
    protected $ocspHelper;

    /**
     * @var bool
     */
    protected $ocspHelperCA;

    /**
     * @var bool
     */
    protected $timestampSigning;

    /**
     * @var bool
     */
    protected $timestampSigningCA;

    /**
     * The constructor
     * @param array $purposes Puroposes subarray from openssl_x509_parse() result
     */
    public function __construct(array $purposes)
    {
        foreach($purposes as $record) {
            $this->setPurpose($record[2], $record[0], $record[1]);
        }
    }

    /**
     * Purposes setter
     * @param string $name
     * @param bool $isGeneral
     * @param bool $isCA
     */
    protected function setPurpose(string $name, bool $isGeneral, bool $isCA): void
    {
        switch($name) {
            case 'sslclient':
                $this->sslClient = $isGeneral;
                $this->sslClientCA = $isCA;
                break;
            case 'sslserver':
                $this->sslServer = $isGeneral;
                $this->sslServerCA = $isCA;
                break;
            case 'nssslserver':
                $this->netscapeSslServer = $isGeneral;
                $this->netscapeSslServerCA = $isCA;
                break;
            case 'smimesign':
                $this->smimeSigning = $isGeneral;
                $this->smimeSigningCA = $isCA;
                break;
            case 'smimeencrypt':
                $this->smimeEncryption = $isGeneral;
                $this->smimeEncryptionCA = $isCA;
                break;
            case 'crlsign':
                $this->crlSigning = $isGeneral;
                $this->crlSigningCA = $isCA;
                break;
            case 'any':
                $this->anyPurpose = $isGeneral;
                $this->anyPurposeCA = $isCA;
                break;
            case 'ocsphelper':
                $this->ocspHelper = $isGeneral;
                $this->ocspHelperCA = $isCA;
                break;
            case 'timestampsign':
                $this->timestampSigning = $isGeneral;
                $this->timestampSigningCA = $isCA;
                break;
            default:
                break;
        }
    }

    /**
     * @return bool
     */
    public function isSslClient(): bool
    {
        return $this->sslClient;
    }

    /**
     * @return bool
     */
    public function isSslClientCA(): bool
    {
        return $this->sslClientCA;
    }

    /**
     * @return bool
     */
    public function isSslServer(): bool
    {
        return $this->sslServer;
    }

    /**
     * @return bool
     */
    public function isSslServerCA(): bool
    {
        return $this->sslServerCA;
    }

    /**
     * @return bool
     */
    public function isNetscapeSslServer(): bool
    {
        return $this->netscapeSslServer;
    }

    /**
     * @return bool
     */
    public function isNetscapeSslServerCA(): bool
    {
        return $this->netscapeSslServerCA;
    }

    /**
     * @return bool
     */
    public function isSmimeSigning(): bool
    {
        return $this->smimeSigning;
    }

    /**
     * @return bool
     */
    public function isSmimeSigningCA(): bool
    {
        return $this->smimeSigningCA;
    }

    /**
     * @return bool
     */
    public function isSmimeEncryption(): bool
    {
        return $this->smimeEncryption;
    }

    /**
     * @return bool
     */
    public function isSmimeEncryptionCA(): bool
    {
        return $this->smimeEncryptionCA;
    }

    /**
     * @return bool
     */
    public function isCrlSigning(): bool
    {
        return $this->crlSigning;
    }

    /**
     * @return bool
     */
    public function isCrlSigningCA(): bool
    {
        return $this->crlSigningCA;
    }

    /**
     * @return bool
     */
    public function isAnyPurpose(): bool
    {
        return $this->anyPurpose;
    }

    /**
     * @return bool
     */
    public function isAnyPurposeCA(): bool
    {
        return $this->anyPurposeCA;
    }

    /**
     * @return bool
     */
    public function isOcspHelper(): bool
    {
        return $this->ocspHelper;
    }

    /**
     * @return bool
     */
    public function isOcspHelperCA(): bool
    {
        return $this->ocspHelperCA;
    }

    /**
     * @return bool
     */
    public function isTimestampSigning(): bool
    {
        return $this->timestampSigning;
    }

    /**
     * @return bool
     */
    public function isTimestampSigningCA(): bool
    {
        return $this->timestampSigningCA;
    }
}
