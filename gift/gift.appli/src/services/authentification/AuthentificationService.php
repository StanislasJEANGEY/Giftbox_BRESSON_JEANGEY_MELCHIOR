<?php

namespace gift\app\services\authentification;

use Exception;
use gift\app\models\User;

class AuthentificationService {

	// Fonction pour se connecter
	/**
	 * @throws Exception
	 */
	public function getConnexion($email, $password): bool {
		$u = User::select('*')
			->where('email', '=', $email)
			->first();
		if ($u != null) {
			if (password_verify($password, $u->password)) {
				$_SESSION['id'] = $u->id;
				$_SESSION['nom'] = $u->nom;
				$_SESSION['prenom'] = $u->prenom;
				$_SESSION['email'] = $u->email;
				$_SESSION['role'] = $u->role;
				return true;
			}
		}
		return false;
	}

}