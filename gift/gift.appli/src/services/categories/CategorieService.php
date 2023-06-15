<?php

namespace gift\app\services\categories;

use Exception;
use gift\api\models\Categorie;
use gift\app\models\Prestation;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
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
            throw new ServiceException("La catégorie $id n'existe pas", 404, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getCreateCategorie(array $categ_data) : void {
        if ($categ_data['libelle'] != filter_var($categ_data['libelle'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new ServiceException("Le libellé de la catégorie contient des caractères spéciaux");
        }
        if ($categ_data['description'] != filter_var($categ_data['description'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new ServiceException("La description de la catégorie contient des caractères spéciaux");
        }
        $categorie = new \gift\app\models\Categorie($categ_data);
        $categorie->save();
    }

    /**
     * @throws ServiceException
     */
    public function getDeleteCategorie(int $id) : void {
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->delete();
        } catch (ModelNotFoundException $e) {
            throw new ServiceException("La catégorie $id n'existe pas", 404, $e);
        }
    }

    /**
     * @throws Exception
     */
    public function addPrestationToCategorie(object|array|null $data): void {
        $prestation = new Prestation();
        $prestaService = new PrestationsService();
        $prestations = $prestaService->getPrestations();
        foreach ($prestations as $presta) {
            $prestation::where('id', $presta['id'])->where('cat_id', $data['idCateg'])->update(['cat_id' => 0]);
        }
        foreach ($data as $value) {
            $prestation::where('id', $value)->update(['cat_id' => $data['idCateg']]);
        }
    }
}