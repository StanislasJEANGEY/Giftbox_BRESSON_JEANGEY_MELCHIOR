<?php

namespace gift\app\services\prestations;

use Exception;
use gift\app\models\Prestation;
use gift\app\models\Categorie;
use gift\app\services\ServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class PrestationsService
{

    public function getPrestations(): array
    {
        return Prestation::all()->toArray();
    }

	/**
	 * @throws Exception
	 */
	public function getPrestationById(string $id): array {
        try {
            return Prestation::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("Prestation $id n'existe pas", 404, $e);
        }
    }

	/**
	 * @throws Exception
	 */
	public function getPrestationByCategorieId(int $id): array {
        try {
            return Categorie::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("La catégorie $id n'existe pas", 404, $e);
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
			throw new ServiceException("Prestation $id n'existe pas", 404, $e);
		}
	}

	/**
	 * @throws ServiceException
	 */
	public function setPrestationCategorie(int $id, int $categorieId) : void {
		try {
			$prestation = Prestation::findOrFail($id);
			$categorie = Categorie::findOrFail($categorieId);
			$prestation->categorie()->associate($categorie);
			$prestation->save();
		} catch (ModelNotFoundException $e) {
			throw new ServiceException("Prestation $id ou catégorie $categorieId n'existe pas", 404, $e);
		}
	}



	/**
	 * @throws ServiceException
	 */
	public function getCreatePrestation(array $prestaData): void
	{
//		// Vérifier si l'image a été téléchargée sans erreur
//		if ($image->getError() !== UPLOAD_ERR_OK) {
//			throw new ServiceException("Erreur lors de l'upload de l'image.");
//		}

		// Récupérer les données de la prestation
		$libelle = filter_var($prestaData['libelle'], FILTER_SANITIZE_SPECIAL_CHARS);
		$tarif = filter_var($prestaData['tarif'], FILTER_SANITIZE_SPECIAL_CHARS);
		$description = filter_var($prestaData['description'], FILTER_SANITIZE_SPECIAL_CHARS);

		// Effectuer les validations nécessaires sur les données de la prestation

		// Vérifier si les champs requis sont présents
		if (empty($libelle) || empty($tarif) || empty($description)) {
			throw new ServiceException("Certains champs requis sont manquants dans les données de prestation.");
		}

		// Générer un identifiant unique pour la prestation
		$prestationId = Uuid::uuid4()->toString();

		// Définir le répertoire de destination pour les images
		$uploadDirectory = __DIR__ . '/../../../public/img';

//		// Récupérer le nom original et l'extension du fichier image
//		$uploadedFileName = $image->getClientFilename();
//		$extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
//
//		// Générer un nom de fichier unique
//		$newFileName = $prestationId . '.' . $extension;
//
//		// Déplacer le fichier téléchargé vers le répertoire de destination avec le nouveau nom de fichier
//		$image->moveTo($uploadDirectory . '/' . $newFileName);

		// Créer une instance de la prestation avec les données et le chemin de l'image
		$prestation = new Prestation([
			'id' => $prestationId,
			'libelle' => $libelle,
			'tarif' => $tarif,
			'description' => $description,
			//'image' => $uploadDirectory . '/' . $newFileName
			'image' => ''
		]);

		$prestation->save();
	}





}