<?php

namespace wishlist\vue;

class VueCreerListe {
    
    private $urlAfficherToutesListes, $urlAfficherItemsListe, $urlTousItem, $urlITemID, $urlCreerListe, $urlPageIndex;

    public function __construct() {

        $this->app =  \Slim\Slim::getInstance() ;

        $itemUrl1 =$this->app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;

        $itemUrl2 = $this->app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;

        $itemUrl3 = $this->app->urlFor('afficher_tous_items');
        $this->urlTousItem = $itemUrl3;

        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);

        $itemUrl4 = $this->app->urlFor('creer_liste');
        $this->urlCreerListe = $itemUrl4;

        $this->urlPageIndex = $this->app->urlFor('page_index');

        $this->URLimages = $this->app->request->getRootUri() . '/img/';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';
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
                           <form>
                           <div class="form-row">
                               <div class="col-md-4 mb-3">
                               <label for="validationServer01">Titre</label>
                               <input type="text" class="form-control is-valid" id="validationServer01" value="Exemple : Pour fêter le bac !" required>
                               <div class="valid-feedback">
                                   Cela semble bon!
                               </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <label for="exampleFormControlTextarea1">Description</label>
                               <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" value="ex" required></textarea>
                           </div>
                           <div class="form-group">
                           <label for="exampleFormControlFile1">Choisir une image depuis votre ordinateur</label>
                           <input type="file" class="form-control-file" id="exampleFormControlFile1">
                           </div>
                           <div class="form-group">
                               <div class="form-check">
                               <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
                               <label class="form-check-label" for="invalidCheck3">
                                   Accepter les termes et conditions
                               </label>
                               <div class="invalid-feedback">
                               Vous devez accepter avant de soumettre.
                               </div>
                               </div>
                           </div>
                           <button class="btn btn-primary" type="submit">Créer</button>
                           </form>
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