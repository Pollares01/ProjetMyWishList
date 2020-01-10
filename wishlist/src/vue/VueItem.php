<?php
namespace wishlist\vue;

use wishlist\modele\Item;

class VueItem extends VuePrincipale{

    private $urlRevenirListe,$item;

    public function __construct($item)
    {
        parent::__construct();
        $this->item = $item;
        $value = $this->item;
        $this->urlRevenirListe = self::getApp()->urlFor('afficher_item_id',['id' => $value->id]);
    }

    private function affichageItemID()
    {
        $lienVersImage = self::getURLimages() . $this->item->img;
        $_SESSION['idItemActuel'] = $this->item->id;
        $nom = $this->item->nom;
        $desc = $this->item->descr;
        $id = $this->item->id;
        $tarif = $this->item->tarif;
        $url = self::getApp()->urlFor('afficher_item_id_post',['id'=>$id]);
        $urlAjoutImg = self::getApp()->urlFor('ajout_img');
        //supression d'une image - fonctionnalité 13
        $messageSupOk = "";
        if (isset($_POST['deleteImg'])) {
            $this->item->img='';
            $res = $this->item->save();
            if ($res) {
                $messageSupOk = "L'image a bien été supprimée !";
                self::getApp()->redirect($url);
            }
        }
        $messageAjoutOk = "";
        $messageImgWebOk = "";
        if (isset($_POST['imgWeb'])){
            $textImg = $_POST['textImgWeb'];
            if ($textImg != "") {
            $textImg = filter_var($textImg, FILTER_SANITIZE_SPECIAL_CHARS);
            $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
            $item->img = 'imageWeb.jpg';
            $lienVersImageWeb = self::getURLimages() . '/imageWeb.jpg';
            //$fichier = $_SERVER['DOCUMENT_ROOT'].'/ProjetMyWishList/ProjetMyWishList/wishlist/img/imageWeb.jpg';
            $fichier = $_SERVER['DOCUMENT_ROOT']. $lienVersImageWeb;
            copy($textImg, $fichier);
            $item->save();
            $messageImgWebOk =  "Ajout de l'image web réussi !";
            self::getApp()->redirect($url);
            }
        }

        if (isset($_POST['envoyer'])) {
            $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
            $target_file = 'img/';
            move_uploaded_file($_FILES['img']["tmp_name"], $target_file . $_FILES['img']["name"]);
            $item->img=$_FILES['img']["name"];
            $item->save();
            $messageAjoutOk =  "Ajout de l'image réussi !";
            self::getApp()->redirect($url);
        }

        /**if (isset($_POST['participant']) && isset($_POST['messageParticipant'])) {
        if (isset($_SESSION['participants']) && isset($_SESSION['messageParticipant'])){
        $messageReservItem = $_SESSION['messageParticipant'];
        $messageReservItem[$id] = $_POST['messageParticipant'];
        $_SESSION['messageParticipant'] = $messageReservItem;
        $tabReservItem = $_SESSION['participants'];
        $tabReservItem[$id] = $_POST['participant'];
        $_SESSION['participants'] = $tabReservItem;
        }else{
        $messageReservItem = array($id => $_POST['messageParticipant']);
        $_SESSION['messageParticipant'] = $messageReservItem;
        $tabReservItem = array($id => $_POST['participant']);
        $_SESSION['participants'] = $tabReservItem;
        }
        }
        if(isset($_SESSION['participants']) && isset($_SESSION['participants'][$id]) && isset($_SESSION['messageParticipant']) && isset($_SESSION['messageParticipant'][$id])) {
        $tabReservItem = $_SESSION['participants'];
        $valeurParticipant = $tabReservItem[$id];
        $messageReservItem = $_SESSION['messageParticipant'];
        $valeurMessage = $messageReservItem[$id];
        }else{**/
        $valeurParticipant = $this->item->participant;
        $valeurMessage = $this->item->messageParticipant;
        $res = "   
                    <br>
                    <div class=\"card\" style=\"width: 18rem;\">
                    <span class='border border-primary'>
                        <form method='POST' action=$url>
                            <button type='submit' name='deleteImg'>Supprimer</button>
                            </form>
                            <form method='POST' action=$url>
                            <input type='text' name ='textImgWeb' placeHolder='url ici !'>
                            <button type='submit' name='imgWeb'>Ok</button>
                            </form>
                        <form method='POST' action=$url enctype='multipart/form-data'>
                            <input type='file' accept='test.png' name='img' >
                            <button type='submit' name='envoyer'>Envoyer</button>
                            </form>
                          <img src=\"$lienVersImage\" class=\"card-img-top\" alt=\"\">
                          <div class=\"card-body\">
                                <h5 class=\"card-title\">$nom</h5>
                                <p class=\"card-text\">$desc
                                </br>
                                Tarif : $tarif €</p>
                          </div>
                          <form id='formulaireItem' method='POST' action=$url>
                            <input type='text' name='afficherItem_participant' placeholder='Nom du Participant' value=$valeurParticipant>
                            <button type='submit' name='valider' value='valid_reserverItem'>Valider</button>
                            <textarea class='messageReservFormu' name='afficherItem_messageParticipant' placeholder='Un petit message ?'>$valeurMessage</textarea>
                          </form>
                          <p>$messageSupOk</p>
                          <p>$messageAjoutOk</p>
                          <p>$messageImgWebOk</p>
                    </span>
                    </div>";
        return $res;
    }

    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = self::affichageItemID();
        $html = "
            $menu
            <div class=\"container h - 100\">
                <div class=\"row h - 100 align - items - center\">
                   <div class=\"col - 12 text - center\">
                        $content
                   </div>
                </div>
            </div>
            $footer
        ";
        echo $html;
}
}