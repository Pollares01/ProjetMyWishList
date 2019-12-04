<?php

namespace wishlist\vue;

class VueParticipant3
{

    private $app;
    private $liste, $typeAff, $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlPageIndex;
    private $URLbootstrapCSS, $URLbootstrapJS, $URLimages;

    public function __construct($tabItems, $typeAff) {
        $this->liste = $tabItems;
        $this->typeAff = $typeAff;
        $this->app =  \Slim\Slim::getInstance() ;

        $itemUrl1 =$this->app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;

        $itemUrl2 = $this->app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;

        $itemUrl3 = $this->app->urlFor('afficher_tous_items');
        $this->urlTousItem = $itemUrl3;

        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);

        $this->urlPageIndex = $this->app->urlFor('page_index');

        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';

    }


    /**
     * Affiche tous les items, ainsi que leur image et leur description
     * @return string
     */
    private function affichageToutItem(){
        $res = '<section>';
        foreach ($this->liste as $value){
            $lienVersImage = $this->URLimages . $value->img;
            $res = $res . "
                    <div class=\"card\" style=\"width: 18rem;\">
                          <img src=\"$lienVersImage\" class=\"card-img-top\" alt=\"\">
                          <div class=\"card-body\">
                                <h5 class=\"card-title\">$value->nom</h5>
                                <p class=\"card-text\">$value->descr</p>
                          </div>
                    </div>";
        }
        $res = $res . "</section>";
        return "<p> Tous les items : </p> $res";
    }

    /**
     * Affiche toutes les listes dans un tableau
     * @return string
     */
    private function affichageToutListe() {
        $res = '
            <section>';
        foreach ($this->liste as $value){
            $res = $res . "<tr>
                              <th scope=\"row\">$value->no</th>
                              <td>$value->user_id</td>
                              <td>$value->titre</td>
                              <td>$value->description</td>
                           </tr>";
        }
        $res = $res . '</section> ';
        return "<p> liste de tout : </p> $res";
    }

    /**
     * Affiche tous les items présents dans une liste, ainsi que leur image et leur description
     * @return string
     */
    private function affichageItemsDeListe(){
        $res = '<section>';
        foreach ($this->liste as $value){
            $lienVersImage = $this->URLimages . $value->img;
            $res = $res . "
                    <div class=\"card\" style=\"width: 18rem;\">
                          <img src=\"$lienVersImage\" class=\"card-img-top\" alt=\"\">
                          <div class=\"card-body\">
                                <h5 class=\"card-title\">$value->nom</h5>
                                <p class=\"card-text\">$value->descr</p>
                          </div>
                    </div>";
        }
        $res = $res . "</section>";
        return "<p> Les items de la liste sont : </p> $res";
    }

    /**
     * fonction utilisée pour le rendu des vues
     */
    public function render(){
        switch ($this->typeAff){
            //cas où l'on veut afficher toutes les listes
            case 'ALL_LISTE' : {
                $content = "<table class=\"table\">
                                <thead class=\"thead-dark\">
                                <tr>
                                    <th scope=\"col\">Numéro</th>
                                    <th scope=\"col\">User id</th>
                                    <th scope=\"col\">Titre</th>
                                    <th scope=\"col\">Description</th>
                                </tr>
                                </thead>
                                <tbody>";
                $content = $content . $this->affichageToutListe();
                $content = $content . "</tbody></table>";
                break;
            }
            //cas où l'on veut afficher les items d'une liste
            case 'ITEM_LISTE' : {
                $content = $this->affichageItemsDeListe();
                break;
            }
            //cas où l'on veut afficher tous les items
            case 'TOUT_ITEM' : {
                $content = $this->affichageToutItem();
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
            </head>
            <body>
                <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="$this->urlPageIndex">WishList</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link" href="$this->urlAfficherToutesListes">Affichage des listes</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="$this->urlAfficherItemsListe">Affichage des items d'une liste</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="$this->urlTousItem">Affichade de la liste de tous les items</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="$this->urlITemID">Affichage d'un item par id</a>
                    </li>
                  </ul>
                </div>
              </nav>
                </header>
                <div>
                    $content
                </div>
                <script src="$this->URLbootstrapJS"></script>
            </body>
        </html> 
        END ;
    echo $html;
    }

    private function affichageItemID()
    {
        $nom = $this->liste->nom;
        $desc = $this->liste->descr;
        $lienVersImage = $this->URLimages . $this->liste->img;
        $res = "
                    <div class=\"card\" style=\"width: 18rem;\">
                          <img src=\"$lienVersImage\" class=\"card-img-top\" alt=\"\">
                          <div class=\"card-body\">
                                <h5 class=\"card-title\">$nom</h5>
                                <p class=\"card-text\">$desc</p>
                          </div>
                    </div>";
        return $res;
    }
}