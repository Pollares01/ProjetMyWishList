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

/*
* Fonctionnalité 1 : 
* créer une nouvelle liste en lui donnant un titre, une description, une date limite de validité. 
*/

echo (Liste::get());

$liste = new Liste();

$liste->no = 3;
$liste->user_id = 3;
$liste->titre = "Création d'une nouvelle liste, voici son titre";
$liste->description = "wishlist meilleur projet php";
$liste->expiration = "2018-12-13";

$res = $liste->save();
/*
if($res){
    echo "Nouvelle insersion $liste";
} else {
    echo "$liste n'a pas été inséré";
}*/
