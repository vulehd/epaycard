<?php

namespace Epay\Response;

use Epay\Response;

class ChargeResponse extends Response
{
    public $TransID;
    public $Amount;
    public $ResponseAmount;
}