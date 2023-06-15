<?php

namespace gift\api\services\categories;

use Exception;
use gift\api\models\Categorie;
use gift\api\services\prestations\PrestationsServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategorieService
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
}