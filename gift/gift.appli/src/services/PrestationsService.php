<?php

namespace gift\app\services;

use gift\app\models\Prestation;
use gift\app\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationsService
{
    public function getCategories(): array {
        return Categorie::all()->toArray();
    }

    public function getCategorieById(int $id): array {
        try {
            return Categorie::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new \Exception("La catégorie $id n'existe pas");
        }
    }

    public function getPrestationById(string $id): array {
        try {
            return Prestation::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new \Exception("Prestation $id n'existe pas");
        }
    }

    public function getPrestationByCategorieId(int $id): array {
        try {
            return Categorie::findOrFail($id)->prestations->toArray();
        } catch (ModelNotFoundException $e) {
            throw new \Exception("La catégorie $id n'existe pas");
        }
    }
}