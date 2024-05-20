<?php
phpinfo();

$data = "「こんにちは、世界";
echo $data."（暗号化前）」";
$key = openssl_random_pseudo_bytes(32);
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

$encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
$decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
echo "\r\n";
echo $decrypted."（暗号化後）」";