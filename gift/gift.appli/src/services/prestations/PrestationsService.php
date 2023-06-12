<?php

namespace gift\app\services\prestations;

use Exception;
use gift\app\models\Box;
use gift\app\models\Prestation;
use gift\app\models\Categorie;
use gift\app\services\box\BoxService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\UploadedFile;
use function MongoDB\BSON\toJSON;

class PrestationsService
{
    public function getCategories(): array {
        return Categorie::all()->toArray();
    }

	public function getPrestations(): array {
		return Prestation::all()->toArray();
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

	/**
	 * @throws PrestationsServiceException
	 */
	public function getCreatePrestation(object|array $presta_data): void {
		if ($presta_data['libelle'] != filter_var($presta_data['libelle'], FILTER_SANITIZE_SPECIAL_CHARS)) {
			throw new PrestationsServiceException("Le libellé de la prestation contient des caractères spéciaux");
		}
		if ($presta_data['tarif'] != filter_var($presta_data['tarif'], FILTER_SANITIZE_SPECIAL_CHARS)) {
			throw new PrestationsServiceException("Le prix de la prestation contient des caractères spéciaux");
		}
		if ($presta_data['description'] != filter_var($presta_data['description'], FILTER_SANITIZE_SPECIAL_CHARS)) {
			throw new PrestationsServiceException("La description de la prestation contient des caractères spéciaux");
		}

		$prestation = new Prestation($presta_data);
		$prestation->id = Uuid::uuid4()->toString();
		$image = $presta_data['img'];
		if ($image instanceof UploadedFile) {
			$prestation->image = $this->uploadImage($image);
		} else {
			throw new PrestationsServiceException("L'image n'est pas un fichier valide.");
		}
		$prestation->save();
	}


	/**
	 * @throws PrestationsServiceException
	 */
	public function uploadImage(UploadedFile $file): string {
		if($_FILES['img'] && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
			$valid_ext = array('jpg','jpeg','png');
			$check_ext = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
			if(in_array($check_ext, $valid_ext)) {
				$upload_dir = 'img/';
				$upload_file = $upload_dir . $_FILES['img']['name'];
				if(move_uploaded_file($_FILES['img']['tmp_name'], $upload_file)) {
					return $upload_file;
				} else {
					throw new PrestationsServiceException("Erreur lors de l'upload de l'image");
				}
			} else {
				throw new PrestationsServiceException("Le fichier n'est pas une image");
			}
		} else {
			throw new PrestationsServiceException("Erreur lors de l'upload de l'image");
		}
	}


}