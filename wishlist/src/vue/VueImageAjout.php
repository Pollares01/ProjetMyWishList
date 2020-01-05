<?php

namespace wishlist\vue;
use wishlist\modele\Item;

class VueImageAjout {
    
    private $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlCreerListe, $urlPageIndex, $selecteur,$urlListeCree, $app;

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

        $this->urlListeCree = $this->app->urlFor('liste_cree');

    }

    private function deleteImg() {
            //choix d'une image - fonctionnalité 11
        if (isset($_POST['envoyer'])) {
          $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
            if ($item->img == "") {
            echo "Ajout de l'image reussi !";
            $target_file = 'img/';
            move_uploaded_file($_FILES['img']["tmp_name"], $target_file . $_FILES['img']["name"]);
            
            $item->img=$_FILES['img']["name"];
            $item->save();
            echo '<img src="/ProjetMyWishList/ProjetMyWishList/wishlist/img/' . $_FILES['img']['name'] . '">';
            }
        }
    }

    public function render() {
        $content = $this->deleteImg();
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
                                $content
                           </div>
                    </div>
                </div>
                <script src="$this->URLbootstrapJS"></script>
            </body>
        </html> 
        END ;
        echo $html;
    }
}