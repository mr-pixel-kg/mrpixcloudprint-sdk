<?php

namespace Mrpix\CloudPrintSDK\Request;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Mrpix\CloudPrintSDK\Response\CloudPrintResponse;
use Symfony\Component\Validator\Constraints as Assert;

abstract class CloudPrintRequest
{
    public const HTTP_METHOD_GET = 'GET';
    public const HTTP_METHOD_POST = 'POST';

    #[Assert\NotBlank]
    #[Assert\Choice(['GET', 'POST'])]
    protected ?string $method;

    #[Assert\NotBlank]
    #[Assert\Url]
    protected ?string $url;

    #[Assert\NotBlank]
    protected ?string $responseModel;

    public function __construct(?string $url = null, ?string $method = self::HTTP_METHOD_GET, ?string $responseModel = CloudPrintResponse::class)
    {
        $this->method = $method;
        $this->url = $url;
        $this->responseModel = $responseModel;
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getResponseModel(): string
    {
        return $this->responseModel;
    }

    abstract public function buildMultipart(MultipartStreamBuilder $builder): MultipartStreamBuilder;
}
