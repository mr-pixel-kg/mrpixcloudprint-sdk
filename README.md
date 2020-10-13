# MrpixCloudPrint SDK
This is the official PHP SDK of mr.pixel's CloudPrint service. This library contains methods to easily interact with the
mpXcloudprint API. Below is a short instruction with some examples to get startet with this SDK. For additional 
information, please visit our official documentation.

## Installation
This library is not dependent to any http client like Guzzle. You can use any http client hat supposrts the 
[php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation).

To get started quickly:
```
composer require php-http/guzzle6-adapter nyholm/psr7 symfony/http-client
```

## Usage
This project depends on Composer. It is recomended to let the Composer autoloader automatically load all your 
dependencies. The example below will show you how to include the client for the mpXcloudprint API.
```
require 'vendor/autoload.php';
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;

$client = new CloudPrintClient();
```
### Authentification
Some actions require you to be authenticated. To do this, you have to call the login method before sending requests.
Here is a example on how to do that:
```
$client->login('your-username@example.com', 'yourSecretPassword');
```

Note: If the login credentials are not correct, the server will return a 401 or 403 response.
#### Test login credentials
To test if login credentials are correct, you can use the following example:
```
if($client->checkLoginCredentials('your-username@example.com', 'yourSecretPassword'))
{
    echo 'Login successful!';
}else{
    echo 'Login failed!';
}
```

### Insert a new printjob
The following section explaines how to create a new printjob. It is recommended to create a new instance of an instruction.
The request can be build by using the 'build' method of the instruction. By compiling the request, all given data will be 
automatically parsed to the required format by the API.

#### Template
The following example can be used to create a new printjob based on a pre defined template:
```
$instruction = new InsertTemplatePrintJobInstruction('Printername', 'Templatename', ['variable_key'=>'variable_value']);
$request = $instruction->buildRequest();

$client->send($request);
```

#### Document
If you do not want to use a template, you can upload a whole document. To do that, you can use the following code:
```
$instruction = new InsertDocumentPrintJobInstruction('Printername', 'This is the content of the document', 'nameOfTheFile.stm', MediaTypes::TEXT_VND_STAR_MARKUP);
$request = $instruction->buildRequest();

$client->send($request);
```