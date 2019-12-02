<?php
namespace wishlist\controller;
use wishlist\modele\Liste;
use wishlist\vue\VueParticipant;
class ListeController
{
    public static function afficherListe() {
        $list = Liste::get();
        $vue = new VueParticipant($list, 'LIST_LISTE_SOUHAITS');
        $vue->render();
        }

    public static function afficherItemDeListe($no) {
        $liste = Liste::where('no', '=', $no)->first();
        $items2 = $liste->items()->get();
        $vue1 = new VueParticipant($liste, 'LIST_LISTE_SOUHAITS');
        $vue2 = new VueParticipant($items2, 'LIST_LISTE_SOUHAITS_ITEMS');
        $vue1->render();
        $vue2->render();
    }
}