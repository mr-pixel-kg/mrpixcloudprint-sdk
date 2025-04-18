<?php

namespace Mrpix\CloudPrintSDK\Response;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CloudPrintResponse
{
    protected RequestInterface $request;
    protected ResponseInterface $response;
    protected array $data;

    protected int $statusCode;
    protected string $message;

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->statusCode = (int) $data['statusCode'];
        if (array_key_exists('message', $data)) {
            $this->message = $data['message'];
        }
    }

    public function initOrigin(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
