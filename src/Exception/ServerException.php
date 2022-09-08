<?php

namespace Mrpix\CloudPrintSDK\Exception;

use Mrpix\CloudPrintSDK\Request\CloudPrintRequest;
use Mrpix\CloudPrintSDK\Response\CloudPrintResponse;

class ServerException extends CloudPrintException
{
    protected $request;
    protected $response;
    protected $data;

    protected $statusCode;
    protected $exception;

    public function __construct(CloudPrintRequest $request, CloudPrintResponse $response)
    {
        parent::__construct('A API-Exception occurred!', 0, null);

        $this->request = $request;
        $this->response = $response;
        $this->statusCode = $response->getStatusCode();
        $data = $this->response->getData();
        $this->data = $data;

        if ($response->getMessage() !== null) {
            $this->message = $response->getMessage();
        }

        if (array_key_exists('exception', $data)) {
            $this->exception = new JsonException($data['exception']);
        }
    }

    public function getRequest(): CloudPrintRequest
    {
        return $this->request;
    }

    public function getResponse(): CloudPrintResponse
    {
        return $this->response;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getServerException(): ?JsonException
    {
        return $this->exception;
    }
}
