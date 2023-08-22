# MrpixCloudPrint SDK

![Version](https://img.shields.io/github/v/release/mr-pixel-kg/mrpixcloudprint-sdk?display_name=tag&sort=semver)
![Test](https://github.com/mr-pixel-kg/mrpixcloudprint-sdk/actions/workflows/test.yml/badge.svg)
![Code Size](https://shields.io/github/languages/code-size/mr-pixel-kg/mrpixcloudprint-sdk)
![Downloads](https://img.shields.io/packagist/dt/mrpix/cloudprintsdk)
![License](https://img.shields.io/github/license/mr-pixel-kg/mrpixcloudprint-sdk)

This is the official PHP SDK of mr. pixel's CloudPrint service. This library contains methods to easily interact with the
mpXcloudprint API. Below is a short instruction with some examples to get started with this SDK. For additional 
information, please visit our official documentation.

## Installation
This library is not dependent to any http client like Guzzle. You can use any http client hat supports the 
[php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation).

To get started quickly, install the cloudprint-sdk along with your favourite http client like Guzzle or Symfony Http Client:
```
composer require mrpix/cloudprintsdk symfony/http-client
```

## Usage
This project depends on Composer. It is recommended to let the Composer autoloader automatically load all your 
dependencies. The example below will show you how to include the client for the mpXcloudprint API.

```php
require 'vendor/autoload.php';
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;

$client = new CloudPrintClient();
```
### Authentication
Some actions require you to be authenticated. There are three options you can use for authentication.

1. **Provide login credentials to CloudPrintClient constructor**

    The first option is to provide your login credentials when constructing the CloudPrintClient.
    To do this you have to hand over the username in the first argument and the password in the 
    second argument.
    
    ```php
    // Load credentials from config
    $username = 'your-username@example.com';
    $password = 'yourSecretPassword';
    
    $client = new CloudPrintClient($username, $password);
    ```
   
   However, using hardcoded login credentials is not secure. This method is perfect if you want to load credentials 
   dynamically from some configuration. For static credentials, the recommended way is to use environment variables.

2. **Environment Variables**

    If you don't provide your login credentials in the first option, the cloudprint SDK looks for environment variables.
    You can provide your credentials in the following environment variables:
    
    ```
    MRPIX_CLOUDPRINT_USERNAME=your-username@example.com
    MRPIX_CLOUDPRINT_PASSWORD=yourSecretPassword
    ```

3. **Explicit login**

    The third option is to login with your credentials only if authentication is required.
    To do this, you have to call the login method before sending requests.
    Here is a example on how to do that:
    
    ```php
    $client->login('your-username@example.com', 'yourSecretPassword');
    ```

Note: If the login credentials are not correct, the server will return a 401 or 403 response for all requests.

#### Test login credentials
To test if login credentials are correct, you can use the following example:

```php
if($client->checkLoginCredentials('your-username@example.com', 'yourSecretPassword'))
{
    echo 'Login successful!';
} else {
    echo 'Login failed!';
}
```

### Insert a new printjob
The following section explains how to create a new printjob. It is recommended to create a new instance of an instruction.
The request can be build by using the 'build' method of the instruction. By compiling the request, all given data will be 
automatically parsed to the required format by the API.

#### Template
The following example can be used to create a new printjob based on a pre-defined template:

```php
$instruction = new InsertTemplatePrintJobInstruction(
    'Printername', 
    'Templatename',
    [
        'variable_key'=>'variable_value'
    ]
);
$request = $instruction->buildRequest();

try {
    $client->send($request);
} catch (ServerException $e) {
    // In case of an error
    echo 'Error '.$e->getStatusCode().": ".$e->getMessage();
}
```

#### Document
If you do not want to use a template, you can upload a whole document. To do that, you can use the following code:

```php
$instruction = new InsertDocumentPrintJobInstruction(
    'Printername', 
    'This is the content of the document', 
    'nameOfTheFile.stm', 
    MediaTypes::TEXT_VND_STAR_MARKUP
);
$request = $instruction->buildRequest();

try {
    $client->send($request);
} catch (ServerException $e) {
    // In case of an error
    echo 'Error '.$e->getStatusCode().": ".$e->getMessage();
}
```