<?php

namespace Mrpix\CloudPrintSDK\Request;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Symfony\Component\Validator\Constraints as Assert;

class InsertTemplatePrintJobRequest extends InsertPrintJobRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[A-Za-z0-9\-_]{3,16}$/")
     */
    protected $templateName;

    /**
     * @Assert\NotBlank()
     * @Assert\Json()
     */
    protected $templateVariables;

    public function __construct(?string $printerName=null, ?string $templateName=null, ?string $templateVariables=null, ?string $startTime=null)
    {
        parent::__construct(CloudPrintClient::SERVER_URL.'printjob/template', $printerName, $startTime);
        $this->templateName = $templateName;
        $this->templateVariables = $templateVariables;
    }

    public function setTemplateName(string $templateName): void
    {
        $this->templateName = $templateName;
    }

    public function getTemplateName(): ?string
    {
        return $this->templateName;
    }

    public function setTemplateVariables(string $templateVariablesJson): void
    {
        $this->templateVariables = $templateVariablesJson;
    }

    public function getTemplateVariables(): ?string
    {
        return $this->templateVariables;
    }

    public function buildMultipart(MultipartStreamBuilder $builder): MultipartStreamBuilder
    {
        $builder
            ->addResource('printerName', $this->printerName)
            ->addResource('templateName', $this->templateName)
            ->addResource('templateVariables', $this->templateVariables);

        if ($this->startTime !== null) {
            $builder = $builder->addResource('startTime', $this->startTime);
        }

        return $builder;
    }
}
