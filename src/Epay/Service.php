<?php

namespace Epay;

use Aw\Nusoap\NusoapClient;

class Service
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \Aw\Nusoap\NusoapClient
     */
    protected $client;

    public function __construct(Config $config)
    {
        $this->config = $config;

        // create SOAP client
        $this->client = new NusoapClient($this->config->EndPoint);
    }

    public function run(Array $data = array())
    {
        die('Need override');
    }

    public function HextoByte($strHex){
        $string='';
        for ($i=0; $i < strlen($strHex)-1; $i+=2)
        {
            $string .= chr(hexdec($strHex[$i].$strHex[$i+1]));
        }
        return  $string;
    }

    public function ByteToHex($strHex){
        return   bin2hex ($strHex);
    }
}
