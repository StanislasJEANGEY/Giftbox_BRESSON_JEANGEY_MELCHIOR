<?php

namespace gift\app\services\prestations;

use gift\app\models\Prestation;
use gift\app\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationsService
{
    public function getCategories(): array {
        return Categorie::all()->toArray();
    }

    public function getPrestationsByCategorieId(string $id): array {
        try {
            $categorie = Categorie::findOrFail($id);
            return $categorie->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            return [];
        }
    }
}