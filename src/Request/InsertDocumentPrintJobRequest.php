<?php

namespace Mrpix\CloudPrintSDK\Request;

use Symfony\Component\Validator\Constraints as Assert;

class InsertDocumentPrintJobRequest extends InsertPrintJobRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\File(maxSize="4096k")
     */
    protected $documentContent;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[-\w.]+\/[-\w.]+$/")
     * @Assert\Choice(choices=InsertDocumentPrintJobRequest::ALLOWED_MEDIA_TYPES)
     */
    protected $documentMediaType;

    public function __construct(?string $printerName=null, ?string $documentFile=null, ?string $mediaType=null, ?string $startTime=null)
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

    public function setDocumentMediaType(string $documentMediaType) : void
    {
        $this->documentMediaType = $documentMediaType;
    }

    public function getDocumentMediaType() : ?string
    {
        return $this->documentMediaType;
    }
}