<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

use Budkovsky\OpenSslWrapper\Enum\KeyType as KeyTypeEnum;

/**
 * Key details entity
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class PKeyDetails
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
     * @return PKeyDetails
     */
    final public static function factory(array $keyDetails): PKeyDetails
    {
        switch ($keyDetails['type']) {
            case KeyTypeEnum::DH:
                $className = PKeyDetailsDH::class;
                break;
            case KeyTypeEnum::DSA:
                $className = PKeyDetailsDSA::class;
                break;
            case KeyTypeEnum::EC:
                $className = PKeyDetailsEC::class;
                break;
            case KeyTypeEnum::RSA:
                $className = PKeyDetailsRSA::class;
                break;
            default:
                $className = PKeyDetails::class;
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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'bits' => $this->bits,
            'type' => $this->type,
            'key' => $this->key
        ];
    }
}
