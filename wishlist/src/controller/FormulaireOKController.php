<?php


namespace wishlist\controller;
use wishlist\index;
use wishlist\vue\VueListeCree;

class FormulaireOKController
{
    public static function control(){
        $vue =  new VueListeCree();
        $vue->render();
    }
}