<?php
/**
 * @author Budkovsky <http://github.com/budkovsky>
 * @copyright 2019
 */
declare(strict_types = 1);

namespace Budkovsky\OpenSslWrapper\Entity;

/**
 * EC key details
 * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
 */
class KeyDetailsEC extends KeyDetails
{
    private $curveName;
    private $curveOid;
    private $xCoordinate;
    private $yCoordinate;
    private $privateKey;
    
    /**
     * {@inheritDoc}
     */
    public function __construct(array $keyDetails)
    {
        parent::__construct($keyDetails);
        $ecDetails = $keyDetails['ec'];
        $this->curveName = $ecDetails['curve_name'];
        $this->curveOid = $ecDetails['curve_oid'];
        $this->xCoordinate = $ecDetails['x'];
        $this->yCoordinate = $ecDetails['y'];
        $this->privateKey = $ecDetails['d'];
    }

    /**
     * (curve_name)Name of curve getter
     * @see https://www.php.net/manual/en/function.openssl-get-curve-names.php
     * @return string
     */
    public function getCurveName(): string
    {
        return $this->curveName;
    }

    /**
     * (curve_oid) ASN1 Object identifier (OID) for EC curve getter
     * @return string
     */
    public function getCurveOid(): string
    {
        return $this->curveOid;
    }

    /**
     * (x)x coordinate(public) getter
     * @return string
     */
    public function getXCoordinate(): string
    {
        return $this->xCoordinate;
    }

    /**
     * (y)y coordinate (public) getter
     * @return string
     */
    public function getYCoordinate(): string
    {
        return $this->yCoordinate;
    }

    /**
     * (d)private key getter
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }
}
