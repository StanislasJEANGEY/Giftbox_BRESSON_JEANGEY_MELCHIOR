<?php

require_once '../services/utils.php';
require_once '../models/Prestation.php';

use gift\app\services\utils\Eloquent;


// Appel de la fonction init()
Eloquent::init(__DIR__ . '/../conf/gift.db.conf.ini');

/**
 * Question 1
 */

// Lister les prestations ; pour chaque prestation, afficher le libellé, la description, le tarif et l'unité.

echo "Question 1 :" . PHP_EOL."<br>";
foreach (gift\app\models\Prestation::all() as $presta) {
    echo $presta->libelle . PHP_EOL ."<br>";
    echo $presta->description . PHP_EOL."<br>";
    echo $presta->tarif . PHP_EOL."<br>";
    echo $presta->unite . PHP_EOL."<br>";
    echo "-------------------" . PHP_EOL."<br>";
}
echo "Fin : Question 1" . PHP_EOL ."<br> <br> <br>";

/**
 * Question 2
 */

// Lister les prestations ; pour chaque prestation, afficher le libellé, la description, le tarif et l'unité. Afficher
// de plus la catégorie de la prestation. On utilisera un chargement lié (eager loading).

echo "Question 2 :" . PHP_EOL."<br>";
foreach (\gift\app\models\Prestation::with('Categorie')->get() as $presta) {
    echo $presta->libelle . "({$presta->categorie->libelle})" . PHP_EOL."<br>";
    echo $presta->description . PHP_EOL."<br>";
    echo $presta->tarif . PHP_EOL."<br>";
    echo $presta->unite . PHP_EOL."<br>";
    echo "-------------------" . PHP_EOL."<br>";
}
echo "Fin : Question 2" . PHP_EOL."<br>";

/**
 * Question 3
 */

// Afficher la catégorie 3 (libellé) et la liste des prestations (libellé, tarif, unité) de cette catégorie.
// On utilisera impérativement la méthode implantant l'association.

echo "Question 3 :" . PHP_EOL."<br>";
$category = \gift\app\models\Category::find(3);
echo $category->libelle . PHP_EOL."<br>";
foreach ($category->prestations as $presta) {
    echo $presta->libelle . PHP_EOL."<br>";
    echo $presta->tarif . PHP_EOL."<br>";
    echo $presta->unite . PHP_EOL."<br>";
    echo "-------------------" . PHP_EOL."<br>";
}
echo "Fin : Question 3" . PHP_EOL."<br>";

/**
 * Question 4
 */

// Afficher la box d'ID 360bb4cc-e092-3f00-9eae-774053730cb2 : libellé, description, montant.

echo "Question 4 :" . PHP_EOL."<br>";
$box = \gift\app\models\Box::find('360bb4cc-e092-3f00-9eae-774053730cb2');
echo $box->libelle . PHP_EOL."<br>";
echo $box->description . PHP_EOL."<br>";
echo $box->montant . PHP_EOL."<br>";
echo "Fin : Question 4" . PHP_EOL."<br>";

/**
 * Question 5
 */

// Afficher la box d'ID 360bb4cc-e092-3f00-9eae-774053730cb2 : libellé, description, montant. Afficher de plus la les
// prestations prévues dans la box (libellé, tarif, unité, quantité).

echo "Question 5 :" . PHP_EOL."<br>";
$box = \gift\app\models\Box::with('prestations')->where('id', '=', '360bb4cc-e092-3f00-9eae-774053730cb2')->first();
echo $box->libelle . PHP_EOL."<br>";
echo $box->description . PHP_EOL."<br>";
echo $box->montant . PHP_EOL."<br>";
foreach ($box->prestations as $presta) {
    echo $presta->libelle . PHP_EOL."<br>";
    echo $presta->tarif . PHP_EOL."<br>";
    echo $presta->unite . PHP_EOL."<br>";
    echo $presta->contenu->quantite . PHP_EOL."<br>";
    echo "-------------------" . PHP_EOL."<br>";
}
echo "Fin : Question 5" . PHP_EOL."<br>";

/**
 * Question 6
 */

// Créer une box et lui ajouter 3 prestations.

echo "Question 6 :" . PHP_EOL."<br>";
$box = new \gift\app\models\Box();
$box->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
$box->libelle = "Box 6";
$box->description = "Description Box 6";
$box->token = base64_encode(random_bytes(32));
$box->save();
$box->prestations()->attach([
    '4cca0b9e-1b1a-3f00-9eae-774053730cb2' => ['quantite' => 1],
    '4cca0b9e-1b1a-3f00-9eae-774053730cb3' => ['quantite' => 2],
    '4cca0b9e-1b1a-3f00-9eae-774053730cb4' => ['quantite' => 3]
]);
