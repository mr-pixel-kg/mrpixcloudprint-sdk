<?php

namespace Mrpix\CloudPrintSDK\Request;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Mrpix\CloudPrintSDK\Response\CloudPrintResponse;
use Symfony\Component\Validator\Constraints as Assert;

abstract class CloudPrintRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"GET", "POST"})
     */
    protected $method;

    /**
     * @Assert\NotBlank()
     * @Assert\Url
     */
    protected $url;

    protected $responseModel;

    public function __construct(?string $url=null, ?string $method='GET', ?string $responseModel=CloudPrintResponse::class)
    {
        $this->method = $method;
        $this->url = $url;
        $this->responseModel = $responseModel;
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getResponseModel() : string
    {
        return $this->responseModel;
    }

    public abstract function buildMultipart(MultipartStreamBuilder $builder) : MultipartStreamBuilder;
}