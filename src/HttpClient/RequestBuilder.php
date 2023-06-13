<?php

namespace Mrpix\CloudPrintSDK\HttpClient;

use Psr\Http\Message\RequestFactoryInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Mrpix\CloudPrintSDK\Request\CloudPrintRequest;

class RequestBuilder
{
    private RequestFactoryInterface $requestFactory;
    private MultipartStreamBuilder $multipartStreamBuilder;

    public function __construct(private CloudPrintClient $cloudPrintClient)
    {
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactoryDiscovery = new Psr17FactoryDiscovery();
        $streamFactory = $streamFactoryDiscovery->findStreamFactory();
        $this->multipartStreamBuilder = new MultipartStreamBuilder($streamFactory);
    }

    public function build(CloudPrintRequest $cloudPrintRequest)
    {
        $builder = $this->multipartStreamBuilder;
        $builder = $cloudPrintRequest->buildMultipart($builder);
        $multipartStream = $builder->build();

        $request = $this->requestFactory->createRequest($cloudPrintRequest->getMethod(), $cloudPrintRequest->getUrl());
        $request = $request->withAddedHeader('User-Agent', CloudPrintClient::USER_AGENT);
        $request = $request->withAddedHeader('Content-Type', 'multipart/form-data; boundary="'.$builder->getBoundary().'"');
        $request = $request->withBody($multipartStream);
        $builder->reset();

        $auth = $this->cloudPrintClient->getAuthentication();

        return $auth->authenticate($request);
    }
}
