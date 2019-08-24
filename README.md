# OpenSSL Wrapper for PHP

PHP OpenSSL object-oriented implementation.
Wraps PHP functions from ext-openssl extension to modern, PHP7-compatible objects with full type-hinting.
No results returned by reference, no "false" boolean return on failed, when expecting  scalar / object values. 
According to PHP7 type-hinting implementation, sometimes "null" can be returned instead.

## Requirements
* PHP 7.2+
* ext-openssl PHP extension

## Wrapper class
Wrapper contains functions not associated with other objects like *PrivateKey* or *X509*. Functions are callable staticly, for example:

```php
OpenSSL::getDigestMethods(true);
```
Wrapper includes two extra methods, not exist in orginal OpenSSL extension for PHP.

```php
Wrapper::isDigestMethodValid($someMethod);
Wrapper::isCipherMethodValid($otherMethod);
```

## PrivateKey class

## PublicKey class

## Csr class

## X509 class

## Entities

## Enums

## Collections

## Exceptions

## Abstraction

## Traits

## Unit tests

Unit tests are placed in `/tests` folder and require PHPUnit 8.


