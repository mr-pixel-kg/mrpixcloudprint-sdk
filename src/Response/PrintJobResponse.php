<?php

namespace Mrpix\CloudPrintSDK\Response;

class PrintJobResponse extends CloudPrintResponse
{
    private $printJob;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->printJob = $data['printJob'];
    }

    public function getPrintJob() : array
    {
        return $this->printJob;
    }
}