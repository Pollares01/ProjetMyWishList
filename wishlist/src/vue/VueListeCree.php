<?php
namespace wishlist\vue;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;

class VueListeCree {
    
    private $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlCreerListe, $urlPageIndex, $url;

    public function __construct() {

        $this->app =  \Slim\Slim::getInstance() ;

        $itemUrl1 =$this->app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;

        $itemUrl2 = $this->app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;

        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);

        $itemUrl4 = $this->app->urlFor('creer_liste');
        $this->urlCreerListe = $itemUrl4;

        $this->urlPageIndex = $this->app->urlFor('page_index');

        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';
        $this->url = $this->app->urlFor('liste_cree');
    }

    private function creationDeLaListe() {
        $target_file = 'img/';
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file . $_FILES["image"]["name"]);
        $tokenGenerated = "";
        if (isset($_POST['partager'])) {
          $token = openssl_random_pseudo_bytes(32);
          $token = bin2hex($token);
          $tokenGenerated = $token;
        }

        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $date =  $_POST['expiration'];

        $titre = filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
        $date = filter_var($date, FILTER_SANITIZE_SPECIAL_CHARS);
        
          $l = new Liste();
          $l->titre = $titre;
          $l->description = $description;
          $l->expiration = $date;
          $l->user_id = null;
          $res = $l->save();

        print "Vous avez créé une liste de titre : " . $titre . ", de description : " . $description . ", de date d'expiration : " . $date . " et d'image : ";
        echo '<img src="/ProjetMyWishList/ProjetMyWishList/wishlist/img/' . $_FILES['image']['name'] . '">';

        echo "<form id='formulaireItem' method='POST' action=$this->url>
            <button type='submit' name='partager'>Partager liste</button>
            <textarea  name='urlToken' placeholder='Clef généré ici ...'>$tokenGenerated</textarea>
            </form>";
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
                          <a class="nav-link" href="$this->urlAfficherToutesListes">Afficher la liste des listes
                              </a>
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

