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

$app->get('/liste/afficher/uneliste/:token', function($token){
    ListeController::afficherUneListe($token);
})->name('afficher_une_liste');

$app->post('/liste/afficher/uneliste/:token', function($token){
    ListeController::afficherUneListe($token);
})->name('afficher_une_liste_post');

$app->get('/liste/modifier/uneliste/:token', function($tokenModif){
    ListeController::modifierUneListe($tokenModif);
})->name('modifier_une_liste');

$app->post('/liste/modifier/informationsListe/:tokenModif', function($tokenModif){
    Listecontroller::modificationListe($tokenModif);
})->name('modification_une_liste');

$app->get('/liste/afficher/demande', function(){
    ListeController::demanderListe();
})->name('demander_une_liste');

$app->post('/liste/afficher/demande', function(){
    ListeController::demanderListe();
})->name('demander_une_liste_post');

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

$app->post('/creer/liste', function () {
    FormulaireOKController::control();
})->name('liste_cree');

$app->post('/confirmation/ajout', function() {
    FormulaireOKController::control3();
})->name('ajout_img');

$app->post('/ajout_item/:tokenModif', function($tokenModif){
    ListeController::ajoutItem($tokenModif);
})->name('ajouter_item_reussi');

$app->run();