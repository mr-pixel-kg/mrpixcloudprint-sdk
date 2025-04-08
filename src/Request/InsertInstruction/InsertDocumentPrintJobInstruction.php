<?php

namespace Mrpix\CloudPrintSDK\Request\InsertInstruction;

use DateTime;
use Mrpix\CloudPrintSDK\Request\InsertDocumentPrintJobRequest;

class InsertDocumentPrintJobInstruction extends InsertPrintJobInstruction
{
    protected ?string $documentContent;
    protected ?string $documentName;
    protected string $documentMediaType;

    public function __construct(?string $printerName = null, ?string $documentContent = null, ?string $documentName = null, ?string $mediaType = null, ?DateTime $startTime = null)
    {
        parent::__construct($printerName, $startTime);
        $this->documentContent = $documentContent;
        $this->documentName = $documentName;
        $this->documentMediaType = $mediaType;
    }

    public function setDocumentContent(string $documentContent): void
    {
        $this->documentContent = $documentContent;
    }

    public function getDocumentContent(): ?string
    {
        return $this->documentContent;
    }

    public function setDocumentName(string $documentName): void
    {
        $this->documentName = $documentName;
    }

    public function getDocumentName(): ?string
    {
        return $this->documentName;
    }

    public function setDocumentMediaType(string $mediaType): void
    {
        $this->documentMediaType = $mediaType;
    }

    public function getDocumentMediaType(): ?string
    {
        return $this->documentMediaType;
    }

    public function buildRequest(): InsertDocumentPrintJobRequest
    {
        return new InsertDocumentPrintJobRequest($this->printerName, $this->documentContent, $this->documentName, $this->documentMediaType, ($this->startTime) ? $this->startTime->format('YmdHis') : null);
    }
}
