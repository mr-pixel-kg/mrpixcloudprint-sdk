<?php

namespace Mrpix\CloudPrintSDK\Response;

class PrinterResponse extends CloudPrintResponse
{
    private $printer;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->printer = $data['printer'];
    }
}