<?php

namespace gift\app\services\utils;

use Exception;

class CsrfException extends Exception
{

    /**
     * @param string $string
     */
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}