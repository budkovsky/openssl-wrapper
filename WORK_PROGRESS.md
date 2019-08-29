# OpenSSL PHP Wrapper work progress


STATUS:
- "+" done
- "o" not finished
- "-" to do
- "." not needed probably
- "!" fails
- "?" unknown status

implementation / validation / tests

## CSR
- +.+ `openssl_csr_export_to_file` Exports a CSR to a file
- +.+ `openssl_csr_export` Exports a CSR as a string
- +.+ `openssl_csr_get_public_key` Returns the public key of a CSR
- +.+ `openssl_csr_get_subject` Returns the subject of a CSR
- +.+ `openssl_csr_new` Generates a CSR
- +-+ `openssl_csr_sign` Sign a CSR with another certificate (or itself) and generate a certificate

## PKCS
- `openssl_pbkdf2` Generates a PKCS5 v2 PBKDF2 string
- o-- `openssl_pkcs12_export_to_file` Exports a PKCS#12 Compatible Certificate Store File
- o-- `openssl_pkcs12_export` Exports a PKCS#12 Compatible Certificate Store File to variable
- --- `openssl_pkcs12_read` Parse a PKCS#12 Certificate Store into an array
- --- `openssl_pkcs7_decrypt` Decrypts an S/MIME encrypted message
- --- `openssl_pkcs7_encrypt` Encrypt an S/MIME message
- --- `openssl_pkcs7_read` Export the PKCS7 file to an array of PEM certificates
- --- `openssl_pkcs7_sign` Sign an S/MIME message
- --- `openssl_pkcs7_verify` Verifies the signature of an S/MIME signed message

## SPKI
- +.- `openssl_spki_export_challenge` Exports the challenge assoicated with a signed public key and challenge
- +.- `openssl_spki_export` Exports a valid PEM formatted public key signed public key and challenge
- +-+ `openssl_spki_new` Generate a new signed public key and challenge
- +.- `openssl_spki_verify` Verifies a signed public key and challenge

## X509
- +-- `openssl_x509_check_private_key` Checks if a private key corresponds to a certificate
- +-- `openssl_x509_checkpurpose` Verifies if a certificate can be used for a particular purpose
- +.- `openssl_x509_export_to_file` Exports a certificate to file
- +.- `openssl_x509_export` Exports a certificate as a string
- +.- `openssl_x509_fingerprint` Calculates the fingerprint, or digest, of a given X.509 certificate
- ... `openssl_x509_free` Free certificate resource
- +-- `openssl_x509_parse` Parse an X509 certificate and return the information as an array
- +-- `openssl_x509_read` Parse an X.509 certificate and return a resource identifier forit

## Lists
- +.+ `openssl_get_cipher_methods` Gets available cipher methods
- +.+ `openssl_get_curve_names` Gets list of available curve names for ECC
- +.+ `openssl_get_md_methods` Gets available digest methods

## Keys functions
- ... `openssl_free_key` Free key resource
- +.+ `openssl_get_privatekey` Alias of openssl_pkey_get_private
- +.+ `openssl_get_publickey` Alias of openssl_pkey_get_public
- o.o `openssl_pkey_export_to_file` Gets an exportable representation of a key into a file
- o.o `openssl_pkey_export` Gets an exportable representation of a key into a string
- ... `openssl_pkey_free` Frees a private key
- +.+ `openssl_pkey_get_details` Returns an array with the key details
- --- `openssl_pkey_get_private` Get a private key
- +.+ `openssl_pkey_get_public` Extract public key from certificate and prepare it for use
- +.+ `openssl_pkey_new` Generates a new private key

## cryptographic functions
- --- `openssl_decrypt` Decrypts data
- ??? `openssl_dh_compute_key` Computes shared secret for public value of remote DH public key and local DH key
- +++ `openssl_digest` Computes a digest
- --- `openssl_encrypt` Encrypts data
- +.. `openssl_open` Open sealed data
- +.. `openssl_seal` Seal (encrypt) data
- +++ `openssl_sign` Generate signature
- +++ `openssl_verify` Verify signature
- +.+ `openssl_private_decrypt` Decrypts data with private key
- +.+ `openssl_private_encrypt` Encrypts data with private key
- +.+ `openssl_public_decrypt` Decrypts data with public key
- +.+ `openssl_public_encrypt` Encrypts data with public key

## other
- +++ `openssl_cipher_iv_length` Gets the cipher iv length
- +.+ `openssl_error_string` Return openSSL error message
- +.+ `openssl_get_cert_locations` Retrieve the available certificate locations
- +.+ `openssl_random_pseudo_bytes` Generate a pseudo-random string of bytes
