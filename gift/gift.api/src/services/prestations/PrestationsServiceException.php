<?php

namespace gift\api\services\prestations;

use Exception;

class PrestationsServiceException extends Exception {

	/**
	 * Méthode pour construire l'exception PrestationsServiceException
	 * @param $message
	 * @param $code
	 * @param Exception|null $previous
	 */
	public function __construct($message = "", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}

}