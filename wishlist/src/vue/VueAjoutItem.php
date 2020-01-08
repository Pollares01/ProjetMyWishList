<?php


namespace wishlist\vue;


class VueAjoutItem extends VuePrincipale
{

    private $typeAff;

    public function __construct($typeAff) {
        parent::__construct();
        $this->typeAff = $typeAff;
    }


    /**
     * fonction utilisée pour le rendu des vues
     */
    public function render(){
        switch ($this->typeAff){
            //cas où l'on veut afficher toutes les listes
            case 'ajout' : {

                $content = $this->ajoutDitem();
                break;
            }
        }
        $menu = self::getMenu();
        $foot = self::getFooter();
        $html = <<<END
                $menu
                </header>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                           <div class="col-12 text-center">
                                $content
                           </div>
                    </div>
                </div>  
                $foot
        END ;
        echo $html;
    }

    private function ajoutDitem()
    {
        return $_POST['nom'] . "           ". $_POST['desc'] . "           "  . $_POST['prix'] . "            " . $_POST['url'] . "a bien été ajouté !";
    }

}