<?php

namespace Mrpix\CloudPrintSDK\Response;

class CheckLoginResponse extends CloudPrintResponse
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }
}