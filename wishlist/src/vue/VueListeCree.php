<?php
namespace wishlist\vue;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;
class VueListeCree extends VuePrincipale {
    
    private $url;
    private $liste;

    public function __construct($l) {
        parent::__construct();
        $this->liste = $l;
    }
    private function creationDeLaListe() {
      $tokenGenerated = $this->liste->token;
      $tokenModifGenerated = $this->liste->tokenModif;
        print "Vous avez créé une liste de titre : " . $this->liste->titre . ", de description : " . $this->liste->description . ", de date d'expiration : " . $this->liste->expiration;
        echo <<<END
        <h5>Token pour partager la liste</h5>
        <textarea  name='urlToken'>$tokenGenerated</textarea>
        <h5>Token pour modifier la liste</h5>
        <textarea  name='urlToken'>$tokenModifGenerated</textarea>
END;
    }


    public function render() {
        $menu = self::getMenu();
        $footer = self::getFooter();
        $html = <<<END
                $menu
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                            <div class="col-12 text-center">
                              
                           </div>
                    </div>
                </div>
                $footer
END ;
        echo $html;
        $this->creationDeLaListe();
    }
}