<?php

namespace Epay;

class TripleDes
{
    private $key;

    public function __construct($key)
    {
        $this->key= $key;
    }

    public function decrypt($text)
    {
        $key = $this->key;
        $size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($size, MCRYPT_RAND);
        $decrypted = mcrypt_decrypt(MCRYPT_3DES, $key, $text, MCRYPT_MODE_ECB,$iv);
        return rtrim($this->pkcs5_unpad($decrypted) );
    }

    public function encrypt($text)
    {
        $key = $this->key;
        $text=$this->pkcs5_pad($text, 8);  // AES?16????????
        $size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($size, MCRYPT_RAND);
        $bin = pack('H*', bin2hex($text) );
        $encrypted = mcrypt_encrypt(MCRYPT_3DES, $key, $bin, MCRYPT_MODE_ECB,$iv);
        return $encrypted;
    }

    function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }
}