<?php

namespace Mrpix\CloudPrintSDK\Tests;

use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class LoginTest extends TestCase
{
    #[DataProvider('loginCredentials')]
    public function testLoginCredentials($username, $password, $assert)
    {
        $sdk = new CloudPrintClient();
        assertEquals($assert, $sdk->checkLoginCredentials($username, $password));
    }

    public static function loginCredentials(): array
    {
        return [
            ['test@example.com', 'thisIsAWrongPassword', false],
            [getenv('MRPIX_CLOUDPRINT_USERNAME'), getenv('MRPIX_CLOUDPRINT_PASSWORD'), true],
            [getenv('MRPIX_CLOUDPRINT_USERNAME'), getenv('MRPIX_CLOUDPRINT_PASSWORD').'_wrong!', false]
        ];
    }
}
