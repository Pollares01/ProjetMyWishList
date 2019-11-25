<?php

use wishlist\modele\Item;
use wishlist\modele\Liste;
use Illuminate\Database\Capsule\Manager as DB;

require_once 'vendor/autoload.php';

$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();

/**$list = Liste::get();

foreach($list as $value){
    echo $value;
    echo "<br>";
}

$res = Liste::where('no','=',2)->first();
echo $res;**/


$liste = Liste::where('no', '=', $_GET["no"])->first();
$items2 = $liste->items()->get();
foreach ($items2 as $value){
    echo($value);
    echo "<br>";
}

