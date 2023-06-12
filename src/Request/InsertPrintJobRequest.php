<?php

namespace Mrpix\CloudPrintSDK\Request;

use Mrpix\CloudPrintSDK\Response\PrintJobResponse;
use Symfony\Component\Validator\Constraints as Assert;

abstract class InsertPrintJobRequest extends CloudPrintRequest
{
    #[Assert\NotBlank]
    #[Assert\Regex("/^[A-Za-z0-9\-_]{3,16}$/")]
    protected $printerName;

    #[Assert\AtLeastOneOf([
        new Assert\IsNull(),
        new Assert\Regex("/^[\d]{14,14}$/")
    ])]
    protected $startTime;

    public function __construct(?string $url=null, ?string $printerName=null, ?string $startTime=null)
    {
        parent::__construct($url, CloudPrintRequest::HTTP_METHOD_POST, PrintJobResponse::class);
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

    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }
}
