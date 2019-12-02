<?php

class VueParticipant {

    public function __construct(array $tabItems,array $tabListes) {
        foreach($tabItems as $values) {
            echo($values);
        }

        foreach($tabListes as $values) {
            echo($values);
        }
    }

    private function affichageListeListesSouhaits() {

    }

    private function genererListeSouhaitItems() {

    }

    private function affichageGeneral() {

    }
}