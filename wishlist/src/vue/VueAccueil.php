<?php


namespace wishlist\vue;


class VueAccueil
{
    private $typeAff,$app,$URLbootstrapCSS,$URLbootstrapJS,$URLliste,$URLitem;
    public function __construct(){
        $this->app =  \Slim\Slim::getInstance();

        $itemURL1 =$this->app->urlFor('afficher_toutes_listes');
        $this->URLliste = $itemURL1;

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
</head>
<body>
<header>
    <ul>
        <li>
            <a href="$this->URLliste">
                Interface pour l'affichage des listes
            </a>                
        </li>
    </ul>
</header>
</body>
END;
        echo $html;
    }
}