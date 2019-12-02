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
})->name('afficherliste');

$app->get('/liste/afficher/itemdeliste/:no', function($no) {
    ListeController::afficherItemDeListe($no);
})->name('itemdeliste');

$app->get('/item/afficheritemid/:id', function($id) {
    ItemController::afficherItemID($id);
})->name('route_item');

$app->get('/', function () {
    echo "Bienvenue sur my wish list !";
});

$rootUri = $app->request->getRootUri() ;
$url = $app->urlFor('route_item', ['id' => 1]) ;
$url1 = $app->urlFor('itemdeliste', ['no' => 1]) ;
$url2 = $app->urlFor('afficherliste');
$html = <<<END
<!DOCTYPE html>
<html>
<head> … </head>
<body>
…
    <div class="href">
        <li><a href="$url">FindById</a></li>
        <li><a href="$url1">ItemDeListe</a></li>
        <li><a href="$url2">AfficherListe</a></li>
    </div>
</body><html>
END ;
echo $html;

$app->run();