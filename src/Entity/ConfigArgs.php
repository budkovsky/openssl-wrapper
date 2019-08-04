<?php
namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * @see https://www.php.net/manual/en/function.openssl-csr-new.php
 */
class ConfigArgs
{
    /** @var string */
    private $digestAlg;
    
    /** @var string */
    private $x509Extensions;
    
    /** @var string */
    private $reqExtensions;
    
    /** @var int */
    private $privateKeyBits;
    
    /** @var int */
    private $privateKeyType;
    
    /** @var bool */
    private $encryptKey;
    
    /** @var int */
    private $encryptKeyCipher;
    
    /** @var string */
    private $curveName;
    
    /** @var string */
    private $config;
    
    public function __construct(array $configArgs)
    {
            $this->digestAlg = $configArgs['digest_alg'];
            $this->x509Extensions = $configArgs['x509_extensions'];
            $this->reqExtensions = $configArgs['req_extensions'];
            $this->privateKeyBits = $configArgs['private_key_bits'];
            $this-> privateKeyType = $configArgs['private_key_type'];
            $this->encryptKey = $configArgs['encrypt_key'];
            $this->encryptKeyCipher = $configArgs['encrypt_key_cipher'];
            $this->curveName = $configArgs['curve_name'];
            $this->config = $configArgs['config'];
    }

    public function getDigestAlg(): string
    {
        return $this->digestAlg;
    }

    public function setDigestAlg(string $digestAlg): ConfigArgs
    {
        $this->digestAlg = $digestAlg;
        
        return $this;
    }

    public function getX509Extensions(): string
    {
        return $this->x509Extensions;
    }

    public function setX509Extensions(string $x509Extensions): ConfigArgs
    {
        $this->x509Extensions = $x509Extensions;
        
        return $this;
    }

    public function getReqExtensions(): string
    {
        return $this->reqExtensions;
    }

    public function setReqExtensions(string $reqExtensions): ConfigArgs
    {
        $this->reqExtensions = $reqExtensions;
        
        return $this;
    }

    public function getPrivateKeyBits(): int
    {
        return $this->privateKeyBits;
    }

    public function setPrivateKeyBits(int $privateKeyBits): ConfigArgs
    {
        $this->privateKeyBits = $privateKeyBits;
        
        return $this;
    }

    public function getPrivateKeyType(): int
    {
        return $this->privateKeyType;
    }

    public function setPrivateKeyType(int $privateKeyType): ConfigArgs
    {
        $this->privateKeyType = $privateKeyType; //TODO validate
        
        return $this;
    }

    public function isEncryptKey(): bool
    {
        return $this->encryptKey;
    }

    public function setEncryptKey(bool $encryptKey): ConfigArgs
    {
        $this->encryptKey = $encryptKey;
        
        return $this;
    }

    public function getEncryptKeyCipher(): int
    {
        return $this->encryptKeyCipher;
    }

    public function setEncryptKeyCipher(int $encryptKeyCipher): ConfigArgs
    {
        $this->encryptKeyCipher = $encryptKeyCipher;
        
        return $this;
    }

    public function getCurveName(): string
    {
        return $this->curveName;
    }

    /** @see https://www.php.net/manual/en/function.openssl-get-curve-names.php */
    public function setCurveName(string $curveName): ConfigArgs
    {
        $this->curveName = $curveName; //TODO validation
        
        return $this;
    }

    public function getConfig(): string
    {
        return $this->config;
    }

    public function setConfig(string $config): ConfigArgs
    {
        $this->config = $config;
        
        return $this;
    }
    
    public function toArray(): array
    {
        return [
            'digest_alg' => $this->digestAlg,
            'x509_extensions' => $this->x509Extensions,
            'req_extensions' => $this->reqExtensions,
            'private_key_bits' => $this->privateKeyBits,
            'private_key_type' => $this-> privateKeyType,
            'encrypt_key' => $this->encryptKey,
            'encrypt_key_cipher' => $this->encryptKeyCipher,
            'curve_name' => $this->curveName,
            'config' => $this->config
        ];
    }
}
