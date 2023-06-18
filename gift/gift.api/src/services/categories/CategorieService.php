<?php

namespace gift\api\services\categories;

use Exception;
use gift\api\models\Categorie;
use gift\api\services\prestations\PrestationsServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategorieService
{
	/**
	 * Méthode pour récupérer toutes les catégories
	 * @throws Exception
	 */
    public function getCategories(): array {
        return Categorie::all()->toArray();
    }

	/**
	 * Méthode pour récupérer une catégorie par son id
	 * @param int $id
	 * @return array
	 * @throws PrestationsServiceException
	 */
    public function getCategorieById(int $id): array {
        try {
            return Categorie::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La catégorie $id n'existe pas", 404, $e);
        }
    }
}