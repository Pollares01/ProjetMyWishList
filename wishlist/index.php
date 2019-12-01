<?php
require 'vendor/autoload.php' ;

$app = new \Slim\Slim();

$app->get('/liste/afficher', function (){
    echo "get : afficherListe";
});

$app->get('/liste/afficher/itemdeliste', function() {
    echo "get : afficherItemDeListe";
});

$app->get('/item/id', function() {
    echo "get : designerItemParID";
});

$app->run();