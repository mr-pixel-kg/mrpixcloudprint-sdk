<?php

namespace Mrpix\CloudPrintSDK\Tests;

use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class LoginTest extends TestCase
{

    /**
     * @dataProvider loginCredentials
     */
    public function testLoginCredentials($username, $password, $assert){

        $sdk = new CloudPrintClient();
        assertEquals($assert, $sdk->checkLoginCredentials($username, $password));

    }

    public function loginCredentials() : array{
        return [
            ['test@example.com', 'thisIsAWrongPassword', false],
            [CloudPrintTest::USER_EMAIL, CloudPrintTest::USER_PASSWORD, true]
        ];
    }

}