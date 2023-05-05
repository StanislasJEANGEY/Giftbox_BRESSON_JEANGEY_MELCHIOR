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

echo "Question 1 :" . PHP_EOL;
foreach (\gift\app\models\Prestation::all() as $presta) {
	echo $presta->libelle . PHP_EOL;
	echo $presta->description . PHP_EOL;
	echo $presta->tarif . PHP_EOL;
	echo $presta->unit . PHP_EOL;
	echo "-------------------" . PHP_EOL;
}
echo "Fin : Question 1" . PHP_EOL;

$app->run();
