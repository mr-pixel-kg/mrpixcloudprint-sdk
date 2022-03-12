<?php

namespace Mrpix\CloudPrintSDK\HttpClient;

use Exception;
use LogicException;
use Mrpix\CloudPrintSDK\Exception\ResponseDecodeException;
use Mrpix\CloudPrintSDK\Response\CloudPrintResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseBuilder
{
    public function __construct()
    {
    }

    public function decodeResponse(RequestInterface $request, ResponseInterface $response, string $class): CloudPrintResponse
    {
        $body = $response->getBody();
        $data = json_decode($body, true);

        if ($data === null) {
            throw new ResponseDecodeException('Failed to decode response!');
        }

        if (is_subclass_of($class, CloudPrintResponse::class)) {
            try {
                $object = new $class($data);
                $object->initOrigin($request, $response);
            } catch (Exception $e) {
                // Try to initialize fallback response object
                try {
                    $object = new CloudPrintResponse($data);
                    $object->initOrigin($request, $response);
                } catch (Exception $e) {
                    throw new ResponseDecodeException('Failed to init response!');
                }
            }
        } else {
            throw new LogicException('No valid response class given!');
        }

        return $object;
    }
}
