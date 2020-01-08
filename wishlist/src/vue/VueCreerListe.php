<?php

namespace wishlist\vue;

class VueCreerListe extends VuePrincipale {


    private $urlListeCree;

    public function __construct() {

        parent::__construct();

        $this->urlListeCree = self::getApp()->urlFor('liste_cree');

    }

    public function render() {
        $menu = self::getMenu();
        $foot = self::getFooter();
        $html = <<<END
                $menu
                
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                           <div class="col-12 text-center">
                           <form id="f1" method="post" action="$this->urlListeCree" enctype="multipart/form-data">
                           <div class="form-row">
                               <div class="col-md-4 mb-3">
                               <label for="validationServer01">Titre</label>
                               <input type="text" class="form-control is-valid" id="validationServer01" name="titre" placeHolder="Exemple : Pour fêter le bac !" required>
                               <div class="valid-feedback">
                               </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <label for="exampleFormControlTextarea1">Description</label>
                               <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description" placeHolder="Exemple : une belle description"required></textarea>
                           </div>
                           <div class="form-row">
                           <div class="col-md-4 mb-3">
                           <label for="validationServer01">Date d'expiration</label>
                           <input type="date" class="form-control is-valid" id="validationServer01" name="expiration" required>
                           <div class="valid-feedback">
                           </div>
                           </div>
                       </div>
                           <div class="form-group">
                           <label for="exampleFormControlFile1">Choisir une image depuis votre ordinateur</label>
                           <input type="file" class="form-control-file" id="exampleFormControlFile1" accept="test.png" name="image">
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
                           <button class="btn btn-primary" type="submit" name="creer">Créer</button>
                           </form>
                           </div>
                    </div>
                </div>
                $foot
        END ;
        echo $html;
    }
}