[<<< HOME](../README.md)

# OpenSSL Wrapper for PHP

## Wrapper class
Wrapper contains functions not associated with other objects like *PrivateKey* or *PublicKey*.
Functions are callable staticly and Wrapper class doesn't contain any properties.
More complex functions are associated with other, instantiationable classes.

List of available methods:
- [cipherIvLength](#cipherIvLength)
- [computeDigest](#computeDigest)
- [decrypt](#decrypt)
- [encrypt](#encrypt)
- [getErrorString](#getErrorString)
- [getCertLocations](#getCertLocations)
- [getCurveNames](#getCurveNames)
- [getCipherMethods](#getCipherMethods)
- [isCipherMethodValid](#isCipherMethodValid)
- [getDigestMethods](#getDigestMethods)
- [isDigestMethodValid](#isDigestMethodValid)
- [getRandomPseudoBytes](#getRandomPseudoBytes)
- [seal](#seal)
- [unseal](#unseal)


---

### cipherIvLength
```php
public static function cipherIvLength(string $method): int
```
Returns cipher `iv`[(initialization vector)](https://en.wikipedia.org/wiki/Initialization_vector)
length for given method. The method has to be a valid value from list
returned by `Wrapper::getCipherMethods()`. Cipher length value can be useful with the following methods:
- `Wrapper::encrypt()`
- `Wrapper::decrypt`
- `Wrapper::seal()`
- `Wrapper::unseal()`

---

### computeDigest
```php
public static function computeDigest(string $data, string $method, bool $rawOutput = false): string
```
Computes a digest hash value for the given data using a given method, and returns a raw or binhex encoded string.

---

### decrypt
```php
public static function decrypt(
    string $data,
    string $method,
    KeyInterface $key,
    string $iv,
    int $options = 0,
    ?string $tag = null,
    ?string $additionalAuthenticationData = null
): ?string
```
Symetric decryption with given method, key and initialization vector(iv).
Returned data is raw binary or base64 encoded string, or NULL on fail.

---

### encrypt
```php
public static function encrypt(
    string $data,
    string $method,
    KeyInterface $key,
    string $iv,
    int $options = 0,
    ?string $tag = null,
    string $additionalAuthenticationData = '',
    int $tagLength = 16
): ?string
```
Symetric encryption with given method, key and intialization vector(iv).
Returns a raw binary or base64 encoded string.

---

### getErrorString
```php
public static function getErrorString(): ?string
```
Return openSSL message on error or NULL if none.

---

### getCertLocations
```php
public static function getCertLocations(): CertLocations
```
Retrieves the available certificate locations.
Returns [CertLocations](README.entities.md#certlocations) entity.

---

### getCurveNames
```php
public static function getCurveNames(): array
```

---

### getCipherMethods
```php
public static function getCipherMethods(bool $aliases = false): array
```
List of available cipher methods.

---

### isCipherMethodValid
```php
public static function isCipherMethodValid(string $cipherMethod): bool
```
Validates cipher method.
Extra method, not existing in orginal OpenSSL extension for PHP.

---

### getDigestMethods
```php
public static function getDigestMethods(bool $asliases = false): array
```
Available digest methods.

---

### isDigestMethodValid
```php
public static function isDigestMethodValid(string $digestMethod): bool
```
Validates digest method.
Extra method, not existing in orginal OpenSSL extension for PHP.

---

### getRandomPseudoBytes
```php
public static function getRandomPseudoBytes(int $length, bool $cryptoStrong = true): ?string
```
Returns raw binary pseudo-random string.

---

### seal
```php
public static function seal(string $data, PublicKeyCollection $publicKeys, string $method = 'RC4', ?string $iv = null): ?SealResult
```
Seal (encrypt) data with multiple keys.
[See more](https://www.php.net/manual/en/function.openssl-seal.php)

---

### unseal
```php
public static function unseal(string $sealedData, string $envKey, PrivateKey $privateKey, string $passphrase = null, string $method = 'RC4', string $iv = ''): ?string
```

Opens sealed data.
[See more](https://www.php.net/manual/en/function.openssl-open.php)
