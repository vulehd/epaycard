<?php

namespace Epay;

class Response {
	public $Status;
	public $Message;

    public function __construct(Array $data = array())
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }
}