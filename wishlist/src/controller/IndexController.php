<?php


namespace wishlist\controller;
use wishlist\index;
use wishlist\vue\VueAccueil;
use wishlist\vue\VueCompte;

class IndexController
{
    public static function interfaceListe(){
        $vue =  new VueAccueil();
        $vue->render();
    }

    public static function creerCompte(){
        $vue = new VueCompte('creerCompte');
        $vue->render();
    }

    public static function confirmCompte(){
        $vue = new VueCompte('confirm');
        $vue->render();
    }
}