<?php

namespace wishlist\controller;
use wishlist\index;
use wishlist\vue\VueListeCree;
use wishlist\modele\Liste;
use wishlist\modele\Item;
use wishlist\vue\VueImageAjout;
use wishlist\vue\VueCreerListe;

class FormulaireOKController
{
    public static function control(){
        if (isset($_POST['creer'])){
            $l = new Liste();
            //$target_file = 'img/';
            //move_uploaded_file($_FILES["image"]["tmp_name"], $target_file . $_FILES["image"]["name"]);
            $tokenGenerated = "";
            $token = openssl_random_pseudo_bytes(32);
            $token = bin2hex($token);
            $tokenGenerated = $token;
  
            $tokenModifGenerated = "";
            $tokenModif = openssl_random_pseudo_bytes(32);
            $tokenModif = bin2hex($tokenModif);
            $tokenModifGenerated = $tokenModif;
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $date =  $_POST['expiration'];
            $dateCourante = date("Y") . "-" . date("m") ."-" . date("d");
            if ($date < $dateCourante) {
                $vue =  new VueCreerListe("erreurDate");
                $vue->render();
            } else {
            $titre = filter_var($titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $titre = filter_var($titre, FILTER_SANITIZE_STRING);
            $description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $date = filter_var($date, FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_var($date, FILTER_SANITIZE_STRING);
            //$image = $_FILES['image']['name'];
            $l->titre = $titre;
            $l->description = $description;
            $l->expiration = $date;
            $l->user_id = null;
            $l->token = $tokenGenerated;
            $l->tokenModif = $tokenModifGenerated;
            $res = $l->save();
            $vue =  new VueListeCree($l);
            $vue->render();
            }
          }
        
    }

    public static function control3() {
        $vue = new VueImageAjout();
        $vue->render();
    }
}