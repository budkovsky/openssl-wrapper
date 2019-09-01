# OpenSSL Wrapper for PHP

## PublicKey class
Public key can be generated from existing private key or loaded from file:

```
use Budkovsky\OpenSslWrapper\PrivateKey;
use Budkovsky\OpenSslWrapper\PublicKey;

$privateKey = new PrivateKey();
$publicKey = $privateKey->getPublicKey();
# OR
$publicKey = PublicKey::create()->load(file_get_contents('path/to/folder/public.pem');
```
