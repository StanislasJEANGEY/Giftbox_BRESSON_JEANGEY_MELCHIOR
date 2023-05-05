<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/vendor/autoload.php';

/* application boostrap */
$app = (require_once __DIR__ . '/../src/conf/bootstrap.php')();

/* routes loading */
(require_once __DIR__ . '/../src/conf/routes.php')($app);

\gift\app\services\utils\Eloquent::init(__DIR__ . '/../src/conf/gift.db.conf.ini');

/**
 * Question 1
 */

// Lister les prestations ; pour chaque prestation, afficher le libellé, la description, le tarif et l'unité.

echo "Question 1 :" . PHP_EOL;
foreach (\gift\app\models\Prestation::all() as $presta) {
	echo $presta->libelle . PHP_EOL;
	echo $presta->description . PHP_EOL;
	echo $presta->tarif . PHP_EOL;
	echo $presta->unit . PHP_EOL;
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
	echo $presta->unit . PHP_EOL;
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
	echo $presta->unit . PHP_EOL;
	echo "-------------------" . PHP_EOL;
}
echo "Fin : Question 3" . PHP_EOL;

$app->run();
