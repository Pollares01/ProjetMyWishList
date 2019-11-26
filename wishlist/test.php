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

echo "<br>";
$liste = Item::where('id', '=', $_GET["id"])->first();
echo ($liste);


echo "<br>";

$i = new Item();
$i->nom = 'coussin';
$i->descr = 'avec une image Gandalf';
$i->tarif = 15;
$i->liste_id = 2;
$res = $i->save();
if($res){
    echo "Nouvelle insersion $i";
} else {
    echo "$i n'a pas été inséré";
}

echo "<br>";echo "<br>";

$itemListe = Item::get();

foreach ($itemListe as $val){
    $list_liste = $val->liste()->get();
    foreach ($list_liste as $value){
        echo $val->nom ."   \t      " .$value->titre;
        echo "<br>";
    }
}


