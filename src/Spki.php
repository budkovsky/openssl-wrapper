<?php
declare(strict_types = 1);
namespace Budkovsky\OpenSslWrapper;

use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;
use Budkovsky\OpenSslWrapper\Enum\SignatureAlgorithm;

/**
 * SPKI
 * TODO unit tests
 *
 * @see https://en.wikipedia.org/wiki/Simple_public-key_infrastructure
 * @see https://en.wikipedia.org/wiki/SPKAC
 * @see https://tools.ietf.org/html/rfc2692
 * @see https://crypto.stackexchange.com/questions/790/need-an-introduction-to-spki-or-spki-for-dummies
 */
class Spki implements StaticFactoryInterface
{

    /** @var string */
    protected $spki;

    /**
     * The constructor
     *
     * @see https://www.php.net/manual/en/function.openssl-spki-new.php
     * @param PrivateKey $privateKey
     * @param string $challenge
     * @param string $passphrase
     * @param int $algorithm
     */
    public function __construct(?PrivateKey $privateKey = null, ?string $challenge = null, ?string $passphrase = null, int $algorithm = SignatureAlgorithm::MD5)
    {
        if ($privateKey && $challenge) {
            $this->spki = openssl_spki_new(openssl_pkey_get_private($privateKey->export($passphrase), $passphrase ?? ''), $challenge, $algorithm);
        }
    }

    /**
     * Static factory
     *
     * @param PrivateKey $privateKey
     * @param string $challenge
     * @param string $passphrase
     * @param int $algorithm
     */
    public static function create(?PrivateKey $privateKey = null, ?string $challenge = null, ?string $passphrase = null, int $algorithm = SignatureAlgorithm::MD5)
    {
        return new static($privateKey, $challenge, $passphrase, $algorithm);
    }

    /**
     * Loads SPKI string
     *
     * @param string $body
     * @return Spki
     */
    public function load(string $body): Spki
    {
        $this->spki = $body;

        return $this;
    }

    /**
     * Verifies a signed public key and challenge
     *
     * @see https://www.php.net/manual/en/function.openssl-spki-verify.php
     * @return bool
     */
    public function verify(): bool
    {
        return openssl_spki_verify($this->spki);
    }

    /**
     * Exports a valid PEM formatted public key signed public key and challenge
     *
     * @see https://www.php.net/manual/en/function.openssl-spki-export.php
     * @return string
     */
    public function export(): string
    {
        return openssl_spki_export($this->spki);
    }

    /**
     * Exports the challenge assoicated with a signed public key and challenge
     *
     * @see https://www.php.net/manual/en/function.openssl-spki-export-challenge.php
     * @return string
     */
    public function exportChallenge(): string
    {
        return openssl_spki_export_challenge($this->spki);
    }
}
