<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * Key details
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class KeyDetails
{
    /**
     * @var int
     */
    private $bits;

    /**
     * @var string
     */
    private $key;
    
    /**
     * @see \Budkovsky\OpenSslWrapper\Enum\KeyType
     * @var int
     */
    private $type;
    
    /**
     * The constructor
     * @param array $keyDetails
     */
    public function __construct(array $keyDetails)
    {
        $this->bits = $keyDetails['bits'];
        $this->key = $keyDetails['key'];
        $this->type = $keyDetails['type'];
    }
    
    /**
     * @param array $keyDetails
     * @return KeyDetails
     */
    final public static function factory(array $keyDetails): KeyDetails
    {
        switch ($keyDetails['type']) {
            case OPENSSL_KEYTYPE_DH:
                $className = KeyDetailsDH::class;
                break;
            case OPENSSL_KEYTYPE_DSA:
                $className = KeyDetailsDSA::class;
                break;
            case OPENSSL_KEYTYPE_EC:
                $className = KeyDetailsEC::class;
                break;
            case OPENSSL_KEYTYPE_RSA:
                $className = KeyDetailsRSA::class;
                break;
            default:
                $className = KeyDetails::class;
                break;
        }
        
        return new $className($keyDetails);
    }
    
    /**
     * @return int
     */
    public function getBits(): int
    {
        return $this->bits;
    }
    
    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
    
    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
