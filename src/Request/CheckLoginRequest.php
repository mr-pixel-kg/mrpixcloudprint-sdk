<?php

namespace Mrpix\CloudPrintSDK\Request;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Mrpix\CloudPrintSDK\Response\CheckLoginResponse;

class CheckLoginRequest extends CloudPrintRequest
{
    public function __construct()
    {
        parent::__construct(CloudPrintClient::getServerUrl().'/api/v1/auth/test', CloudPrintRequest::HTTP_METHOD_GET, CheckLoginResponse::class);
    }

    public function buildMultipart(MultipartStreamBuilder $builder): MultipartStreamBuilder
    {
        return $builder;
    }
}
