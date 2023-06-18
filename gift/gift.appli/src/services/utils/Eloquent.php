<?php

namespace gift\app\services\utils;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent {

	/**
	 * Méthode permettant d'initialiser Eloquent
	 * @param $filename
	 * @return void
	 */
    public static function init($filename): void {
        $capsule = new Capsule;

        $config = parse_ini_file($filename);

        $capsule->addConnection([
            'driver' => $config['driver'],
            'host' => $config['host'],
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

}