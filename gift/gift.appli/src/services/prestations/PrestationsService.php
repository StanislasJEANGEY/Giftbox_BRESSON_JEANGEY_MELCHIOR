<?php

namespace gift\app\services\prestations;

use gift\app\models\Prestation;
use gift\app\models\Categorie;
use gift\app\services\ServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class PrestationsService
{

	/**
	 * Méthode permettant de récupérer toutes les prestations
	 * @return array
	 */
    public function getPrestations(): array {
        return Prestation::all()->toArray();
    }

	/**
	 * Méthode permettant de récupérer une prestation en particulier
	 * @param string $id
	 * @return array
	 * @throws ServiceException
	 */
	public function getPrestationById(string $id): array {
        try {
            return Prestation::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("Prestation $id n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode permettant de récupérer toutes les prestations d'une catégorie en particulier
	 * @param int $id
	 * @return array
	 * @throws ServiceException
	 */
	public function getPrestationByCategorieId(int $id): array {
        try {
            return Categorie::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("La catégorie $id n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode permettant de mettre à jour une prestation
	 * @param string $id
	 * @param array $attributs
	 * @return array
	 * @throws ServiceException
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
	 * Méthode permettant de créer une prestation
	 * @param array $prestaData
	 * @return void
	 * @throws ServiceException
	 */
	public function getCreatePrestation(array $prestaData): void
	{
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

		// Créer une instance de la prestation avec les données et le chemin de l'image
		$prestation = new Prestation([
			'id' => $prestationId,
			'libelle' => $libelle,
			'tarif' => $tarif,
			'description' => $description,
			'image' => ''
		]);

		$prestation->save();
	}

	/**
	 * Méthode permettant de trier les prestations par prix croissant
	 * @return array
	 */
    public function getPrestationsByPrixCroissant(): array
    {
        return Prestation::orderBy('tarif', 'asc')->get()->toArray();
    }

	/**
	 * Méthode permettant de trier les prestations par prix décroissant
	 * @return array
	 */
    public function getPrestationsByPrixDecroissant(): array
    {
        return Prestation::orderBy('tarif', 'desc')->get()->toArray();
    }





}