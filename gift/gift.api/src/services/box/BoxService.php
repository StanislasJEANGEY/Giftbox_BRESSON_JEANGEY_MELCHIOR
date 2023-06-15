<?php

namespace gift\api\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use gift\app\services\utils\CsrfService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

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