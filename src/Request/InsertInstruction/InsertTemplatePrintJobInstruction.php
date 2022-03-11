<?php

namespace Mrpix\CloudPrintSDK\Request\InsertInstruction;

use DateTime;
use Mrpix\CloudPrintSDK\Request\InsertTemplatePrintJobRequest;

class InsertTemplatePrintJobInstruction extends InsertPrintJobInstruction
{
    protected $templateName;
    protected $templateVariables = [];

    public function __construct(?string $printerName=null, ?string $templateName=null, array $templateVariables=[], ?DateTime $startTime=null)
    {
        parent::__construct($printerName, $startTime);
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

    public function setTemplateVariables(array $variables): void
    {
        $this->templateVariables = $variables;
    }

    public function getTemplateVariables(): array
    {
        return $this->templateVariables;
    }

    public function buildRequest(): InsertTemplatePrintJobRequest
    {
        return new InsertTemplatePrintJobRequest($this->printerName, $this->templateName, json_encode($this->templateVariables), ($this->startTime) ? $this->startTime->format('YmdHis') : null);
    }
}
