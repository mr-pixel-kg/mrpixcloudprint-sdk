<?php

namespace Mrpix\CloudPrintSDK\HttpClient;

use Http\Client\HttpClient;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Exception;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\Authentication;
use Http\Message\Authentication\BasicAuth;
use Mrpix\CloudPrintSDK\CloudPrintSDK;
use Mrpix\CloudPrintSDK\Exception\CloudPrintException;
use Mrpix\CloudPrintSDK\Exception\ConstraintViolationException;
use Mrpix\CloudPrintSDK\Exception\NetworkException;
use Mrpix\CloudPrintSDK\Exception\ServerException;
use Mrpix\CloudPrintSDK\Request\CheckLoginRequest;
use Mrpix\CloudPrintSDK\Request\CloudPrintRequest;
use Mrpix\CloudPrintSDK\Response\CloudPrintResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class CloudPrintClient
{
    public const USER_AGENT = 'MrpixCloudPrintSDK/'.CloudPrintSDK::VERSION;
    public const DEFAULT_SERVER_URL = 'https://cloudprint.mpxcloud.de';

    private HttpClient $client;
    private ValidatorInterface $validator;
    private RequestBuilder $requestBuilder;
    private ResponseBuilder $responseBuilder;

    private $authentication;

    public function __construct(?string $username=null, ?string $password=null)
    {
        // Initialisation
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        $this->requestBuilder = new RequestBuilder($this);
        $this->responseBuilder= new ResponseBuilder();
        $this->client = HttpClientDiscovery::find();

        // If no credentials are provided look for ENV variables
        if ($username == null && $password == null) {
            $username = getenv(CloudPrintSDK::ENV_USERNAME);
            $password = getenv(CloudPrintSDK::ENV_PASSWORD);
        }

        // Authenticate if credentials are given or provided in ENV
        if ($username && $password) {
            $this->login($username, $password);
        }
    }

    public function send(CloudPrintRequest $cloudPrintRequest): CloudPrintResponse
    {
        $this->validateRequest($cloudPrintRequest);

        $request = $this->requestBuilder->build($cloudPrintRequest);

        try {
            $response = $this->client->sendRequest($request);
        } catch (Exception $e) {
            throw new NetworkException('A network exception occurred!', 0, $e);
        }

        $cloudPrintResponse = $this->responseBuilder->decodeResponse($request, $response, $cloudPrintRequest->getResponseModel());

        if ($response->getStatusCode() !== 200) {
            throw new ServerException($cloudPrintRequest, $cloudPrintResponse);
        }

        return $cloudPrintResponse;
    }

    public function checkLoginCredentials(string $username, string $password)
    {
        $success = false;
        $oldAuth = $this->authentication;

        $this->login($username, $password);

        try {
            $request = new CheckLoginRequest();
            $response = $this->send($request);
            if ($response->getStatusCode() === 200) {
                $success = true;
            }
        } catch (CloudPrintException) {
        }

        $this->authentication = $oldAuth;

        return $success;
    }

    public function login(string $username, string $password)
    {
        $this->authentication = new BasicAuth($username, $password);
    }

    public function getAuthentication(): Authentication
    {
        return $this->authentication;
    }

    public static function getServerUrl(): string
    {
        // Change server url if specified in ENV
        $serverUrl = getenv(CloudPrintSDK::ENV_SERVER);

        if ($serverUrl) {
            return rtrim($serverUrl, "/");
        } else {
            return self::DEFAULT_SERVER_URL;
        }
    }

    public function validateRequest(CloudPrintRequest $request)
    {
        $validatorErrors = $this->validator->validate($request);
        $requestViolations = [];
        /** @var ConstraintViolationListInterface $violation */
        foreach ($validatorErrors as $violation) {
            $constraint = null;
            try {
                $constraint = ($violation->getConstraint() !== null) ? (new \ReflectionClass($violation->getConstraint()))->getShortName() : null;
            } catch (\ReflectionException $e) {
            }

            $requestViolations[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'constraint' => $constraint,
                'value' => $violation->getInvalidValue()
            ];
        }
        throw new ConstraintViolationException('Request is not valid!', 0, null, $requestViolations);
    }
}
