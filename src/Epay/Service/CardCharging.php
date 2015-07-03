<?php

namespace Epay\Service;

use Epay\Response\ChargeResponse;
use Epay\Service;


class CardCharging extends Service
{
    const CMD = 'cardCharging';

    public function run(Array $data = array())
    {
        $des = new \Epay\Cryptor\TripleDes($this->HextoByte($this->config->SessionID));

        $result = $this->client->call(self::CMD, array(
            'transid'       => sprintf('%s_%s', $this->config->PartnerCode, (isset($data['TransID']) ? $data['TransID'] : date("YmdHms").millitime() )),
            'username'      => $this->config->UserName,
            'partnerID'     => $this->config->PartnerID,
            'mpin'          => $this->ByteToHex($des->encrypt($this->config->MPIN)),
            'target'        => '',
            'card_data'     => $this->ByteToHex($des->encrypt(sprintf('%s:%s:%s:%s', $data['Serial'], $data['CardNo'], '0', $data['Provider']))),
            'md5sessionid'  => md5($this->config->SessionID),
        ));

        $response = new ChargeResponse();
        $response->Status = $result['status'];
        $response->Message = $result['message'];

        if ($result['status'] == 1) {
            $response->TransID = $result['transid'];
            $response->Amount = $result['amount'];
            $response->ResponseAmount = $des->decrypt($this->HextoByte($result['responseamount']));
        }

        return $response;
    }
}

function millitime() {
	$microtime = microtime();
	$comps = explode(' ', $microtime);

	// Note: Using a string here to prevent loss of precision
	// in case of "overflow" (PHP converts it to a double)
	return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
}
