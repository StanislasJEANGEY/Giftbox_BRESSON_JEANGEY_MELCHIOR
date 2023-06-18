<?php

namespace gift\api\services\prestations;

use Exception;
use gift\api\models\Prestation;
use gift\api\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationsService
{
	/**
	 * Méthode pour récupérer toutes les prestations
	 * @throws Exception
	 */
	public function getPrestations(): array {
		return Prestation::all()->toArray();
	}

	/**
	 * Méthode pour récupérer une prestation par son id
	 * @param string $id
	 * @return array
	 * @throws PrestationsServiceException
	 */
	public function getPrestationById(string $id): array {
        try {
            return Prestation::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("Prestation $id n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode pour récupérer la prestation d'une catégorie en particulier
	 * @param int $id
	 * @return array
	 * @throws PrestationsServiceException
	 */
	public function getPrestationByCategorieId(int $id): array {
        try {
            return Categorie::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La catégorie $id n'existe pas", 404, $e);
        }
    }





}