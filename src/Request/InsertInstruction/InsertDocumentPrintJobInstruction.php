<?php

namespace Mrpix\CloudPrintSDK\Request\InsertInstruction;

use DateTime;
use Mrpix\CloudPrintSDK\Request\InsertDocumentPrintJobRequest;

class InsertDocumentPrintJobInstruction extends InsertPrintJobInstruction
{
    protected $documentContent;
    protected $documentMediaType;

    public function __construct(?string $printerName=null, ?string $documentFile=null, array $mediaType = [], ?DateTime $startTime=null)
    {
        parent::__construct($printerName, $startTime);
    }

    public function setDocumentContent(string $documentContent) : void
    {
        $this->documentContent = $documentContent;
    }

    public function getDocumentContent() : ?string
    {
        return $this->documentContent;
    }

    public function setDocumentMediaType(string $mediaType) : void
    {
        $this->documentMediaType = $mediaType;
    }

    public function getDocumentMediaType() : ?string
    {
        return $this->documentMediaType;
    }

    public function buildRequest() : InsertDocumentPrintJobRequest
    {
        return new InsertDocumentPrintJobRequest($this->printerName, $this->documentContent, $this->documentMediaType, $this->startTime->format('YmdHis'));
    }
}