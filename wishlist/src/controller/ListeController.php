<?php
namespace wishlist\controller;
use Slim\Slim;
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
        if( isset($_POST['une_liste_message'])){
            $liste->messages = $_POST['une_liste_message'];
            $liste->save();
        }
        $dateCourante = date("Y") . "-" . date("m") ."-" . date("d") ;
                $item = Item::get();
                foreach ($item as $v) {
                        if ($v->liste_id == $l->no) {
                            if ($v->participant != "") {
                                if ($l->expiration < $dateCourante) {
                                    $resultat = $resultat . "<li>" . $v->participant . "</li>" ;                  
                                        if ($v->messageParticipant != "") {
                                            $resultat = $resultat . "Message : " .  $v->messageParticipant . "</br>";  ;
                                   } 
                                }
                            $nombreParticipants++;
                        }
                    }
                }
        $vue = new VueParticipant3($liste,$nombreParticipants,$resultat,'AFFICHER_UNE_LISTE');
        $vue->render();
    }

    public static function demanderListe(){
        $listes = Liste::where('public','=','1')->get();
        $vue = new VueParticipant3($listes,null,null,'DEMANDER_UNE_LISTE');
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
        $vue = new VueCreerListe("");
        $vue->render();
    }

    public static function modifierUneListe($tokenModif){
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $vue = new VueModificationListe($liste);
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
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
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
        $vue->render();
    }

    public static function modificationListe($tokenModif){

        $liste = Liste::where('tokenModif','=',$tokenModif)->first();
        $titre = $_POST['modifListe_titre'];
        $titre= filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
        $titre = filter_var($titre, FILTER_SANITIZE_STRING);
        $liste->titre = $titre;

        $desc =  $_POST['modifListe_description'];
        $desc = filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_var($desc, FILTER_SANITIZE_STRING);
        $liste->description = $desc;
        $liste->save();
        $liste = Liste::where('tokenModif','=',$tokenModif)->first();

        $vue = new VueModificationListe($liste);
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
        $vue->render();
    }

    public static function supprimerListe($token){

            $liste = Liste::where('tokenModif', '=', $token)->first();
            $liste->delete();
            $app = Slim::getInstance();
            $app->redirect($app->urlFor('demander_une_liste'));
        

    }
}