<?php

namespace gift\app\services\utils;

use Exception;

class CsrfException extends Exception
{

	/**
	 * Méthode permettant de construire l'excpetion CSRFException
	 * @param string $message
	 * @param int $code
	 * @param Exception|null $previous
	 */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}