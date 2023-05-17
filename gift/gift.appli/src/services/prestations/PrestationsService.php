<?php

namespace gift\app\services\prestations;

use Exception;
use gift\app\models\Prestation;
use gift\app\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationsService
{
    public function getCategories(): array {
        return Categorie::all()->toArray();
    }

	/**
	 * @throws Exception
	 */
	public function getCategorieById(int $id): array {
        try {
            return Categorie::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La catégorie $id n'existe pas", 404, $e);
        }
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

	/**
	 * @throws Exception
	 */
	public function getUpdatePrestation(string $id, array $attributs): array {
		try {
			$prestation = Prestation::findOrFail($id);
			$prestation->update($attributs);
			return $prestation->toArray();
		} catch (ModelNotFoundException $e) {
			throw new PrestationsServiceException("Prestation $id n'existe pas", 404, $e);
		}
	}

    public function getCreateCategorie(String $name, String $description) : int {
        $categorie = new Categorie();
        $categorie->libelle = $name;
        $categorie->description = $description;
        $categorie->save();
        return $categorie->id;
    }
}