<?php

namespace Epay\Service;

use Epay\Response\LogoutResponse;
use Epay\Service;

class Logout extends Service
{
    const CMD = 'logout';

    public function run(Array $data = array())
    {
        $result = $this->client->call(self::CMD, array(
            'username' => $this->config->UserName,
            'partnerID' => $this->config->PartnerID,
            'Md5sessionID' => md5($this->config->SessionID),
        ));

        $response = new LogoutResponse();
        $response->Status = $result['status'];
        $response->Message = $result['message'];

        return $response;
    }
}