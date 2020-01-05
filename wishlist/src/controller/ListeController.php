<?php
namespace wishlist\controller;
use wishlist\modele\Liste;
use wishlist\vue\VueParticipant3;
use wishlist\vue\VueCreerListe;
class ListeController
{
    public static function afficherListe()
    {
        $list = Liste::get();
        $vue = new VueParticipant3($list, 'ALL_LISTE');
        $vue->render();
    }

    public static function afficherUneListe($token){
        $liste = Liste::where('token','=',$token)->first();
        $vue = new VueParticipant3($liste,'AFFICHER_UNE_LISTE');
        $vue->render();
    }

    public static function demanderListe(){
        $vue = new VueParticipant3(null,'DEMANDER_UNE_LISTE');
        $vue->render();
    }
    public static function afficherItemDeListe($no)
    {
        $liste = Liste::where('no', '=', $no)->first();
        $item = $liste->items()->get();
        $vue = new VueParticipant3($item, 'ITEM_LISTE');
        $vue->render();
    }

    public static function creerListe() {
        $vue = new VueCreerListe();
        $vue->render();
    }
}