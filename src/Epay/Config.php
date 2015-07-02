<?php

namespace Epay;

class Config
{
    public $EndPoint;
    public $PublicKeyFile;
    public $PrivateKeyFile;
	public $PartnerID;
    public $PartnerCode;
    public $MPIN;
    public $UserName;
    public $Password;
    public $SessionID;

	public function __construct(Array $config = array())
    {
		foreach ($config as $k => $v) {
			$this->$k = $v;
		}
	}
}