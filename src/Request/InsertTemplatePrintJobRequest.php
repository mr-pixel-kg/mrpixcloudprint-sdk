<?php

namespace Mrpix\CloudPrintSDK\Request;

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
        parent::__construct($printerName, $startTime);
    }

    public function setTemplateName(string $templateName) : void
    {
        $this->templateName = $templateName;
    }

    public function getTemplateName() : ?string
    {
        return $this->templateName;
    }

    public function setTemplateVariables(string $templateVariablesJson) : void
    {
        $this->templateVariables = $templateVariablesJson;
    }

    public function getTemplateVariables() : ?string
    {
        return $this->templateVariables;
    }
}