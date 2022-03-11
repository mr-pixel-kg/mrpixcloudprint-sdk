<?php

namespace Mrpix\CloudPrintSDK\Exception;

use Throwable;

class ConstraintViolationException extends \RuntimeException implements CloudPrintException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null, $data = [])
    {
        parent::__construct($message.' '.json_encode($data), $code, $previous);
    }
}
