<?php

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\services\prestations\PrestationsServiceException;
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
		$box->kdo = $data['kdo'];
		$box->message_kdo = $data['message_kdo'];
		$box->url = $data['url'];
		$box->montant = 0;
		$box->token = $csrfService->generate();
		$box->status = Box::CREATED;
		$box->id = Uuid::uuid4()->toString();
		$box->save();

		return $box;
	}

	public function addPrestationToBox($idBox, $idPrestation): void {
		$box = Box::find($idBox);
		$box->prestations()->attach($idPrestation);
		$box->save();
	}

    public function getBox(): array {
        return Box::all()->toArray();
    }

    public function getBoxById(string $id): array {
        try {
            return Box::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La box $id n'existe pas", 404, $e);
        }
    }

    public function getPrestationByBoxId(string $id): array {
        try {
            return Box::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La box $id n'existe pas", 404, $e);
        }
    }

}