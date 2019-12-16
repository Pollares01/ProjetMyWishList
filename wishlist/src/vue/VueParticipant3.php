<?php

namespace wishlist\vue;

class VueParticipant3
{

    private $app;
    private $liste, $typeAff, $urlAfficherToutesListes, $urlAfficherItemsListe, $urlITemID, $urlPageIndex, $urlCreerListe;
    private $URLbootstrapCSS, $URLbootstrapJS, $URLimages, $URLpersoCSS;

    public function __construct($tabItems, $typeAff) {
        $this->liste = $tabItems;
        $this->typeAff = $typeAff;
        $this->app =  \Slim\Slim::getInstance() ;

        $itemUrl1 =$this->app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;

        $itemUrl2 = $this->app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;

        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);

        $this->urlPageIndex = $this->app->urlFor('page_index');

        $itemUrl4 = $this->app->urlFor('creer_liste');
        $this->urlCreerListe = $itemUrl4;

        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';
        $this->URLpersoCSS = $this->app->request->getRootUri() . '/public/css_perso.css';
    }

    /**
     * Affiche toutes les listes dans un tableau
     * @return string
     */
    private function affichageToutListe() {
        $res = '';
        foreach ($this->liste as $value){
            $lien = $this->app->urlFor('afficher_items_dune_liste', ['no' => $value->no]);
            $res = $res . "
                                <a href=\"$lien\" class='text-black-50'>
                                    <div class='bg-light shadow'>
                                    $value->titre  
                                    </div>
                                </a><br><br>
                           ";
        }
        $res = $res . '';
        return "<h1> Liste des Listes : </h1> $res";
    }

    /**
     * Affiche tous les items présents dans une liste, ainsi que leur image et leur description
     * @return string
     */
    private function affichageItemsDeListe(){
        $res = '<section>';
        foreach ($this->liste as $value){
            $lien = $this->app->urlFor('afficher_item_id', ['id' => $value->id]);
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
        $nom = $this->liste->nom;
        $desc = $this->liste->desc;
        $id = $this->liste->id;
        $url = $this->app->urlFor('afficher_item_id_post',['id'=>$id]);
        $lienVersImage = $this->URLimages . $this->liste->img;
        if (isset($_POST['participant'])) {
            $tabItem = array("participant" => $_POST['participant'], "itemid" => $id);
            $_SESSION['participant'] = $_POST['participant'];
            $_SESSION['itemid'] = $id;
        }
        if(isset($_SESSION['participant']) && isset($_SESSION['itemid']) && $_SESSION['participant'] != null && $_SESSION['itemid'] == $id) {
            $valeur = $_SESSION['participant'];
        }else{
            $valeur = '';
        }
        $res = "   
                    <br>
                    <div class=\"card\" style=\"width: 18rem;\">
                    <span class='border border-primary'>
                          <img src=\"$lienVersImage\" class=\"card-img-top\" alt=\"\">
                          <div class=\"card-body\">
                                <h5 class=\"card-title\">$nom</h5>
                                <p class=\"card-text\">$desc</p>
                          </div>
                          <form id='form1' method='POST' action=$url>
                            <input type='text' name='participant' placeholder='Nom du Participant' value=$valeur>      
                            <button type='submit' name='valider' value='valid_reserverItem'>Valider</button>
                          </form>
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
        }
        $html = <<<END
        <!DOCTYPE HTML>
        <html>
            <head>
                <link rel="stylesheet" href="$this->URLbootstrapCSS">
                <link rel="stylesheet" href="$this->URLpersoCSS">
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </head>
            <body>
                <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light shadow    ">
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