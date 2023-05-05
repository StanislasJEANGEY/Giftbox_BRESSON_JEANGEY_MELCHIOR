<?php

use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
//definit la configuration de la base de données
$db->addConnection(parse_ini_file('conf.ini'));
//lance la connexion
$db->setAsGlobal();
$db->bootEloquent();