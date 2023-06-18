<?php

namespace gift\app\services\box;

use gift\app\models\Box;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use gift\app\services\utils\CsrfService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class BoxService {

	/**
	 * Méthode permettant de créer un coffret
	 * @param $data
	 * @return bool|Box
	 * @throws ServiceException
	 */
	public function createBox($data): bool|Box {
		// On vérifie que les données obligatoires sont présentes.
		if (!isset($data['libelle']) || !isset($data['description'])) {
			return false;
		}

		$csrfService = new CsrfService();

		// On crée le coffret.
		$box = new Box();
		$box->libelle = $data['libelle'];
		$box->description = $data['description'];
        $box->kdo = $data['kdo'] ?? 0;
		$box->message_kdo = $data['message_kdo'];
		//$box->url = $data['url'];
        $box->montant = 0;
        $box->token = $csrfService->generate();
		$box->statut = Box::CREATED;
		$box->id = Uuid::uuid4()->toString();
        if(isset($_SESSION['user_id'])){
            $authService = new AuthentificationService();
            $user = $authService->getCurrentUser();
            if ($user['role'] == 2) {
                $box->user_id = 0;
            } else {
                $box->user_id = $user['id'];
            }
        } else {
            $box->user_id = -1;
        }
		$box->save();
        if ($data['box'] != 'null') {
            if (isset($data['box'])) {
                $presta = $this->getPrestationByBoxId($data['box']);
                foreach ($presta as $p) {
                    $box->prestations()->attach($p['id'], ['quantite' => $p['contenu']['quantite']]);
                    $box->montant += $p['tarif'] * $p['contenu']['quantite'];
                    $box->save();
                }
            }
        }

		return $box;
	}

	/**
	 * Méthode permettant de récupérer tous les coffrets
	 * @return array
	 */
    public function getBox(): array {
        return Box::where('user_id',0)->get()->toArray();
    }

	/**
	 * Méthode permettant de récupérer un coffret en particulier
	 * @param string $id
	 * @return array
	 * @throws ServiceException
	 */
	public function getBoxById(string $id): array {
        try {
            return Box::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("La box $id n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode permettant de récupérer les prestations d'un coffret en particulier
	 * @param string $id
	 * @return array
	 * @throws ServiceException
	 */
	public function getPrestationByBoxId(string $id): array {
        try {
            return Box::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("La box $id n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode permettant de récupérer les prestations d'un coffret en particulier avec la quantité
	 * @param string $idBox
	 * @return array
	 * @throws ServiceException
	 */
	public function getPrestationByBoxIdWithQuantite(string $idBox): array {
        try {
            return Box::findOrFail($idBox)->prestations()->withPivot('quantite')->get()->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("La box $idBox n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode permettant d'ajouter une prestation à un coffret
	 * @param object|array $data
	 * @return void
	 */
    public function addPrestationToBox(object|array $data): void
    {
        $prestationService = new PrestationsService();
        $prestations = $prestationService->getPrestations();
        $idBox = $data['idBox'];
        $box = Box::findOrFail($idBox);
        foreach ($prestations as $presta){
            // Vérifier si une entrée existe déjà
            $existingEntry = $box::where('id', $idBox)
                ->whereHas('prestations', function($query) use ($presta) {
                    $query->where('presta_id', $presta['id']);
                })->with(['prestations' => function($query) use ($presta) {
                    $query->where('presta_id', $presta['id']);
                }])->first();

            if ($data[$presta['id']] > 0) {
                //update
                if ($existingEntry) {
                    $box->prestations()->updateExistingPivot($presta['id'], ['quantite' => $data[$presta['id']]]);
                } else {
                    //insert
                    $box->prestations()->attach($presta['id'], ['quantite' => $data[$presta['id']]]);
                }
            } else {
                //delete
                if ($existingEntry) {
                    $existingEntry->prestations()->detach($presta['id']);
                }
            }
        }
    }

	/**
	 * Méthode permettant de mettre à jour un coffret
	 * @param mixed $id
	 * @param array $attributs
	 * @return void
	 * @throws ServiceException
	 */
	public function getUpdateBox(mixed $id, array $attributs): void {
		try {
			$box = Box::findOrFail($id);
			$box->update($attributs);
		} catch (ModelNotFoundException $e) {
			throw new ServiceException("La box $id n'existe pas", 404, $e);
		}
	}

	/**
	 * Méthode permettant d'afficher les coffrets créés par un utilisateur
	 * @param $idUser
	 * @return mixed
	 */
    public function getBoxPerso($idUser): mixed {
        return Box::where('user_id', $idUser)->get()->toArray();
    }

	/**
	 * Méthode permettant de vérifier les conditions de validation d'un coffret
	 * @param $idBox
	 * @return bool
	 */
    public function checkBox($idBox): bool
    {
        $box = Box::findOrFail($idBox);
	    $nbCategorie = $box->prestations()->distinct()->count('cat_id');
        $nbPresta = $box->prestations()->count();
        if($nbPresta < 2 || $nbCategorie < 2){
            return false;
        }
        return true;
    }

	/**
	 * Méthode permettant de mettre à jour le statut d'un coffret
	 * @param $idBox
	 * @param $statut
	 * @return void
	 */
    public function updateStatut($idBox, $statut): void
    {
        $box = Box::findOrFail($idBox);
        $box->statut = $statut;
        $box->save();
    }

}