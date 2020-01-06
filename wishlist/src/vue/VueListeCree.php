<?php
namespace wishlist\vue;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;
class VueListeCree {
    
    private $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlCreerListe, $urlPageIndex, $url;
    private $titre, $description, $date, $image, $urlDemandeListe;
    public function __construct() {
        $this->app =  \Slim\Slim::getInstance() ;
        $itemUrl1 =$this->app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;
        $itemUrl2 = $this->app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;
        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);
        $itemUrl4 = $this->app->urlFor('creer_liste');
        $this->urlCreerListe = $itemUrl4;
        $this->urlDemandeListe = $this->app->urlFor('demander_une_liste');
        $this->urlPageIndex = $this->app->urlFor('page_index');
        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';
        $this->url = $this->app->urlFor('liste_cree');
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
          $this->description = filter_var($this->description, FILTER_SANITIZE_SPECIAL_CHARS);
          $this->date = filter_var($this->date, FILTER_SANITIZE_SPECIAL_CHARS);
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
        $html = <<<END
        <!DOCTYPE HTML>
        <html>
            <head>
                <link rel="stylesheet" href="$this->URLbootstrapCSS">
            </head>
            <body>
                <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
                  <div class="container">
                    <a class="navbar-brand" href="$this->urlPageIndex">My Wish List</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                      <ul class="navbar-nav ml-auto">
                      <li class="nav-item">
                          <a class="nav-link" href="$this->urlPageIndex">Accueil</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="$this->urlDemandeListe">Afficher une liste
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="$this->urlTousItem">Afficher la liste des items</a>
                        </li>
                       <li class="nav-item">
                      <a class="nav-link" href="$this->urlITemID">Affichage d'un item par id</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="$this->urlCreerListe">Creer une liste de souhait</a>
                  </li>
                      </ul>
                    </div>
                  </div>
                </nav>
                </header>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                            <div class="col-12 text-center">
                              
                           </div>
                    </div>
                </div>
                <script src="$this->URLbootstrapJS"></script>
            </body>
        </html> 
        END ;    
        echo $html;
        $this->creationDeLaListe();
    }
}