<?php

namespace gift\app\services\prestations;

use Exception;
use gift\app\models\Prestation;
use gift\app\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

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

//	/**
//	 * @throws PrestationsServiceException
//	 */
//	public function getUpdatePrestation(string $id, array $attributs): void {
//		try {
//			$prestation = Prestation::findOrFail($id);
//		} catch (ModelNotFoundException $e) {
//			throw new PrestationsServiceException("Prestation $id n'existe pas", 404, $e);
//		}
//		foreach ($attributs as $key => $value) {
//			$prestation->$key = $value;
//		}
//		try {
//			$prestation->save();
//		} catch (QueryException $e) {
//			throw new PrestationsServiceException("Erreur lors de la mise à jour de la prestation $id", 500, $e);
//		}
//	}

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

	/**
	 * @throws PrestationsServiceException
	 */
	public function setPrestationCategorie(int $id, int $categorieId) : void {
		try {
			$prestation = Prestation::findOrFail($id);
			$categorie = Categorie::findOrFail($categorieId);
			$prestation->categorie()->associate($categorie);
			$prestation->save();
		} catch (ModelNotFoundException $e) {
			throw new PrestationsServiceException("Prestation $id ou catégorie $categorieId n'existe pas", 404, $e);
		}
	}

    public function getCreateCategorie(String $name, String $description) : int {
        $categorie = new Categorie();
        $categorie->libelle = $name;
        $categorie->description = $description;
        $categorie->save();
        return $categorie->id;
    }

	/**
	 * @throws PrestationsServiceException
	 */
	public function getDeleteCategorie(int $id) : void {
		try {
			$categorie = Categorie::findOrFail($id);
			$categorie->delete();
		} catch (ModelNotFoundException $e) {
			throw new PrestationsServiceException("La catégorie $id n'existe pas", 404, $e);
		}
	}



}