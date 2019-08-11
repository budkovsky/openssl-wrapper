<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);
namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * Container for X509 certificate's issuer values
 * All fields are exactly the same like in subject
 */
class X509Issuer extends X509Subject
{
    /**
     * The constructor
     * @param array $identity Issuer subarray from openssl_x509_parse() result
     */
    public function __construct(array $identity)
    {
        parent::__construct($identity);
    }
}
