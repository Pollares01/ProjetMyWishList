<?php

require 'vendor/autoload.php' ;
use wishlist\controller\ItemController;
use wishlist\controller\ListeController;
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\Slim();

$app->get('/liste/afficher', function (){
    ListeController::afficherListe();
})->name('afficher_toutes_listes');

$app->get('/liste/afficher/itemdeliste/:no', function($no) {
    ListeController::afficherItemDeListe($no);
})->name('afficher_items_dune_liste');

$app->get('/item/afficheritemid/:id', function($id) {
    ItemController::afficherItemID($id);
});

$app->get('/', function () {
    echo "Bienvenue sur my wish list !";
});

$app->run();