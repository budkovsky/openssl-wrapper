[<<< OpenSSL Wrapper for PHP](../README.md)

# CSR class

CSR is an object of certificate signing request.
[See more](https://en.wikipedia.org/wiki/Certificate_signing_request)

## Object 's instantation
There are two ways to create CSR object - classic `new Csr()`
or via static factory `Csr::create()`.
```php
public function __construct(PrivateKey $privateKey, ?CsrSubject $subject = null, ?ConfigArgs $configArgs = null, ?array $extraAttribs = null)
```
```php
public static function create(PrivateKey $privateKey = null, ?CsrSubject $subject = null, ?ConfigArgs $configArgs = null, ?array $extraAttribs = null): Csr
```
First parameter is mandatory `PrivateKey` object.
Optional [CsrSubject](README.entities.md#csrsubject)
and [ConfigArgs](README.entities.md#configargs) are entity objects.

---

## Export to PEM format
Use `export()` or `exportToFile()` method to export PEM formatted CSR certificate to variable or a file.

```php
use Budkovsky\OpenSslWrapper\PrivateKey;

$key = new PrivateKey();
$keyBody = $key->export();
# OR
$keyBody = $key->exportToFile('/path/to/the/target/file/');
```

---

## Getting public key from CSR
```php
public function getPublicKey(bool $shortNames = true): ?PublicKey
```

---

## CSR subject
CSR subject provides detail information about the certificate.
```php
public function getSubject(bool $use_shortnames = true): CsrSubject
```
Returned data is a [CsrSubject](README.entities.md#csrsubject) entity.

---

## Signing
```php
public function sign(PrivateKey $privateKey, int $days = 365, KeyInterface $caCert = null, ?ConfigArgs $configArgs = null, $serial = 0): X509
```

From private key ```Csr::sign()``` method generates a certficate
signed by [CA certificate](https://en.wikipedia.org/wiki/Certificate_authority)
 if exists in `$caCert` parameter.
Otherwise self-signed certficate is generated.
Signature is valid for period equals to number od days specified by `$days` parameter.
Additional parameters are available via [ConfigArgs](README.entities.md#configargs) entity.
Return value is [X509](REDAME.x509.md) object.
