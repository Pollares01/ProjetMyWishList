<?php

namespace wishlist\vue;

class VueParticipant3
{

    private $liste, $typeAff, $urlAfficherToutesListes, $urlAfficherItemsListe;

    public function __construct($tabItems, $typeAff) {
        $this->liste = $tabItems;
        $this->typeAff = $typeAff;

        $app =\Slim\Slim::getInstance() ;
        $itemUrl1 = $app->urlFor('afficher_toutes_listes') ;
        $this->urlAfficherToutesListes = $itemUrl1 ;

        $app =\Slim\Slim::getInstance() ;
        $itemUrl2 = $app->urlFor('afficher_items_dune_liste', ['no'=>1]) ;
        $this->urlAfficherItemsListe = $itemUrl2 ;
    }

    private function affichageGeneral() {
        $res = '';
        foreach ($this->liste as $value){
            $res = $res . $value . "<br>";
        }
        return "<p> liste de tout : </p> $res";
    }

    private function affichageItemUnique(){
        $res = '';
        foreach ($this->liste as $value){
            $res = $res . $value . "<br>";
        }
        return "<p> Items de la liste : </p> $res";
    }

    public function render(){
        $content = "";
        switch ($this->typeAff){
            case 'ALL_LISTE' : {
                $content = $this->affichageGeneral();
                break;
            }
            case 'ITEM_UNIQUE' : {
                $content = $this->affichageItemUnique();
                break;
            }
        }
        $html = <<< END
                <!DOCTYPE HTML>
                    <html>
                        <body>
                        <header>
                            <ul>
                                <li>
                                    <a href="$this->urlAfficherToutesListes">
                                        Affichage des listes 
                                    </a>
                                </li>
                                <li>
                                    <a href="$this->urlAfficherItemsListe">
                                        Affichage des items d'une liste
                                    </a>
                                </li>
                            </ul>
                        </header>
                            <div>
                                $content
                            </div>
                        </body>
                    </html>
                END;
        echo $html;

    }
}