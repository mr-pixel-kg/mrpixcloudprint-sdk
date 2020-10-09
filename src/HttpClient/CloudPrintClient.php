<?php

namespace Mrpix\CloudPrintSDK\HttpClient;

use GuzzleHttp\Psr7\MultipartStream;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication;
use Http\Message\Authentication\BasicAuth;
use Mrpix\CloudPrintSDK\Exception\ConstraintViolationException;
use Mrpix\CloudPrintSDK\Request\CloudPrintRequest;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class CloudPrintClient
{
    const SERVER_URL = 'https://dev.cloudprint.mpxcloud.de/api/v1/';

    private $validator;
    private $requestBuilder;

    private $authentification;

    public function __construct()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        $this->requestBuilder = new RequestBuilder($this);
    }

    public function send(CloudPrintRequest $cloudPrintRequest)
    {
        $this->validateRequest($cloudPrintRequest);

        $client = HttpClientDiscovery::find();

        $request = $this->requestBuilder->build($cloudPrintRequest);

        $response = $client->sendRequest($request);
        var_dump(['code' => $response->getStatusCode().' '.$response->getReasonPhrase(), 'body' => $response->getBody()->getContents()]);
    }

    public function login(string $username, string $password)
    {
        $this->authentification = new BasicAuth($username, $password);
    }

    public function getAuthentification() : Authentication
    {
        return $this->authentification;
    }

    private function validateRequest(CloudPrintRequest $request)
    {
        $validatorErrors = $this->validator->validate($request);

        if(count($validatorErrors) > 0){
            $requestViolations = [];
            /** @var ConstraintViolation $violation */
            foreach($validatorErrors as $violation){
                array_push($requestViolations, [
                    'field' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                    'constraint' => ($violation->getConstraint() !== null)?(new \ReflectionClass($violation->getConstraint()))->getShortName():null,
                    'value' => $violation->getInvalidValue()
                ]);
            }
            throw new ConstraintViolationException('Request is not valid!', 0, null, $requestViolations);
        }
    }

    public static function test()
    {
        $client = HttpClientDiscovery::find();
        $messageFactory = MessageFactoryDiscovery::find();
        //$messageFactory = Psr17FactoryDiscovery::findRequestFactory();
        $response = $client->sendRequest($messageFactory->createRequest('GET', 'http://httplug.io'));
        echo($response->getStatusCode());

        echo '\n';

        //$client = Psr18ClientDiscovery::find();
        $x = new MultipartStream([['name'=>'val', 'contents'=>'test']]);
        var_dump($x->getContents());

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest('GET', 'https://dev.cloudprint.mpxcloud.de/api/v1/auth/test');
            //->withAddedHeader('Authorization', 'Basic '.base64_encode("manuel.kienlein@mr-pixel.de:password"));

        $ba = new BasicAuth('manuel.kienlein@mr-pixel.de', 'password');
        $request = $ba->authenticate($request);

        var_dump($request->getHeaders());

        $response = $client->sendRequest($request);
        var_dump($response->getBody()->getContents());
        echo $response->getStatusCode();
    }
}