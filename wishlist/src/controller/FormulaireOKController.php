<?php

namespace wishlist\controller;
use wishlist\index;
use wishlist\vue\VueListeCree;
use wishlist\vue\VueChangeImg;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use wishlist\vue\VueImageAjout;

class FormulaireOKController
{
    public static function control(){
        $vue =  new VueListeCree();
        $vue->render();
    }

    public static function control2() {
        $item = Item::get();
        $liste = Liste::get();
        $vue = new VueChangeImg($item,$liste);
        $vue->render();
    }

    public static function control3() {
        $vue = new VueImageAjout();
        $vue->render();
    }
}