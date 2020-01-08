<?php
namespace wishlist\vue;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;
class VueListeCree extends VuePrincipale {
    
    private $url;
    private $titre, $description, $date, $image;
    public function __construct() {
        parent::__construct();
    }
    private function creationDeLaListe() {
        if (isset($_POST['creer'])){
          $target_file = 'img/';
          move_uploaded_file($_FILES["image"]["tmp_name"], $target_file . $_FILES["image"]["name"]);
          $tokenGenerated = "";
          $token = openssl_random_pseudo_bytes(32);
          $token = bin2hex($token);
          $tokenGenerated = $token;

          $tokenModifGenerated = "";
          $tokenModif = openssl_random_pseudo_bytes(32);
          $tokenModif = bin2hex($token);
          $tokenModifGenerated = $tokenModif;
          $this->titre = $_POST['titre'];
          $this->description = $_POST['description'];
          $this->date =  $_POST['expiration'];
          $this->titre = filter_var($this->titre, FILTER_SANITIZE_SPECIAL_CHARS);
          $this->titre = filter_var($this->titre, FILTER_SANITIZE_STRING);
          $this->description = filter_var($this->description, FILTER_SANITIZE_SPECIAL_CHARS);
          $this->description = filter_var($this->description, FILTER_SANITIZE_STRING);
          $this->date = filter_var($this->date, FILTER_SANITIZE_SPECIAL_CHARS);
          $this->date = filter_var($this->date, FILTER_SANITIZE_STRING);
          $this->image = $_FILES['image']['name'];
          
          $l = new Liste();
          $l->titre = $this->titre;
          $l->description = $this->description;
          $l->expiration = $this->date;
          $l->user_id = null;
          $l->token = $tokenGenerated;
          $l->tokenModif = $tokenModifGenerated;
          $res = $l->save();
        }
        print "Vous avez créé une liste de titre : " . $this->titre . ", de description : " . $this->description . ", de date d'expiration : " . $this->date . " et d'image : ";
        echo '<img src="/ProjetMyWishList/ProjetMyWishList/wishlist/img/' . $this->image . '">';
        echo "<h5>Token pour partager la liste</h5>
        <textarea  name='urlToken'>$tokenGenerated</textarea>";
        echo "<h5>Token pour modifier la liste</h5>
        <textarea  name='urlToken'>$tokenModifGenerated</textarea>";
    }
    public function render() {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
                $menu
        
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                            <div class="col-12 text-center">
                              
                           </div>
                    </div>
                </div>
                $footer
        END ;    
        echo $html;
        $this->creationDeLaListe();
    }
}