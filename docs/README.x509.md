[<<< OpenSSL Wrapper for PHP](../README.md)

# X509 class

X509 certificate contains public key and identity information.
Is signed by certificate authority or self-signed.
[See more.](https://en.wikipedia.org/wiki/X.509)

---

## Object's instantation
X509 object can be created by constructor or by static factory using `create()` method.
```php
public function __construct(
    ?Csr $csr = null,
    ?PrivateKey $privateKey = null,
    int $days = 365,
    ?KeyInterface $caCert = null,
    ?ConfigArgs $configArgs = null,
    int $serial = 0
)
```
```php
public static function create(
    ?Csr $csr = null,
    ?PrivateKey $privateKey = null,
    int $days = 365,
    ?KeyInterface $caCert = null,
    ?ConfigArgs $configArgs = null,
    int $serial = 0
)
```
If `$csr` and `$privateKey` parameters are provided, the constructor signs the key
and creates X509 certficate resource. `$days` parameters determines
how long the certficate is valid.
Certificate is self-signed or signed by key given in `$caCert` parameter.
Additional options are available via `$configArgs` and `$serial` parameters.

## Loading existing certificate from a string
Alternative ways to build proper X509 object is loading exisiting certificate from string
after creation X509 instation without any parameters.
```php
$certificateBody = file_get_contents('/path/to/certificate.pem');
// ...
$x509 = new X509();
$x509->load($certificateBody);
# OR
$x509 = X509::create()->load($certificateBody);
```

---

# Getting certificate details
Detailed certficiate info is available via `getX509Data` method.
```php
public function getX509Data(): X509Data
```
The method returns [X509Data](README.entities.md#x509data) entity.

---

## Exporting certificate to PKCS12 string
```php
public function exportToPkcs12(PrivateKey $privateKey, string $password, array $args=[]): ?string
```

---

## Exporting certificate to PKCS12 file
```php
public function exportToPkcs12File(string $filename, PrivateKey $privateKey, string $password, array $args = []): ?X509
```

---

## Fingerprint
```php
public function getFingerprint(string $hashAlgorithm = 'sha1', bool $rawOutput = false): ?string
```
`getFingerprint()` method retuns certificate's fingerprint, hashed with given algorithm.
Default algorithm is `sha1`. On fail returns `null`.
`$hasAlgorithm` parameter is validated by `Wrapper::isDigestMethodValid()`.
List of all available algorithms are available via `Wrapper::getDigestMethods()`.

---

## Checking private key
```php
public function checkPrivateKey(PrivateKey $privateKey, string $passphrase = null, ?ConfigArgs $configArgs = null): bool
```
Checks if a private key corresponds to a certificate.

## Purpose check
Not implemented due to some problems with `openssl_x509_checkpurpose()` function.
