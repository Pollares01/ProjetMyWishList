<?php
namespace wishlist\controller;
use Slim\Slim;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\vue\VueCreerItem;
use wishlist\vue\VueItem;
use wishlist\vue\VueModificationItem;
use wishlist\vue\VueModificationListe;
use wishlist\vue\VueParticipant3;

class ItemController{
    /*
    * Afficher un item en fonction de son id
    */
    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueItem($item,"","","");
        $vue->render();
    }
    /*
    * Permet d'afficher toutes les items d'une liste
    */
    public static function afficherToutItems(){
        $item = Item::get();
        $vue = new VueParticipant3($item,null,null, 'TOUT_ITEM');
        $vue->render();
    }
    /*
    * permet l'ajout de message, le nom d'un participant, changement d'images, etcs... d'un item selon son id 
    */
    public static function modifierItem($id){
        $item = Item::where('id','=',$id)->first();
        $app = Slim::getInstance();
        $url = $app->urlFor('afficher_item_id_post',['id'=>$id]);
        if(isset($_POST['afficherItem_participant'])){
            $item->participant = $_POST['afficherItem_participant'];
        }
        if(isset($_POST['afficherItem_messageParticipant'])){
            $item->messageParticipant = $_POST['afficherItem_messageParticipant'];
        }
        $messageAjoutOk = "";
        if (isset($_POST['envoyer'])) {
            if ($_FILES['img']["tmp_name"] != "") {
                $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
                $target_file = 'img/';
                move_uploaded_file($_FILES['img']["tmp_name"], $target_file . $_FILES['img']["name"]);
                $item->img=$_FILES['img']["name"];
                $item->save();
                $messageAjoutOk =  "Ajout de l'image réussi !";
                $app->redirect($url);
            }
        }
        $messageSupOk = "";
        if (isset($_POST['deleteImg'])) {
            $item->img='';
            $res = $item->save();
            if ($res) {
                $messageSupOk = "L'image a bien été supprimée !";
               $app->redirect($url);
            }
        }

        $messageImgWebOk = "";
        if (isset($_POST['imgWeb'])){
            $textImg = $_POST['textImgWeb'];
            if ($textImg != "") {
            $textImg = filter_var($textImg, FILTER_SANITIZE_SPECIAL_CHARS);
            $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
            $item->img = 'imageWeb.jpg';
            $lienVersImageWeb = $app->request->getRootUri() . '/img/' . '/imageWeb.jpg';
            $fichier = $_SERVER['DOCUMENT_ROOT']. $lienVersImageWeb;
            copy($textImg, $fichier);
            $item->save();
            $messageImgWebOk =  "Ajout de l'image web réussi !";
            $app->redirect($url);
            }
        }
        $item->save();
        $vue = new VueItem($item,$messageSupOk,$messageAjoutOk,$messageImgWebOk);
        $vue->render();
    }
    /*
    * permet la modification des items d'une liste, description, nom, ects..
    */
    public static function modifierItemDansListe($id){
        $item = Item::where('id','=',$id)->first();
        $vue = new VueModificationItem($item);
        $vue->render();
    }
    /*
    * permet d'enregister les modifications d'un item
    */
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
    /*
    * Permet la suppression d'un item d'une liste
    */
    public static function supprimerItem($id){
        $item = Item::where('id','=',$id)->first();
        $liste = Liste::where('no', '=', $item->liste_id)->first();
        $item->delete();

        $app = Slim::getInstance();
        $app->redirect($app->urlFor('modifier_une_liste', ['tokenModif'=>$liste->tokenModif]));
    }

}
