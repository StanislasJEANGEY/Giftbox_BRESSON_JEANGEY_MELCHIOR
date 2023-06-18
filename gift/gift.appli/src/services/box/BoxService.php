<?php

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\services\authentification\AuthentificationService;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use gift\app\services\utils\CsrfService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class BoxService {

	/**
	 * @throws Exception
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
        if (isset($data['box'])) {
            $presta = $this->getPrestationByBoxId($data['box']);
            foreach ($presta as $p) {
                $box->prestations()->attach($p['id'], ['quantite' => $p['contenu']['quantite']]);
                $box->montant += $p['tarif'] * $p['contenu']['quantite'];
                $box->save();
            }
        }

		return $box;
	}

    public function getBox(): array {
        return Box::where('user_id',0)->get()->toArray();
    }

	/**
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
     * @throws ServiceException
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

    public function getBoxPerso($idUser)
    {
        return Box::where('user_id', $idUser)->get()->toArray();
    }

    //Verfifie le nombre de presatation et de categorie dans la box
    public function checkBox($idBox): bool
    {
        $box = Box::findOrFail($idBox);
        $nbPresta = $box->prestations()->count();
        if($nbPresta < 2){
            return false;
        }
        return true;
    }

}