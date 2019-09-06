[<<< OpenSSL Wrapper for PHP](../README.md)

# Entities

Entities are simple data containers with private properties and public setter/getter methods.

---

## CertLocations

`CertLocations` class implements singleton design pattern
and stores paths to the system certificates locations.
Class doesn't have any setter, getters only and should be recognized as read-only data container.

```php
$certLocations = CertLocations::getInstance();
```
Available getter methods:
- getDefaultCertFile()
- getDefaultCertFileEnv()
- getDefaultCertDir();
- getDefaultCertDirEnv()
- getDefaultPrivateDir()
- getDefaultDefaultCertArea()
- getIniCAFile()
- getIniCAPath()

---

## ConfigArgs
`ConfigArgs` groups key parameters useful with `Csr`, `PrivateKey` and `X509` objects.
Available properties:
- digestAlg (string)
- x509Extensions (string)
- reqExtensions (string)
- privateKeyBits (int)
- privateKeyType (int)
- encryptKey (bool)
- encryptKeyCipher (int)
- curveName (string)
- config (string)

Example of use:
```php
$configArgs = ConfigArgs::create()->setPrivateKeyBits(4096)->setEncryptKey(false);
$privateKey = new PrivateKey($configArgs);
```

---

## CsrSubject
```php
public function __construct(array $subject = [])
```
Container for certificate's subject distinguished name data.
List of properties:
- countryName
- stateOrProvince
- localityName
- organizationName
- organizationalUnitName
- commonName
- emailAddress
Values of the fields can be set by setters or by the constructor,
if valid array is passed to.
[See more.](https://www.php.net/manual/en/function.openssl-csr-get-subject.php)

---

## PKeyDetails
```php
public function __construct(array $keyDetails)
```
Container for key details information. Read-only entity, no setters.
Data is passed to the object by constructor.
Array parameter is result of `openssl_pkey_get_details()` function.
The same array can be passed to the `factory()` method
which returns `PKeyDetails` or descendant type, according to the parameter data.
[See more.](https://www.php.net/manual/en/function.openssl-pkey-get-details.php)

List of properties:
- bits (int)
- key (string)
- type (int)
For valid values of `type` property use consts from `KeyType` enumeration class.
[See.](README.enums.md#keytype)

### PKeyDetailsDH
Read-only entity, extends `PKeyDetails`, contains DH key specific data.
List of additional properties:
- prime (string)
- generator (string)
- privateKey (string)
- publicKey (string)

### PKeyDetailsDSA
Read-only entity, extends `PKeyDetails`, contains DSA key specific data.
List of additional properties:
- primeNumber (string)
- subprime (string)
- generatorOfSubgroup (string)
- privateKey (string)
- publicKey (string)

### PKeyDetailsEC
Read-only entity, extends `PKeyDetails`, contains EC key specific data.
List of additional properties:
- curveName (string)
- curveOid (string)
- xCoordinate (string)
- yCoordinate (string)
- privateKey (string)

### PKeyDetailsRSA
Read-only entity, extends `PKeyDetails`, contains RSA key specific data.
List of additional properties:
- modulus (string)
- publicExponent (string)
- privateExponent (string)
- prime1 (string)
- prime2 (string)
- exponent1 (string)
- exponent2 (string)
- coefficient (string)

---

## SealResult

---

## X509Data

---

## X509Extensions

---

## X509Issuer

---

## X509Purposes

---

## X509Subject
