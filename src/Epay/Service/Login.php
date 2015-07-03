<?php

namespace Epay\Service;

use Epay\Response\LoginResponse;
use Epay\Service;


class Login extends Service
{
    const CMD = 'login';

    public function run(Array $data = array())
    {
		$rsa = new \Epay\Cryptor\RSA();
		$rsa->setPublicKey(file_get_contents($this->config->PublicKeyFile));
        $encryptedPassword = base64_encode($rsa->encrypt($this->config->Password));

        $result = $this->client->call(self::CMD, array(
            'username' => $this->config->UserName,
            'password' => $encryptedPassword,
            'partnerID' => $this->config->PartnerID,
        ));

        $response = new LoginResponse();
        $response->Status = $result['status'];
        $response->Message = $result['message'];

        if ($result['status'] == 1) {
            $rsa->setPrivateKey(file_get_contents($this->config->PrivateKeyFile));
            $sessionID = $rsa->decrypt(base64_decode($result['sessionid']));

            $response->SessionID = $sessionID;
            $response->TransID = $result['transid'];
        }

        return $response;
    }
}