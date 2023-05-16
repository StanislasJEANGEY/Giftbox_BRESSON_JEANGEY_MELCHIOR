<?php

namespace gift\app\services\prestations;

use Exception;

class PrestationsServiceException extends Exception {

	public function __construct($message = "", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}

}