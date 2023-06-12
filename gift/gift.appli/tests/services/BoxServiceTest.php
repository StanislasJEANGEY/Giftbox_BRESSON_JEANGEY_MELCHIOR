<?php

namespace gift\test\services\prestations;

use gift\app\models\Box;
use gift\app\services\box\BoxService;
use gift\app\services\prestations\PrestationsService;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;

class BoxServiceTest extends TestCase
{
    private static array $boxIds = [];
    private static array $prestations = [];
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $db = new DB();
        $db->addConnection(parse_ini_file(__DIR__ . '/../../../src/conf/gift.db.test.ini'));
        $db->setAsGlobal();
        $db->bootEloquent();
        $faker = \Faker\Factory::create('fr_FR');

        $boxService = new BoxService();
        $prestaService = new PrestationsService();

        for ($i = 1; $i <= 4; $i++) {
            $p = $prestaService->getCreatePrestation([
                'id' => $faker->uuid(),
                'libelle' => $faker->word(),
                'description' => $faker->paragraph(3),
                'tarif' => $faker->randomFloat(2, 20, 200),
                'unite' => $faker->numberBetween(1, 3)
            ]);
            self::$prestations[] = $p;
        }
        foreach (self::$prestations as $prestation) {
            $prestation->save();
        }
    }

        public static function tearDownAfterClass(): void
        {
            parent::tearDownAfterClass();

            foreach (self::$boxIds as $id) {
                $b = (new \gift\app\services\box\BoxService)->getBoxById($id);
                $b->prestations()->detach();
                $b->delete();
            }
            foreach (self::$prestations as $p) {
                $p->delete();
            }
        }
}