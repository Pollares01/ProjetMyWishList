<?php

use wishlist\modele\Liste;
use Illuminate\Database\Capsule\Manager as DB;

require_once 'vendor/autoload.php';


$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();


$list = Liste::get();

foreach ($list as $value){
    echo $value;
    echo "<br>";
}

//echo $q1->toJson();
