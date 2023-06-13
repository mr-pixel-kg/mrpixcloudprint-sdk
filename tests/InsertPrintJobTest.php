<?php

namespace Mrpix\CloudPrintSDK\Tests;

use DateTime;
use Mrpix\CloudPrintSDK\Components\MediaTypes;
use Mrpix\CloudPrintSDK\Exception\ServerException;
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Mrpix\CloudPrintSDK\Request\InsertInstruction\InsertDocumentPrintJobInstruction;
use Mrpix\CloudPrintSDK\Request\InsertInstruction\InsertTemplatePrintJobInstruction;
use Mrpix\CloudPrintSDK\Response\PrintJobResponse;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class InsertPrintJobTest extends TestCase
{
    public function testInsertDocumentPrintJob()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertDocumentPrintJobInstruction(
            CloudPrintTestConstants::PRINTER_NAME,
            'This is the content of the document',
            'document.stm',
            MediaTypes::TEXT_VND_STAR_MARKUP,
            new DateTime('now')
        );
        $request = $instruction->buildRequest();

        /** @var PrintJobResponse $response */
        $response = $sdk->send($request);
        assertEquals(200, $response->getStatusCode());
    }

    public function testInsertDocumentPrintJobNoStartTime()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertDocumentPrintJobInstruction(
            CloudPrintTestConstants::PRINTER_NAME,
            'This is the content of the document',
            'document.stm',
            MediaTypes::TEXT_VND_STAR_MARKUP
        );
        $request = $instruction->buildRequest();

        /** @var PrintJobResponse $response */
        $response = $sdk->send($request);
        assertEquals(200, $response->getStatusCode());
    }

    public function testInsertDocumentPrintJobPrinterNotExistent()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertDocumentPrintJobInstruction(
            'NoPrinter',
            'This is the content of the document',
            'document.stm',
            MediaTypes::TEXT_VND_STAR_MARKUP,
            new DateTime('now')
        );
        $request = $instruction->buildRequest();

        try {
            $sdk->send($request);
            self::fail('No exception thrown! Expected ServerException to be thrown.');
        } catch (ServerException $e) {
            $response = $e->getResponse();
            assertEquals(404, $response->getStatusCode());
            assertEquals('Printer NoPrinter not found!', $response->getMessage());
        }
    }

    public function testInsertTemplatePrintJob()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertTemplatePrintJobInstruction(
            CloudPrintTestConstants::PRINTER_NAME,
            CloudPrintTestConstants::TEMPLATE_NAME,
            ['variable'=>'content'],
            new DateTime('now')
        );
        $request = $instruction->buildRequest();

        /** @var PrintJobResponse $response */
        $response = $sdk->send($request);
        assertEquals(200, $response->getStatusCode());
    }

    public function testInsertTemplatePrintJobNoStartTime()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertTemplatePrintJobInstruction(
            CloudPrintTestConstants::PRINTER_NAME,
            CloudPrintTestConstants::TEMPLATE_NAME,
            ['variable'=>'content']
        );
        $request = $instruction->buildRequest();

        /** @var PrintJobResponse $response */
        $response = $sdk->send($request);
        assertEquals(200, $response->getStatusCode());
    }

    public function testInsertTemplatePrintJobPrinterNotExistent()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertTemplatePrintJobInstruction(
            'NoPrinter',
            CloudPrintTestConstants::TEMPLATE_NAME,
            ['variable'=>'content']
        );
        $request = $instruction->buildRequest();

        try {
            $sdk->send($request);
            self::fail('No exception thrown! Expected ServerException to be thrown.');
        } catch (ServerException $e) {
            $response = $e->getResponse();
            assertEquals(404, $response->getStatusCode());
            assertEquals('Printer NoPrinter not found!', $response->getMessage());
        }
    }

    public function testInsertTemplatePrintJobTemplateNotExistent()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertTemplatePrintJobInstruction(
            CloudPrintTestConstants::PRINTER_NAME,
            'NoTemplate',
            ['variable'=>'content']
        );
        $request = $instruction->buildRequest();

        try {
            $sdk->send($request);
            self::fail('No exception thrown! Expected ServerException to be thrown.');
        } catch (ServerException $e) {
            $response = $e->getResponse();
            assertEquals(404, $response->getStatusCode());
            assertEquals('Template NoTemplate not found!', $response->getMessage());
        }
    }
}
