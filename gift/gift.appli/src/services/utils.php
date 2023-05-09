<?php

namespace gift\app\services\utils;

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB ;

class Eloquent {

	public static function init ($filename) {

		$db = new DB();
		$db->addConnection(parse_ini_file($filename));
		$db->setAsGlobal();
		$db->bootEloquent();

	}

}