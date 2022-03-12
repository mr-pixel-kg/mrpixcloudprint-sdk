<?php

namespace Mrpix\CloudPrintSDK\Request;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Mrpix\CloudPrintSDK\Components\MediaTypes;
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Symfony\Component\Validator\Constraints as Assert;

class InsertDocumentPrintJobRequest extends InsertPrintJobRequest
{
    public const ALLOWED_MEDIA_TYPES =  MediaTypes::ALLOWED_INPUT_MEDIATYPES;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 16,
     *     max = 4096,
     *     allowEmptyString = false
     * )
     */
    protected $documentContent;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[-\w.]+\/[-\w.]+$/")
     * @Assert\Choice(choices=InsertDocumentPrintJobRequest::ALLOWED_MEDIA_TYPES)
     */
    protected $documentMediaType;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[\w,\s-]+\.[A-Za-z]{2,4}$/")
     */
    protected $documentName;

    public function __construct(?string $printerName=null, ?string $documentContent=null, ?string $documentName=null, ?string $mediaType=null, ?string $startTime=null)
    {
        parent::__construct(CloudPrintClient::getServerUrl().'/api/v1/printjob/document', $printerName, $startTime);
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

    public function setDocumentMediaType(string $documentMediaType): void
    {
        $this->documentMediaType = $documentMediaType;
    }

    public function getDocumentMediaType(): ?string
    {
        return $this->documentMediaType;
    }

    public function buildMultipart(MultipartStreamBuilder $builder): MultipartStreamBuilder
    {
        $builder
            ->addResource('printerName', $this->printerName)
            ->addResource('documentFile', $this->documentContent, ['filename' => $this->documentName])
            ->addResource('documentMediaType', $this->documentMediaType);

        if ($this->startTime !== null) {
            $builder = $builder->addResource('startTime', $this->startTime);
        }

        return $builder;
    }
}
