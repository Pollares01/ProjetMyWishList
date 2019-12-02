<?php
namespace wishlist\controller;
use wishlist\modele\Liste;
use wishlist\vue\VueParticipant3;
class ListeController
{
    public static function afficherListe()
    {
        $list = Liste::get();
        $vue = new VueParticipant3($list);
        $vue->render();
    }

    public static function afficherItemDeListe($no)
    {
        $liste = Liste::where('no', '=', $no)->first();
        $items2 = $liste->items()->get();
        foreach ($items2 as $value) {
            echo($value);
            echo "<br>";
        }
    }
}