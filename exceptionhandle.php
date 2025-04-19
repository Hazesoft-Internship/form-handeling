<?php
class Exceptionhandle extends Exception
{
    protected $httpCode;

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
        echo "Error:" . $code . " " . $message;
    }
}
