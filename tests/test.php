<?php

use Mrpix\CloudPrintSDK\Response\PrintJobResponse;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Mrpix\CloudPrintSDK\Components\MediaTypes;
use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Mrpix\CloudPrintSDK\Request\InsertInstruction\InsertDocumentPrintJobInstruction;
use Mrpix\CloudPrintSDK\Request\InsertInstruction\InsertTemplatePrintJobInstruction;

$sdk = new CloudPrintClient();
$sdk->login('manuel.kienlein@mr-pixel.de', 'password');

$instruction = new InsertTemplatePrintJobInstruction('Pixeldrucker', 'Standard', ['variable'=>'content']);
$request = $instruction->buildRequest();

//$instruction = new InsertDocumentPrintJobInstruction('Pixeldrucker', 'This is the content of the document', 'document.stm', MediaTypes::TEXT_VND_STAR_MARKUP, new DateTime('now'));
//$request = $instruction->buildRequest();
/** @var PrintJobResponse $response */
$response = $sdk->send($request);

//echo $response->getPrintJob()['id'];

/*if($sdk->checkLoginCredentials('manuel.kienlein@mr-pixel.de', 'password')){
    echo 'Login successful!';
}else{
    echo 'Login failed!';
}*/
