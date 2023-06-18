<?php

namespace gift\app\services\utils;

use Exception;

class CsrfService
{
	/**
	 * Méthode permettant de générer un token CSRF
	 * @return string
	 * @throws Exception
	 */
	public static function generate():string{
        $token = base64_encode(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

	/**
	 * Méthode permettant de vérifier si le token CSRF est valide
	 * @param string|null $token
	 * @return void
	 * @throws CsrfException
	 */
	public static function check(?string $token): void {
		$session_token = $_SESSION['csrf_token'] ?? null;
		if ($session_token) unset($_SESSION['csrf_token']);
		if (is_null($token) || ($session_token !== $token)) {
			throw new CsrfException("Le token n'est pas valide");
		}
	}
}