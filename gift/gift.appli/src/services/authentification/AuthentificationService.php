<?php

namespace gift\app\services\authentification;

use gift\app\models\User;

class AuthentificationService
{
	public function getConnexion(string $email, string $password): bool
	{
		$user = User::where('email', $email)->first();

		if ($user && password_verify($password, $user->password)) {
			$_SESSION['id'] = $user->id;
			$_SESSION['nom'] = $user->nom;
			$_SESSION['prenom'] = $user->prenom;
			$_SESSION['email'] = $user->email;
			$_SESSION['role'] = $user->role;
			$_SESSION['logged_in'] = true;
			return true;
		}

		return false;
	}

	public function getInscription(string $nom, string $prenom, string $email, string $password): void
	{
		$user = new User();
		$user->nom = $nom;
		$user->prenom = $prenom;
		$user->email = $email;
		$user->password = password_hash($password, PASSWORD_DEFAULT);
		$user->role = 1;
		$user->save();
	}

	public function getDeconnexion(): void
	{
		session_unset();
		session_destroy();
		session_regenerate_id(true);
	}

    public function getCurrentUser(): ?User
    {
        // Récupérer l'utilisateur actuellement connecté
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            return User::find($userId);
        }

        return null;
    }
}
