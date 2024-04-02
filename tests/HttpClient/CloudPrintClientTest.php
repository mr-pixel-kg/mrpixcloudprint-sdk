<?php

namespace Mrpix\CloudPrintSDK\Tests\HttpClient;

use DateTime;
use Mrpix\CloudPrintSDK\CloudPrintSDK;
use Mrpix\CloudPrintSDK\Components\MediaTypes;
use Mrpix\CloudPrintSDK\Exception\ConstraintViolationException;
use Mrpix\CloudPrintSDK\Exception\NetworkException;
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Mrpix\CloudPrintSDK\Request\CheckLoginRequest;
use Mrpix\CloudPrintSDK\Request\InsertDocumentPrintJobRequest;
use Mrpix\CloudPrintSDK\Request\InsertInstruction\InsertDocumentPrintJobInstruction;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertStringStartsWith;

class CloudPrintClientTest extends TestCase
{
    public function testOfflineCloudServer()
    {
        $sdk = new CloudPrintClient(getenv('MRPIX_CLOUDPRINT_USERNAME'), getenv('MRPIX_CLOUDPRINT_PASSWORD'));

        // Test with working server url
        $success = false;

        $request = new CheckLoginRequest();
        $response = $sdk->send($request);
        if ($response->getStatusCode() === 200) {
            $success = true;
        }

        assertEquals(true, $success);

        // Change url to not existing cloudprint server
        putenv(CloudPrintSDK::ENV_SERVER.'=https://offline-cloudprint-server-123.com');
        assertEquals(CloudPrintClient::getServerUrl(), 'https://offline-cloudprint-server-123.com');

        // Test if NetworkException will be thrown
        $this->expectException(NetworkException::class);
        $success = false;

        $request = new CheckLoginRequest();
        $response = $sdk->send($request);
        if ($response->getStatusCode() === 200) {
            $success = true;
        }

        assertEquals(true, $success);
    }

    public function testValidateRequest()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertDocumentPrintJobInstruction(
            'Printername',
            'This is the content of the document',
            'document.stm',
            MediaTypes::TEXT_VND_STAR_MARKUP,
            new DateTime('2022-03-12 09:30:00')
        );
        $request = $instruction->buildRequest();

        $sdk->validateRequest($request);
        assertEquals('Printername', $request->getPrinterName());
        assertEquals('This is the content of the document', $request->getDocumentContent());
        assertEquals('document.stm', $request->getDocumentName());
        assertEquals(MediaTypes::TEXT_VND_STAR_MARKUP, $request->getDocumentMediaType());
        assertEquals('20220312093000', $request->getStartTime());
    }

    public function testValidateRequestNoStartTime()
    {
        $sdk = new CloudPrintClient();

        $request = new InsertDocumentPrintJobRequest(
            'Printername',
            'This is the content of the document',
            'document.stm',
            MediaTypes::TEXT_VND_STAR_MARKUP
        );

        $sdk->validateRequest($request);
        assertEquals('Printername', $request->getPrinterName());
        assertEquals('This is the content of the document', $request->getDocumentContent());
        assertEquals('document.stm', $request->getDocumentName());
        assertEquals(MediaTypes::TEXT_VND_STAR_MARKUP, $request->getDocumentMediaType());
        assertNull($request->getStartTime());
    }

    public function testValidateRequestWrongPrinterName()
    {
        $sdk = new CloudPrintClient();

        $request = new InsertDocumentPrintJobRequest(
            'ThisIsAToLongPrinterName',
            'This is the content of the document',
            'document.stm',
            MediaTypes::TEXT_VND_STAR_MARKUP
        );

        try {
            $sdk->validateRequest($request);
            $this->fail('Expected that ConstraintViolationException is thrown!');
        } catch (ConstraintViolationException $e) {
            assertEquals(ConstraintViolationException::class, $e::class);
            assertStringStartsWith('Request is not valid!', $e->getMessage());

            $data = $e->getData()[0];
            assertEquals('printerName', $data['field']);
            assertEquals('ThisIsAToLongPrinterName', $data['value']);
        }
    }

    public function testValidateRequestWrongPrinterNameWrongMediaType()
    {
        $sdk = new CloudPrintClient();

        $request = new InsertDocumentPrintJobRequest(
            'ThisIsAToLongPrinterName',
            'This is the content of the document',
            'document.stm',
            'image/jpeg'
        );

        try {
            $sdk->validateRequest($request);
            $this->fail('Expected that ConstraintViolationException is thrown!');
        } catch (ConstraintViolationException $e) {
            assertEquals(ConstraintViolationException::class, $e::class);
            assertStringStartsWith('Request is not valid!', $e->getMessage());

            $data = $e->getData();
            assertEquals('documentMediaType', $data[0]['field']);
            assertEquals('image/jpeg', $data[0]['value']);
            assertEquals('printerName', $data[1]['field']);
            assertEquals('ThisIsAToLongPrinterName', $data[1]['value']);
        }
    }

    private static ?string $envServerUrl = null;

    #[BeforeClass]
    public static function backupServerEnvironmentVariable(): void
    {
        self::$envServerUrl = getenv(CloudPrintSDK::ENV_SERVER);
    }

    #[AfterClass]
    public static function tearDownChangedServerEnvironmentVariable(): void
    {
        putenv(CloudPrintSDK::ENV_SERVER.'='.self::$envServerUrl);
    }
}
