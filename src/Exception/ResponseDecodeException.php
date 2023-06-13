<?php

namespace Mrpix\CloudPrintSDK\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class ResponseDecodeException extends CloudPrintException
{
    private ?ResponseInterface $response;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, ResponseInterface $response = null)
    {
        parent::__construct($message.' '.json_encode($response, JSON_ERROR_NONE), $code, $previous);
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

}
