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

        $nom = $_POST['nom'];
        $nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS	);
        $nom = filter_var($nom, FILTER_SANITIZE_STRING);
        $item->nom = $nom;

        $desc =  $_POST['desc'];
        $desc= filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_var($desc, FILTER_SANITIZE_STRING);
        $item->descr = $desc;

        $tarif = $_POST['prix'];
        $tarif = filter_var($tarif, FILTER_SANITIZE_NUMBER_FLOAT);
        $item->tarif = $tarif;

        if(isset($_POST['url'])){
            $url = $_POST['url'];
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $item->url = $url;
        }

        $item->liste_id = $liste->no;
        $item->save();
        $vue = new VueModificationListe($liste);
        $vue->render();
    }

    public static function modificationListe($tokenModif){


        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $titre = $_POST['modifListe_titre'];
        $titre= filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
        $titre = filter_var($titre, FILTER_SANITIZE_STRING);
        $liste->titre = $titre;

        $liste =  $_POST['modifListe_description'];
        $liste= filter_var($liste, FILTER_SANITIZE_SPECIAL_CHARS);
        $liste = filter_var($liste, FILTER_SANITIZE_STRING);
        $liste->description = $liste;
        $liste->save();
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $vue = new VueModificationListe($liste);
        $vue->render();
    }

}