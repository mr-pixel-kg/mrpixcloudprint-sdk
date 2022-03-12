<?php

namespace Mrpix\CloudPrintSDK\Tests;

use DateTime;
use Mrpix\CloudPrintSDK\Components\MediaTypes;
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
            'Pixeldrucker',
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

    public function testInsertTemplatePrintJob()
    {
        $sdk = new CloudPrintClient();

        $instruction = new InsertTemplatePrintJobInstruction(
            'Pixeldrucker',
            'Standard',
            ['variable'=>'content']
        );
        $request = $instruction->buildRequest();

        /** @var PrintJobResponse $response */
        $response = $sdk->send($request);
        assertEquals(200, $response->getStatusCode());
    }
}
