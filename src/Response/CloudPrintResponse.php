<?php

namespace Mrpix\CloudPrintSDK\Response;

abstract class CloudPrintResponse
{
    protected $statusCode;

    public function __construct(array $data)
    {
        $this->statusCode = $data['statusCode'];
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}