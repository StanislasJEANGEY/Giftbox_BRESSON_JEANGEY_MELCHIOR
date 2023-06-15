<?php

namespace gift\api\services\box;

use Exception;
use gift\api\models\Box;
use gift\api\services\prestations\PrestationsService;
use gift\api\services\prestations\PrestationsServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BoxService {



    public function getBox(): array {
        return Box::all()->toArray();
    }

	/**
	 * @throws PrestationsServiceException
	 */
	public function getBoxById(string $id): array {
        try {
            return Box::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationsServiceException("La box $id n'existe pas", 404, $e);
        }
    }

	/**
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