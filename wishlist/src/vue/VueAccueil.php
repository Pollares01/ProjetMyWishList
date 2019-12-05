<?php


namespace wishlist\vue;


class VueAccueil
{
    private $app,$URLbootstrapCSS,$URLbootstrapJS,$URLliste,$urlTousItem, $urlCSSperso, $urlPageIndex, $urlAfficherToutesListes,$urlITemID, $urlCreerListe;
    public function __construct(){
        $this->app =  \Slim\Slim::getInstance();

        $this->urlAfficherToutesListes = $this->app->urlFor('afficher_toutes_listes');

        $this->urlTousItem = $this->app->urlFor('afficher_tous_items');

        $this->urlPageIndex = $this->app->urlFor('page_index');

        $this->urlITemID = $this->app->urlFor('afficher_item_id', ['id'=>5]);

        $this->urlCreerListe = $this->app->urlFor('creer_liste');

        $this->urlCSSperso = $this->app->request->getRootUri() . '/public/css_perso.css';
        $this->URLbootstrapCSS = $this->app->request->getRootUri() . '/public/bootstrap.css';
        $this->URLbootstrapJS = $this->app->request->getRootUri() . '/public/boostrap.min.js';

    }

    public function render(){
        $html = /** @lang text */
            <<<END
<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="$this->URLbootstrapCSS">
    <link rel="stylesheet" href="$this->urlCSSperso ">
</head>
<body>
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
<header class="masthead">
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-center">
        <h1 style="color:white" class="font-weight-light">Bienvenue sur My Wish List !</h1>
        <p style="color:white" class="lead">Cliquez sur les boutons au dessus pour intéragir.</p>
      </div>
    </div>
  </div>
</header>


<section class="py-5">
  <div class="container">
    <h2 class="font-weight-light">Auteurs</h2>
    <p>CISTERNINO Enzo - TONDON César - KELBERT Paul</p>
  </div>
</section>

</body>
END;
        echo $html;
    }
}