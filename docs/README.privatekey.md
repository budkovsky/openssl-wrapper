[<<< OpenSSL Wrapper for PHP](../README.md)

# PrivateKey class

## PrivateKey object creation
Private class can be created in two ways:
- via classic constructor
- or via static factory method:

```php
//via constructor
$key = new PrivateKey();

//via static factory
$key = PrivateKey::create();
```
If you want to set some specific parameters for a new key, use `ConfigArgs` object as the parameter for the constructor or static factory.

```php
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\Entity\ConfigArgs;

//set parameters for a new key into ConfigArgs object
$configArgs = ConfigArgs::create()
	->setPrivateKeyType(KeyType::RSA)
	->setEncryptKey(false);

//pass ConfigArgs object to the constructor
$key = new PrivateKey($configArgs);
```

## Reading existing private key from file
Immediately after creating a new object, PrivateKey contains completely new key generated by the constructor. If you want to use existing key, call `load()` with string parameter representing key body.

```php
use Budkovsky\OpenSslWrapper\PrivateKey;

$key = $new PrivateKey();
$pem = file_get_contents('/path/to/folder/key.pem');
$key->load($pem); //key without passphrase
# OR
$key->load($pem, 'secretpassphrase'); //if key is proctected by passphrase
```

## Exporting private key to PEM format
Use `export()` or `exportToFile()` method to export PEM formatted private key to variable or a file.

```php
use Budkovsky\OpenSslWrapper\PrivateKey;

$key = new PrivateKey();
$keyBody = $key->export();
# OR
$keyBody = $key->exportToFile('/path/to/the/target/file.pem');
```

## Public key

Public key can be retrived by `getPublicKey` method.
```php
use Budkovsky\OpenSslWrapper\PrivateKey;

$privateKey = new PrivateKey();
$publicKey = $privateKey->getPublicKey();
```

## Signing
```php
$signature = $privateKey->sign($contentToSign, 'MD5');
```
Second parameter is optional, default signature algorithm is SHA1.

## Key details
```php
$details = $privateKey->getDetails();
```
`getKeyDetails()` method returns entity of [PKeyDetails](README.entities.md#pkeydetails) or descending type.

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
