<?php

session_start();
require 'vendor/autoload.php' ;
use wishlist\controller\ItemController;
use wishlist\controller\ListeController;
use wishlist\controller\FormulaireOKController;
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
})->name('afficher_item_id');

$app->post('/item/afficheritemid/:id', function($id) {
    ItemController::afficherItemID($id);
})->name('afficher_item_id_post');

$app->get('/item/afficher', function(){
    ItemController::afficherToutItems();
})->name('afficher_tous_items');

$app->get('/creer/liste', function() {
    ListeController::creerListe();
})->name('creer_liste');


$app->get('/', function () {
    \wishlist\controller\IndexController::interfaceListe();
})->name('page_index');

<<<<<<< HEAD
$app->post('/creer/liste', function () {
    FormulaireOKController::control();
})->name('liste_cree');

=======
>>>>>>> c29cf91f0399a980568978ac492b4137e50b0e8a
$app->run();