<?php

namespace Mrpix\CloudPrintSDK\Response;

class PrinterResponse extends CloudPrintResponse
{
    private array $printer;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->printer = $data['printer'];
    }

    public function getPrinter(): array
    {
        return $this->printer;
    }
}
