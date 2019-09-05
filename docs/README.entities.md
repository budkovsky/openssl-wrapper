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


---
