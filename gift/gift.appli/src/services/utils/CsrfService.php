<?php

namespace gift\app\services\utils;

use Exception;

class CsrfService
{
	/**
	 * @throws Exception
	 */
	public static function generate():string{
        $token = base64_encode(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

	/**
	 * @throws CsrfException
	 */
	public static function check(?string $token): void {
		$session_token = $_SESSION['csrf_token'] ?? null;
		if (is_null($token) || ($session_token !== $token)) {
			throw new CsrfException("Le token n'est pas valide");
		}
	}
}