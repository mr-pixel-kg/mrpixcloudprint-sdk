<?php

namespace Mrpix\CloudPrintSDK\Request\InsertInstruction;

use DateTime;

abstract class InsertPrintJobInstruction
{
    protected $printerName;
    protected $startTime;

    public function __construct(string $printerName = null, DateTime $startTime = null)
    {
        $this->printerName = $printerName;
        $this->startTime = $startTime;
    }

    public function setPrinterName(string $printerName): void
    {
        $this->printerName = $printerName;
    }

    public function getPrinterName(): ?string
    {
        return $this->printerName;
    }

    public function setStartTime(DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getStartTime(): ?DateTime
    {
        return $this->startTime;
    }

    abstract public function buildRequest();
}
