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

	/**
	 * @throws PrestationsServiceException
	 */
	public function getCreateCategorie(array $categ_data) : void {
        if ($categ_data['libelle'] != filter_var($categ_data['libelle'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new PrestationsServiceException("Le libellé de la catégorie contient des caractères spéciaux");
        }
        if ($categ_data['description'] != filter_var($categ_data['description'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new PrestationsServiceException("La description de la catégorie contient des caractères spéciaux");
        }
        $categorie = new Categorie($categ_data);
        $categorie->save();
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