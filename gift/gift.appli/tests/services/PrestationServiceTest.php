<?php

namespace Tests\Unit\Services\Prestations;

use Exception;
use gift\app\models\Categorie;
use gift\app\models\Prestation;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\ServiceException;
use gift\app\services\utils\Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PrestationServiceTest extends TestCase
{
    protected PrestationsService $prestationsService;

    protected function setUp(): void
    {
        parent::setUp();
        Eloquent::init(__DIR__ . '/../../src/conf/gift.db.test.ini');
        $this->prestationsService = new PrestationsService();
    }

    /**
     * @throws Exception
     */
    public function testGetPrestationByCategorieId()
    {
        $categorie = new Categorie();
        $categorie->save();

        $prestation1 = new Prestation([
            'id' => Uuid::uuid4()->toString(),
            'libelle' => 'Prestation 1',
            'tarif' => 10.0,
            'description' => 'Description 1',
            'categorie_id' => $categorie->id
        ]);
        $prestation1->save();

        $prestation2 = new Prestation([
            'id' => Uuid::uuid4()->toString(),
            'libelle' => 'Prestation 2',
            'tarif' => 15.0,
            'description' => 'Description 2',
            'categorie_id' => $categorie->id
        ]);
        $prestation2->save();

        $result = $this->prestationsService->getPrestationByCategorieId($categorie->id);

        $this->assertIsArray($result);
    }

    public function testGetPrestationById()
    {
        $prestation = new Prestation([
            'id' => Uuid::uuid4()->toString(),
            'libelle' => 'Prestation test',
            'tarif' => 10.0,
            'description' => 'Description test'
        ]);
        $prestation->save();

        $result = $this->prestationsService->getPrestationById($prestation->id);

        $this->assertIsArray($result);
        $this->assertEquals($prestation->id, $result['id']);
        $this->assertEquals($prestation->libelle, $result['libelle']);
        $this->assertEquals($prestation->tarif, $result['tarif']);
        $this->assertEquals($prestation->description, $result['description']);
    }

    /**
     * @throws Exception
     */
    public function testGetUpdatePrestation()
    {
        $prestation = new Prestation([
            'id' => Uuid::uuid4()->toString(),
            'libelle' => 'Prestation test',
            'tarif' => 10.0,
            'description' => 'Description test'
        ]);
        $prestation->save();

        $newLibelle = 'Nouveau libellé';
        $newTarif = 20.0;
        $newDescription = 'Nouvelle description';

        $result = $this->prestationsService->getUpdatePrestation($prestation->id, [
            'libelle' => $newLibelle,
            'tarif' => $newTarif,
            'description' => $newDescription
        ]);

        $this->assertIsArray($result);
        $this->assertEquals($prestation->id, $result['id']);
        $this->assertEquals($newLibelle, $result['libelle']);
        $this->assertEquals($newTarif, $result['tarif']);
        $this->assertEquals($newDescription, $result['description']);
    }

    /**
     * @throws ServiceException
     */
    public function testGetCreatePrestation()
    {
        $prestaData = [
            'libelle' => 'Nouvelle prestation',
            'tarif' => 10.0,
            'description' => 'Description de la nouvelle prestation'
        ];

        $this->prestationsService->getCreatePrestation($prestaData);

        $prestations = Prestation::all();

        $this->assertEquals($prestaData['libelle'], $prestations[0]->libelle);
        $this->assertEquals($prestaData['tarif'], $prestations[0]->tarif);
        $this->assertEquals($prestaData['description'], $prestations[0]->description);
    }

    public function testGetPrestations()
    {
        $prestations = $this->prestationsService->getPrestations();

        $this->assertIsArray($prestations);
        $this->assertNotEmpty($prestations);
    }

    protected function tearDown(): void
    {
//        Prestation::truncate();
//        Categorie::truncate();

        parent::tearDown();
    }
}
