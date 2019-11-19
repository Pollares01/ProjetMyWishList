<?php

use wishlist\modele\Liste;
use wishlist\modele\Item;
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
echo "<br>";
$listItem = Item::get();

foreach ($listItem as $value){
    echo $value;
    echo "<br>";
}
<<<<<<< HEAD

Item::findById($_GET["id"]);

=======
echo "César est pas ergonomique";
>>>>>>> 8ccd4957059f12a8f47ca464a950d1cb9f4ae48a
//echo $q1->toJson();
