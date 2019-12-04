<?php


namespace wishlist\controller;
use wishlist\index;
use wishlist\vue\VueAccueil;

class IndexController
{
    public static function interfaceListe(){
        $vue =  new VueAccueil();
        $vue->render();
    }
}