<?php

namespace gift\app\services;

use Exception;

class ServiceException extends Exception {

	/**
	 * Méthode permettant de construire l'exception ServiceException
	 * @param string $message
	 * @param int $code
	 * @param Exception|null $previous
	 */
	public function __construct(string $message = "", int $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}

}