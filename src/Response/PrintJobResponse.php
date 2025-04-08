<?php

namespace Mrpix\CloudPrintSDK\Response;

class PrintJobResponse extends CloudPrintResponse
{
    private array $printJob;

    public function __construct(array $data)
    {
        parent::__construct($data);
        if (array_key_exists('PrintJob', $data)) {
            $this->printJob = $data['printJob'];
        }
    }

    public function getPrintJob(): array
    {
        return $this->printJob;
    }
}
