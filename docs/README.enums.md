[<<< OpenSSL Wrapper for PHP](../README.md)

# Enumerations

Enumeration is a list o values, valid for specific usage. 
For example enumaration of hash algorithms can contains values like:
 'MD5', 'SHA1', 'SHA256', 'SHA512' etc.
 In this project `Enum` is non-instantationable class
 that extends `EnumAbstract` class,
 groups some values in constants
 and has two static methods.
 
 ## getAll method
 ```php
 public static function getAll(): array;
```
 Returns all values defined in class consts.