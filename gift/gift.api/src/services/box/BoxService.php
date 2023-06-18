<?php

namespace gift\api\services\box;

use gift\api\models\Box;
use gift\api\services\prestations\PrestationsServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BoxService {

	/**
	 * Méthode pour récupérer toutes les box
	 * @return array
	 */
    public function getBox(): array {
        return Box::all()->toArray();
    }

	/**
	 * Méthode pour récupérer une box par son id
	 * @param string $id
	 * @return array
	 * @throws PrestationsServiceException
	 */
	public function getBoxById(string $id): array {
        try {
            return Box::where('id',$id)->with('prestations')->get()->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La box $id n'existe pas", 404, $e);
        }
    }

	/**
	 * Méthode pour récupérer les prestations d'une box par son id
	 * @param string $id
	 * @return array
	 * @throws PrestationsServiceException
	 */
	public function getPrestationByBoxId(string $id): array {
        try {
            return Box::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La box $id n'existe pas", 404, $e);
        }
    }



}