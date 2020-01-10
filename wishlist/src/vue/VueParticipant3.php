<?php

namespace wishlist\vue;

use wishlist\modele\Item;
use wishlist\modele\Liste;

class VueParticipant3 extends VuePrincipale
{

    private $liste, $typeAff;
    private  $urlDemandeListe;
    private $nombreParticipants = 0;
    private $nomsParticipants = array();
    private $resultat;

    public function __construct($tabItems, $nombreP,$resultat,$typeAff) {
        parent::__construct();
        $this->liste = $tabItems;
        $this->typeAff = $typeAff;
        $this->nombreParticipants = $nombreP;
        $this->resultat = $resultat;
        $this->urlDemandeListe = self::getApp()->urlFor('demander_une_liste');
    }

    private function demandeUneListe(){
        if (isset($_POST['demandeUneListe'])){
            $token = $_POST['demandeUneListe'];
            $request = Liste::select('no')->where('token', '=' , $token)->first();
            if ($request != null){
                self::getApp()->redirect(self::getApp()->urlFor('afficher_une_liste_post',['token' => $token]));
            }else{
                $url = self::getApp()->urlFor('demander_une_liste');
            }
        }else{
            $url = self::getApp()->urlFor('demander_une_liste');
        }
        $res = "
            </br>
            <h1>Veuillez entrer le Token de la liste voulue :</h1>
            </br>
            <form id='formulaireListe' method='POST' action=$url>
                <input type='text' name='demandeUneListe' placeholder='Token De La Liste'>
                <button type='submit' name='valider' value='valid_reserverItem'>Valider</button>
            </form>";
        return $res;
    }
    private function affichageUneListe(){
        $titre =  $this->liste->titre;
        $lien = self::getApp()->urlFor('afficher_items_dune_liste', ['no' => $this->liste->no]);
        if(isset($_POST['demandeModifListe'])){
            $tokenModif = $_POST['demandeModifListe'];
            $request = Liste::select('no')->where('tokenModif','=',$tokenModif)->first();
            if($request != null){
                self::getApp()->redirect(self::getApp()->urlFor('modifier_une_liste',['token'=>$tokenModif]));
            }else{
                $url = self::getApp()->urlFor('afficher_une_liste_post',['token'=>$this->liste->token]);
            }
        }else{
            $url = self::getApp()->urlFor('afficher_une_liste_post',['token'=>$this->liste->token]);
        }
        $res = <<<END
                </br>
                <a href="$lien" class='text-black-50'>
                    <div class='affichageListe'>
                        $titre
                    </div>
                </a></br>
                <p>En rentrant le Token de modification de cette liste vous pourrez modifier ses informations générales ainsi qu'ajouter un item.</p>
                <form id='formulaireModifListe' method='POST' action=$url>
                    <input type='text' name='demandeModifListe' placeholder='Token de modification de la liste'>
                    <button type='submit' name='valider' value='valid_modifierListe'>Valider</button>
                </form>
                </br>
                <h5>Nombre des participants à la liste</h5>
                </br>
                <div>
                <p>$this->nombreParticipants</p>
                </div>
                </br>
                </br>
                <h5>Noms des participants à la liste</h5>
                </br>
                <div>
                    $this->resultat
                </div>
                </br>
END;
        return $res;
    }
    /**
     * Affiche toutes les listes dans un tableau
     * @return string
     */
    private function affichageToutListe() {
        $res = '';
        foreach ($this->liste as $value){
            $lien = self::getApp()->urlFor('afficher_items_dune_liste', ['no' => $value->no]);
            $res = $res . "
                                <a href=\"$lien\" class='text-black-50'>
                                    <div class='affichageListe'>
                                    $value->titre  
                                    </div>
                                </a><br><br>
                           ";
        }
        $res = $res . '';
        return "<h1> Liste des Listes : </h1></br> $res";
    }

    /**
     * Affiche tous les items présents dans une liste, ainsi que leur image et leur description
     * @return string
     */
    private function affichageItemsDeListe(){
        $res ='<section>';
        foreach ($this->liste as $value){
            $lien = self::getApp()->urlFor('afficher_item_id', ['id' => $value->id]);
            $res = $res . "
                                    <div class='bg-light shadow'>
                                    <a href=\"$lien\" class='text-black-50'>
                                    <h3 class='text-liste-main'>$value->nom</h3>
                                    </a>
                                    <p>$value->descr</p>
                                    </div>
                                <br><br>
                           ";
        }
        $res = $res . "</section>";
        return "<h1> Les items de la liste sont : </h1><br> $res";
    }

    private function affichageItemID()
    {
        $lienVersImage = self::getURLimages() . $this->liste->img;
        $_SESSION['idItemActuel'] = $this->liste->id;
        $nom = $this->liste->nom;
        $desc = $this->liste->descr;
        $id = $this->liste->id;
        $tarif = $this->liste->tarif;
        $url = self::getApp()->urlFor('afficher_item_id_post',['id'=>$id]);
        $urlAjoutImg = self::getApp()->urlFor('ajout_img');
        //supression d'une image - fonctionnalité 13
        $messageSupOk = "";
        if (isset($_POST['deleteImg'])) {
            $this->liste->img='';
            $res = $this->liste->save();
            if ($res) {
                $messageSupOk = "L'image a bien été supprimée !";
                $this->app->redirect($url);
                self::getApp()->redirect($url);
            }
        }
        $messageAjoutOk = "";
        $messageImgWebOk = "";
        if (isset($_POST['imgWeb'])){
            $textImg = $_POST['textImgWeb'];
            $textImg = filter_var($textImg, FILTER_SANITIZE_SPECIAL_CHARS);
            if ($textImg != "") {
            $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
            $item->img = 'imageWeb.jpg';
            $lienVersImageWeb = self::getURLimages() . '/imageWeb.jpg';
            //$fichier = $_SERVER['DOCUMENT_ROOT'].'/ProjetMyWishList/ProjetMyWishList/wishlist/img/imageWeb.jpg';
            $fichier = $_SERVER['DOCUMENT_ROOT']. $lienVersImageWeb;
            copy($textImg, $fichier);
            $item->save();
            $messageImgWebOk =  "Ajout de l'image web réussi !";
            $this->app->redirect($url);
            }
            self::getApp()->redirect($url);
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
            $valeurParticipant = '';
            $valeurMessage = '';
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
                            <input type='text' name='participant' placeholder='Nom du Participant' value=$valeurParticipant>
                            <button type='submit' name='valider' value='valid_reserverItem'>Valider</button>
                            <textarea class='messageReservFormu' name='messageParticipant' placeholder='Un petit message ?'>$valeurMessage</textarea>
                          </form>
                          <p>$messageSupOk</p>
                          <p>$messageAjoutOk</p>
                          <p>$messageImgWebOk</p>
                    </span>
                    </div>";
        return $res;
    }

    /**
     * fonction utilisée pour le rendu des vues
     */
    public function render(){
        switch ($this->typeAff){
            //cas où l'on veut afficher toutes les listes
            case 'ALL_LISTE' : {
                $content = $this->affichageToutListe();
                break;
            }
            //cas où l'on veut afficher les items d'une liste
            case 'ITEM_LISTE' : {
                $content = $this->affichageItemsDeListe();
                break;
            }
            case 'ITEM_ID' : {
                $content = $this->affichageItemID();
                break;
            }
            case 'AFFICHER_UNE_LISTE' : {
                $content = $this->affichageUneListe();
                break;
            }
            case 'DEMANDER_UNE_LISTE' : {
                $content = $this->demandeUneListe();
                break;
            }
            case 'MODIFIER_UNE_LISTE' : {
                $content = $this->accederModifierListe();
                break;
            }
        }

        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = "
              $menu
                <div class=\"container h-100\">
                    <div class=\"row h-100 align-items-center\">
                           <div class=\"col-12 text-center\">
                                $content
                           </div>
                    </div>
                </div>
              $footer";




        echo $html;
    }
}