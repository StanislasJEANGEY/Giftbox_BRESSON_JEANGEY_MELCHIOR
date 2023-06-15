<?php

namespace gift\app\services\authentification;

use Exception;
use gift\app\models\User;

class AuthentificationService {

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

	public function getInscription($nom, $prenom, $email, $password): void {
		$u = new User();
		$u->nom = $nom;
		$u->prenom = $prenom;
		$u->email = $email;
		$u->password = password_hash($password, PASSWORD_DEFAULT);
		$u->role = 1;
		$u->save();
	}

}