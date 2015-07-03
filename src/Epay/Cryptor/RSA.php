<?php

namespace Epay\Cryptor;

class RSA {

	private $RsaPublicKey;
	private $RsaPrivateKey;

	public function setPublicKey($key)
	{
		$this->RsaPublicKey = $key;
	}

	public function setPrivateKey($key)
	{
		$this->RsaPrivateKey = $key;
	}

	function encrypt($source)
	{
		//path holds the certificate path present in the system
		$pub_key = $this->RsaPublicKey;
		//$source="sumanth";
		$j = 0;
		$x = strlen($source) / 10;
		$y = floor($x);
		$crt = '';
		//print_r($pub_key) ;
		for ($i = 0; $i < $y; $i++) {
			$crypttext = '';

			openssl_public_encrypt(substr($source, $j, 10), $crypttext, $pub_key);
			$j = $j + 10;
			$crt.=$crypttext;
			$crt.=":::";
		}
		if ((strlen($source) % 10) > 0) {
			openssl_public_encrypt(substr($source, $j), $crypttext, $pub_key);
			$crt.=$crypttext;
		}
		return($crt);
	}

	//Decryption with private key
	function decrypt($crypttext)
	{
		$priv_key = $this->RsaPrivateKey;
		$tt = explode(":::", $crypttext);
		$cnt = count($tt);
		$i = 0;
		$str = '';
		while ($i < $cnt) {
			openssl_private_decrypt($tt[$i], $str1, $priv_key);
			$str.=$str1;
			$i++;
		}
		return $str;
	}
}