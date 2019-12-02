<?php
namespace wishlist\controller;
use wishlist\modele\Liste;
use wishlist\vue\VueParticipant;
class ListeController
{
    public static function afficherListe()
    {
        $list = Liste::get();
        $vue = new VueParticipant($list);
        }
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