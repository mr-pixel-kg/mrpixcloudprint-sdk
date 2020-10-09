<?php

namespace Mrpix\CloudPrintSDK\HttpClient;

use Mrpix\CloudPrintSDK\Exception\ResponseDecodeException;
use Mrpix\CloudPrintSDK\Response\CloudPrintResponse;
use Psr\Http\Message\ResponseInterface;

class ResponseBuilder
{
    public function __construct()
    {

    }

    public function decodeResponse(ResponseInterface $response, string $class)
    {
        $body = $response->getBody();
        $data = json_decode($body, true);

        if($data === null) {
            throw new ResponseDecodeException('Failed to decode response!');
        }

        if(is_subclass_of($class, CloudPrintResponse::class)) {
            $object = new $class($data);
        }else{
            throw new \LogicException('No valid response class given!');
        }

        return $object;
    }
}