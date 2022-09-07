<?php

namespace Mrpix\CloudPrintSDK\Exception;

class JsonException extends \Exception
{
    protected $name;

    public function __construct(array $data)
    {
        parent::__construct($data['message'], $data['code']);
        $this->name = $data['name'];
    }

    public function getName()
    {
        return $this->name;
    }
}
