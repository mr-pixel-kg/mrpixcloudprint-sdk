<?php

namespace Mrpix\CloudPrintSDK\Exception;

use Throwable;

class ConstraintViolationException extends CloudPrintException
{
    private $data;

    public function __construct($message = "", $code = 0, ?Throwable $previous = null, $data = [])
    {
        parent::__construct($message.' '.json_encode($data, JSON_ERROR_NONE), $code, $previous);
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
