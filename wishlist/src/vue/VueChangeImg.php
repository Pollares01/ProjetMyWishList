<?php

namespace wishlist\vue;
use wishlist\modele\Item;

class VueChangeImg {
    
    private $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlCreerListe, $urlPageIndex, $selecteur,$urlListeCree, $app;
    private $item, $liste;

    public function __construct($item,$liste) {

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
        $this->item = $item;
        $this->liste = $liste;
    }

    private function affichageDesImages() {
        //changement d'une image - fonctionnalité 12
        $url = $this->app->urlFor('afficher_item_id', ['id' => $_SESSION['idItemActuel']]);
        if (isset($_POST['changeImg'])) {
            echo ("<div class=\"card-body\"> ");
            foreach($this->item as $values) {
                echo "<h5 class=\"card-title\">$values->img</h5>";
                echo '<img src="/ProjetMyWishList/ProjetMyWishList/wishlist/img/' . $values->img . '">';
                echo "<form method='post' action=$url> <button type='submit' name='Choisir'>Choisir</button></form>";
            }
            echo ("</div>");
        }
        if (isset($_POST['Choisir'])) {
            $item = Item::where("id" , "=" , $_SESSION['idItemActuel'])->first();
            $item->img="uno.jpg";
            $item->save();
        }
    }
    

    public function render() {
        $content = $this->affichageDesImages();
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