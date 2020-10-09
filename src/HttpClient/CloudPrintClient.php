<?php

namespace Mrpix\CloudPrintSDK\HttpClient;

use Http\Client\Exception;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\Authentication;
use Http\Message\Authentication\BasicAuth;
use Mrpix\CloudPrintSDK\Exception\ConstraintViolationException;
use Mrpix\CloudPrintSDK\Exception\NetworkException;
use Mrpix\CloudPrintSDK\Request\CloudPrintRequest;
use Mrpix\CloudPrintSDK\Response\PrintJobResponse;
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

        try {
            $response = $client->sendRequest($request);
        } catch (Exception $e) {
            throw new NetworkException('A network exception occured!', 0, $e);
        }
        var_dump(['code' => $response->getStatusCode().' '.$response->getReasonPhrase(), 'body' => $response->getBody()->getContents()]);

        if($response->getStatusCode() !== 200){
            echo 'StatusCode is not 200!';
            switch($response->getStatusCode()){
                case 404:
                    break;
                case 500:
                    break;
                default:
                    break;
            }
        }

        $responseBuilder= new ResponseBuilder;
        $object = $responseBuilder->decodeResponse($response, PrintJobResponse::class);

        var_dump($object);
    }

    /**
     * @deprecated Not implemented yet
     */
    public function checkLoginCredentials($username, $password)
    {
        //$this->l
        $oldAuth = $this->authentification;

        $this->login($username, $password);
        //@todo send request and validate respone

        $this->authentification = $oldAuth;

        $response = null;
        if($response->getStatusCode() === 200){
            return true;
        }else{
            return false;
        }
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
}