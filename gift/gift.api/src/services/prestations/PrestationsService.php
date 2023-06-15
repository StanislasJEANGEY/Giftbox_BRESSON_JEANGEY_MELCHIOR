<?php

namespace gift\api\services\prestations;

use Exception;
use gift\api\models\Prestation;
use gift\api\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationsService
{
	public function getPrestations(): array {
		return Prestation::all()->toArray();
	}


	/**
	 * @throws Exception
	 */
	public function getPrestationById(string $id): array {
        try {
            return Prestation::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("Prestation $id n'existe pas", 404, $e);
        }
    }

	/**
	 * @throws Exception
	 */
	public function getPrestationByCategorieId(int $id): array {
        try {
            return Categorie::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La catégorie $id n'existe pas", 404, $e);
        }
    }





}