<?php
namespace Budkovsky\OpenSslWrapper\Abstraction;

use Budkovsky\OpenSslWrapper\Enum\Padding as PaddingEnum;
use Budkovsky\OpenSslWrapper\Exception\PaddingException;
use Budkovsky\OpenSslWrapper\Entity\PKeyDetails;

/**
 * PKey abstract
 * @see \Budkovsky\OpenSslWrapper\PrivateKey
 * @see \Budkovsky\OpenSslWrapper\PublicKey
 */
abstract class PKeyAbstract implements KeyInterface
{
    /** @var resource */
    protected $keyResource;

    /**
     * PKey destructor
     */
    public function __destruct()
    {
        if ($this->keyResource) {
            openssl_free_key($this->keyResource);
        }
    }

    /**
     * Returns the key details
     * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
     * @return PKeyDetails
     */
    public function getDetails(): PKeyDetails
    {
        return PKeyDetails::factory(openssl_pkey_get_details($this->keyResource));
    }

    /**
     * Decrypt data using PKey
     * @param string $data
     * @param int $padding
     * @throws PaddingException
     * @return string
     */
    public function decrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): string
    {
        if (!PaddingEnum::isValid($padding)) {
            throw new PaddingException(sprintf(
                "Invalid OpenSSL padding parameter for decryption: `%s`. Valid values are: `%s`",
                $padding,
                implode('`, `', PaddingEnum::getAll())
            ));
        }

        return $this->executeDecryption($data, $padding);
    }

    /**
     * Encrypt data using PKey
     * @param string $data
     * @param int $padding
     * @throws PaddingException
     * @return string|NULL
     */
    public function encrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): ?string
    {
        if (!PaddingEnum::isValid($padding)) {
            throw new PaddingException(sprintf(
                "Invalid OpenSSL padding parameter for encryption: `%s`. Valid values are: `%s`",
                $padding,
                implode('`, `', PaddingEnum::getAll())
            ));
        }

        return $this->executeEncryption($data, $padding);
    }

    /**
     * Execute decryption using PKey
     * @param string $data
     * @param int $padding
     * @return string|NULL
     */
    abstract protected function executeDecryption(string $data, int $padding): ?string;

    /**
     * Execute encryption using PKey
     * @param string $data
     * @param int $padding
     * @return string|NULL
     */
    abstract protected function executeEncryption(string $data, int $padding): ?string;

    /**
     * Casts PKey object to a string
     * @return string
     */
    public function __toString(): string
    {
        return $this->export();
    }
}
