<?php

namespace wishlist\vue;

class VueParticipant3
{

    private $app;
    private $liste, $typeAff, $urlAfficherToutesListes, $urlAfficherItemsListe, $urlITemID, $urlPageIndex, $urlCreerListe;
    private $URLbootstrapCSS, $URLbootstrapJS, $URLimages, $URLpersoCSS, $urlChangeImg;
    protected $id;

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
        $_SESSION['idItemActuel'] = $this->liste->id;
        $nom = $this->liste->nom;
        $desc = $this->liste->descr;
        $this->id = $this->liste->id;
        $tarif = $this->liste->tarif;
        $url = $this->app->urlFor('afficher_item_id_post',['id'=>$this->id]);
        $urlChangeImg = $this->app->urlFor('change_img');
        $urlAjoutImg = $this->app->urlFor('ajout_img');
        //supression d'une image - fonctionnalité 13
        $messageSupOk = "";
        if (isset($_POST['deleteImg'])) {
            $this->liste->img='';
            $res = $this->liste->save();
            if ($res) {
                $messageSupOk = "L'image a bien été supprimée !";
            }
        }

        $lienVersImage = $this->URLimages . $this->liste->img;
       
        if (isset($_POST['participant']) && isset($_POST['messageParticipant'])) {
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
        if(isset($_SESSION['participants']) && isset($_SESSION['participants'][$this->id]) && isset($_SESSION['messageParticipant']) && isset($_SESSION['messageParticipant'][$this->id])) {
            $tabReservItem = $_SESSION['participants'];
            $valeurParticipant = $tabReservItem[$this->id];
            $messageReservItem = $_SESSION['messageParticipant'];
            $valeurMessage = $messageReservItem[$this->id];
        }else{
            $valeurParticipant = '';
            $valeurMessage = '';
        }
        $res = "   
                    <br>
                    <div class=\"card\" style=\"width: 18rem;\">
                    <span class='border border-primary'>
                        <form method='POST' action=$url>
                            <button type='submit' name='deleteImg'>Supprimer</button>
                            </form>
                        <form method='POST' action=$urlAjoutImg enctype='multipart/form-data'>
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