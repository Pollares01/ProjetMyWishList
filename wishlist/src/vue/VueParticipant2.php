<?php


namespace wishlist\vue;


use wishlist\modele\Liste;

class VueParticipant2
{
    private $liste;

    public function __construct($tabItems)
    {
        $this->liste = $tabItems;
    }

    public function render($num)
    {
        switch ($num) {
            case 1:
                $content = $this->affichageListeListesSouhaits();
                break;
            case 2:
                $content = $this->genererListeSouhaitItems();
                break;
            case 3:
                $content = $this->afficherItem();
                break;
        }
        $html = <<<END
<!DOCTYPE HTML>
<html>
<head></head>
<body>
<div class="content">
    $content
</div>
</body>
</html>
END;
        echo $html;
    }

    private function affichageListeListesSouhaits(): String
    {
        $content = "";
        foreach ($this->liste as $value){
            $content .= $value . "</br>";
        }
        return "Affichage de toutes les listes"."</br></br>".$content;
    }

    private function genererListeSouhaitItems(): String
    {
        $content = "";
        foreach
    }

    private function afficherItem():String{
        $content = $this->liste;
        return "Affichage de l'item demandé : ". "</br></br>" . $content;
    }
}