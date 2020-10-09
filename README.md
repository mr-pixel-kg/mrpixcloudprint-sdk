# MrpixCloudPrint SDK
This is the official PHP SDK of mr.pixel's CloudPrint service. This library contains methods to easily interact with the
mpXcloudprint API. Below is a short instruction with some examples to get startet with this SDK. For additional 
information, please visit our official documentation.

## Benötigte Pakete der Anwendung, bevor HTTPlug Pakete
composer require php-http/curl-client guzzlehttp/psr7 php-http/message

http://docs.php-http.org/en/latest/httplug/library-developers.html
https://www.sitepoint.com/breaking-free-from-guzzle5-with-php-http-and-httplug/

## Installation

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