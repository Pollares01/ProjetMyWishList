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
        $value = $liste;
        $resultat = "";
        $nombreParticipants = 0;
        $l = $liste;
        $dateCourante = date("Y") . "-" . date("m") ."-" . date("d") ;
        if (isset($_SESSION['participants'])){
            foreach ($_SESSION['participants'] as $key => $values) {
                $item = Item::get();
                foreach ($item as $v) {
                    if ($v->liste_id == $l->no) {
                        if ($v->id == $key) {
                            if ($l->expiration <= $dateCourante) {
                            $resultat = $resultat . "<li>" . $values . "</li>";                           
                            }
                            $nombreParticipants++;
                        }
                    }
                }
            }
        }
        $vue = new VueParticipant3($liste,$nombreParticipants,$resultat,'AFFICHER_UNE_LISTE');
        $vue->render();
    }

    public static function demanderListe(){
        $vue = new VueParticipant3(null,null,null,'DEMANDER_UNE_LISTE');
        $vue->render();
    }

    public static function afficherItemDeListe($no)
    {
        $liste = Liste::where('no', '=', $no)->first();
        $item = $liste->items()->get();
        $vue = new VueParticipant3($item,null,null, 'ITEM_LISTE');
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

    public static function ajoutItem($tokenModif){
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $item = new Item();
        $item->nom = $_POST['nom'];
        $item->descr = $_POST['desc'];
        $item->tarif = $_POST['prix'];
        if(isset($_POST['url'])){
            $item->url = $_POST['url'];
        }
        $item->liste_id = $liste->no;
        $item->save();
        $vue = new VueModificationListe($liste);
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