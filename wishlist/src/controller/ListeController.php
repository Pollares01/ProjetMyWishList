<?php
namespace wishlist\controller;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\vue\VueAjoutItem;
use wishlist\vue\VueModificationListe;
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

    public static function modifierUneListe($tokenModif){
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $vue = new VueModificationListe($liste);
        $vue->render();
    }

    public static function ajoutItem($no){
        $item = new Item();
        $item->nom = $_POST['nom'];
        $item->descr = $_POST['desc'];
        $item->tarif = $_POST['prix'];
        if(isset($_POST['url'])){
            $item->url = $_POST['url'];
        }
        $item->liste_id = $no;
        $item->save();
        $vue = new VueAjoutItem("ajout");
        $vue->render();
    }

    public static function modificationListe($tokenModif){
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $liste->titre = $_POST['modifListe_titre'];
        $liste->description = $_POST['modifListe_description'];
        $liste->save();
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $vue = new VueModificationListe($liste);
        $vue->render();
    }
}