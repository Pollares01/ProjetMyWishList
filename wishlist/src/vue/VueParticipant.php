<?php
namespace wishlist\vue;
class VueParticipant {

    private $content;
    private $selecteur;

    public function __construct($tab, $sel) {
        $this->content = $tab;
        $this->selecteur = $sel;
    }

    private function affichageListeListesSouhaits() {
        $this->content = "<p> Liste de listes de souhaits : </br> $this->content </p>";
    }

    private function genererListeSouhaitItems() {
        $this->content = "<p> Items de la liste de souhait selon un id : </br> $this->content </p>";
    }

    private function itemById() {
        $this->content = "<p> Affichage d'un item selon un id : </br> $this->content </p>";
    }

    public function render() {
       switch($this->selecteur) {
            case 'LIST_LISTE_SOUHAITS' : {
                $this->affichageListeListesSouhaits();
            break;
            }
            case 'LIST_LISTE_SOUHAITS_ITEMS' : {
                $this->genererListeSouhaitItems();
            break;
            }
            case 'ITEM_ID' : {
                $this->itemById();
            }
        }
$html = <<<END
<!DOCTYPE html>
<html>
<head> … </head>
<body>
…
    <div class="content">
        $this->content
    </div>
</body><html>
END ;
echo $html;
    }
}