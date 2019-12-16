<?php
namespace wishlist\vue;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;

class VueListeCree {
    
    private $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlCreerListe, $urlPageIndex, $liste;

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

        $this->liste = new Liste();
    }

    public function creationDeLaListe() {
        echo ("titre : " .  htmlspecialchars($_POST['titre'] ) . "<br>");
        echo "description : " .  htmlspecialchars($_POST['description']) . "<br>";
        echo "date d'expiration : " . htmlspecialchars($_POST['expiration']) . "<br>";
        $image = $_POST['image'];
        echo "image : " .  $_POST['image'] . "<br>";
      /*
        $this->liste->titre = $_POST['titre'];
        $this->liste->description = $_POST['description'];
        $this->liste->expiration = $_POST['expiration'];
        $this->liste->no = 4;
        $this->liste->user_id = 4;
        $res = $this->liste->save();
        if($res){
            echo "Nouvelle insersion $this->liste";
        } else {
            echo "$this->liste n'a pas été inséré";
        }*/
        $file = parse_ini_file('src/conf/conf.ini');
        $db = new DB();
        $db->addConnection($file);
        $db->setAsGlobal();
        $db->bootEloquent();

        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $date =  $_POST['expiration'];

        $statement =("'INSERT into liste (titre,description,expiration) values ($titre,$description,$date)'");
        $db->execute($statement);
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
                <script src="$this->URLbootstrapJS"></script>
            </body>
        </html> 
        END ;    
        echo $html;
        $this->creationDeLaListe();
    }
}

