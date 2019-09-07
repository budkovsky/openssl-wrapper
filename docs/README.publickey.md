[<<< OpenSSL Wrapper for PHP](../README.md)

# PublicKey class

## PublicKey object's creation
Public key can be generated from existing `PrivateKey` object or loaded from file:

```php
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\PublicKey;

$privateKey = new PrivateKey();
$publicKey = $privateKey->getPublicKey();
# OR
$publicKey = new PublicKey(file_get_contents('path/to/folder/public.pem'));
# OR
# OR
$publicKey = PublicKey::create()->load(file_get_contents('path/to/folder/public.pem'));
```

---

## Exporting public key to PEM format
Use `export()` or `exportToFile()` method to export PEM formatted private key to variable or a file.

```php
use Budkovsky\OpenSslWrapper\PrivateKey;

$key = new PublicKey();
$keyBody = $key->export();
# OR
$keyBody = $key->exportToFile('/path/to/the/target/file.pem');
```

---

## Verify singature
```php
public function verify(string $content, string $signature, int $signatureAlgorithm = SignatureAlgorithm::SHA1): int
```
PublicKey object can verify signature for given content.
Returns 1 if the signature is correct, 0 if it is incorrect, and-1 on error.

---

## Key details
```php
$details = $publicKey->getDetails();
```
`getKeyDetails()` method returns entity of [PKeyDetails](README.entities.md#pkeydetails) or descending type.

---

## Asymetric encryption
```php
public function encrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): ?string
```
Valid padding values are consts from [PaddingEnum](README.enums.md) enumeration.
`PaddingEnum::getAll()` returns list of available values for padding parameter,
`PaddingEnum::isValid($value)` can validate given value.

---

## Asymetric decryption
```php
public function decrypt(string $data, int $padding = PaddingEnum::PKCS1_PADDING): string
```
Valid padding values are consts from [PaddingEnum](README.enums.md) enumeration.
`PaddingEnum::getAll()` returns list of available values for padding parameter,
`PaddingEnum::isValid($value)` can validate given value.

---
