# Insert a new printjob
The following section explains how to create a new printjob. It is recommended to create a new instance of an instruction.
The request can be build by using the 'build' method of the instruction. By compiling the request, all given data will be 
automatically parsed to the required format by the API.

## Template
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

## Document
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