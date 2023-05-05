<?php
declare(strict_types=1);

require_once '../../../vendor/autoload.php';

/* application boostrap */
//$app = (require_once __DIR__ . '/../src/conf/bootstrap.php')();

/* routes loading */
//(require_once __DIR__ . '/../src/conf/routes.php')($app);

//$app->run();

\gift\app\services\utils\Eloquent::init('../src/conf/gift.db.conf.ini');

/**
 * Question 1
 */

// Lister les prestations ; pour chaque prestation, afficher le libellé, la description, le tarif et l'unité.

echo "Question 1 :" . PHP_EOL;
foreach (\gift\app\models\Prestation::all() as $presta) {
	echo $presta->libelle . PHP_EOL;
	echo $presta->description . PHP_EOL;
	echo $presta->tarif . PHP_EOL;
	echo $presta->unite . PHP_EOL;
	echo "-------------------" . PHP_EOL;
}
echo "Fin : Question 1" . PHP_EOL;

/**
 * Question 2
 */

// Lister les prestations ; pour chaque prestation, afficher le libellé, la description, le tarif et l'unité. Afficher
// de plus la catégorie de la prestation. On utilisera un chargement lié (eager loading).

echo "Question 2 :" . PHP_EOL;
foreach (\gift\app\models\Prestation::with('categorie')->get() as $presta) {
	echo $presta->libelle . "({$presta->categorie->libelle})" . PHP_EOL;
	echo $presta->description . PHP_EOL;
	echo $presta->tarif . PHP_EOL;
	echo $presta->unite . PHP_EOL;
	echo "-------------------" . PHP_EOL;
}
echo "Fin : Question 2" . PHP_EOL;

/**
 * Question 3
 */

// Afficher la catégorie 3 (libellé) et la liste des prestations (libellé, tarif, unité) de cette catégorie.
// On utilisera impérativement la méthode implantant l'association.

echo "Question 3 :" . PHP_EOL;
$category = \gift\app\models\Category::find(3);
echo $category->libelle . PHP_EOL;
foreach ($category->prestations as $presta) {
	echo $presta->libelle . PHP_EOL;
	echo $presta->tarif . PHP_EOL;
	echo $presta->unite . PHP_EOL;
	echo "-------------------" . PHP_EOL;
}
echo "Fin : Question 3" . PHP_EOL;

/**
 * Question 4
 */

// Afficher la box d'ID 360bb4cc-e092-3f00-9eae-774053730cb2 : libellé, description, montant.

echo "Question 4 :" . PHP_EOL;
$box = \gift\app\models\Box::find('360bb4cc-e092-3f00-9eae-774053730cb2');
echo $box->libelle . PHP_EOL;
echo $box->description . PHP_EOL;
echo $box->montant . PHP_EOL;
echo "Fin : Question 4" . PHP_EOL;

/**
 * Question 5
 */

// Afficher la box d'ID 360bb4cc-e092-3f00-9eae-774053730cb2 : libellé, description, montant. Afficher de plus la les
// prestations prévues dans la box (libellé, tarif, unité, quantité).

echo "Question 5 :" . PHP_EOL;
$box = \gift\app\models\Box::with('prestations')->where('id', '=', '360bb4cc-e092-3f00-9eae-774053730cb2')->first();
echo $box->libelle . PHP_EOL;
echo $box->description . PHP_EOL;
echo $box->montant . PHP_EOL;
foreach ($box->prestations as $presta) {
	echo $presta->libelle . PHP_EOL;
	echo $presta->tarif . PHP_EOL;
	echo $presta->unite . PHP_EOL;
	echo $presta->contenu->quantite . PHP_EOL;
	echo "-------------------" . PHP_EOL;
}
echo "Fin : Question 5" . PHP_EOL;

/**
 * Question 6
 */

// Créer une box et lui ajouter 3 prestations.

echo "Question 6 :" . PHP_EOL;
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
