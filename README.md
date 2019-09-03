# OpenSSL Wrapper for PHP

PHP OpenSSL object-oriented implementation.
Wraps PHP functions from ext-openssl extension to modern, PHP7-compatible objects with full type-hinting.
No results returned by reference, no "false" boolean return on failed, when expecting  scalar / object values.
According to PHP7 type-hinting implementation, sometimes "null" can be returned instead.

## Requirements
* PHP 7.2+
* ext-openssl PHP extension

## Dependencies
Optional dependency for unit tests execution is PHPUnit 8. No dependecies for using as library.

## Details and use cases
- [Wrapper class](./docs/README.wrapper.md)
- [PrivateKey class](./docs/README.privatekey.md)
- [PublicKey class](./docs/README.publickey.md)
- [CSR class](./docs/README.csr.md)
- [X509 class](./docs/README.x509.md)
- [Entities](./docs/README.entities.md)
- [Enumenrations](./docs/README.enums.md)
- [Exceptions](./docs/README.exceptions.md)
- [Collections](./docs/README.collections.md)
- [Abstraction](./docs/README.abstraction.md)
- [Traits](./docs/README.traits.md)
- [Tests](./docs/README.tests.md)
