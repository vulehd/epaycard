<?php

namespace Epay;

class Config
{
	private $PartnerID;
	private $PartnerCode;
	private $MPIN;
	private $UserName;
	private $Password;

	public function __construct($config = array()) {
		foreach ($config as $k => $v) {
			$this->$k = $v;
		}
	}
}