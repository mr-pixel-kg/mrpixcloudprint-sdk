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
    public function decodeResponse(RequestInterface $request, ResponseInterface $response, string $class): CloudPrintResponse
    {
        $body = $response->getBody();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if ($data === null) {
            throw new ResponseDecodeException('Failed to decode response!');
        }

        if (is_subclass_of($class, CloudPrintResponse::class)) {
            try {
                $object = new $class($data);
                $object->initOrigin($request, $response);
            } catch (Exception) {
                // Try to initialize fallback response object
                try {
                    $object = new CloudPrintResponse($data);
                    $object->initOrigin($request, $response);
                } catch (Exception) {
                    throw new ResponseDecodeException('Failed to init response!');
                }
            }
        } else {
            throw new LogicException('No valid response class given!');
        }

        return $object;
    }
}
