<?php

namespace gift\app\services\authentification;

use gift\app\models\User;

class AuthentificationService
{
	public function getConnexion(string $email, string $password): bool
	{
        // Récupérer l'utilisateur par le nom d'utilisateur
        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            // Identifiant valide, connecte l'utilisateur (par exemple, en utilisant une session)
            $_SESSION['user_id'] = $user->id;
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

    //méthode pour savoir si un utilisateur est admin
    public function isAdmin(): bool
    {
        $user = $this->getCurrentUser();
        if ($user['role'] == 2) {
            return true;
        }
        return false;
    }
}
