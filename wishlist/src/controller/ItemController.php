<?php
namespace wishlist\controller;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\vue\VueCreerItem;
use wishlist\vue\VueItem;
use wishlist\vue\VueModificationItem;
use wishlist\vue\VueModificationListe;
use wishlist\vue\VueParticipant3;

class ItemController{

    /**public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueParticipant3($item,null,null, 'ITEM_ID');
        $vue->render();
    }**/

    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueItem($item);
        $vue->render();
    }

    public static function afficherToutItems(){
        $item = Item::get();
        $vue = new VueParticipant3($item,null,null, 'TOUT_ITEM');
        $vue->render();
    }

    public static function modifierItem($id){
        $item = Item::where('id','=',$id)->first();
        if(isset($_POST['afficherItem_participant'])){
            $item->participant = $_POST['afficherItem_participant'];
        }
        if(isset($_POST['afficherItem_messageParticipant'])){
            $item->messageParticipant = $_POST['afficherItem_messageParticipant'];
        }
        $item->save();
        $vue = new VueItem($item);
        $vue->render();
    }

    public static function modifierItemDansListe($id){
        $item = Item::where('id','=',$id)->first();
        $vue = new VueModificationItem($item);
        $vue->render();
    }

    public static function modifierItemEnregistrer($id){
        $item = Item::where('id','=',$id)->first();
        $nom = $_POST['modifItem_titre'];
        $nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS	);
        $nom = filter_var($nom, FILTER_SANITIZE_STRING);
        $item->nom = $nom;

        $desc =  $_POST['modifItem_desc'];
        $desc= filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_var($desc, FILTER_SANITIZE_STRING);
        $item->descr = $desc;

        $tarif = $_POST['modifItem_prix'];
        $tarif = filter_var($tarif, FILTER_SANITIZE_NUMBER_FLOAT);
        $item->tarif = $tarif;

        $item->save();

        $vue = new VueModificationItem($item);
        $vue->render();
    }

    public static function supprimerItem($id){
        $item = Item::where('id','=',$id)->first();
        $liste = Liste::where('no', '=', $item->liste_id)->first();
        $item->delete();
        $vue = new VueModificationListe($liste);
        $listItem = Item::where('liste_id','=', $liste->no)->get();
        $vue->afficherItems($listItem);
        $vue->render();
    }

}
