<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Mrpix\CloudPrintSDK\HttpClient\CloudPrintClient;
use Mrpix\CloudPrintSDK\Request\InsertInstruction\InsertTemplatePrintJobInstruction;


$sdk = new CloudPrintClient();
$sdk->login('manuel.kienlein@mr-pixel.de', 'MrpixCloudPrint_admin');

$instruction = new InsertTemplatePrintJobInstruction('Pixeldrucker', 'Standard', ['variable'=>'content']);
$request = $instruction->buildRequest();

$sdk->send($request);