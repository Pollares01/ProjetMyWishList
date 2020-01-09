<?php
namespace wishlist\vue;

class VueModificationListe extends VuePrincipale{

    private $liste,$lienAffichageListe;
    public function __construct($tabItems)
    {
        parent::__construct();
        $this->liste = $tabItems;
        $value = $this->liste;
        if($tabItems != null){
            $this->lienAffichageListe = self::getApp()->urlFor('afficher_une_liste_post',['token'=> $value->token]);
        }
    }

    public function modificationListe(){
        $value = $this->liste;
        if($value !=null){
            $valeurMessage = $value->description;
            $tokenModif = $value->tokenModif;
            $titre = $value->titre;
            $description = $value->description;
        }else{
            $tokenModif = '';
            $valeurMessage = '';
            $titre = '';
            $description = '';
        }
        $url = self::getApp()->urlFor('modification_une_liste',['tokenModif'=>$tokenModif]);
        $res = "
                <form class=\"form-horizontal\" method='post' action=$url>
<fieldset>
<!-- Form Name -->
<legend>Modification d'une liste</legend>

<!-- Textarea -->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"textarea\">Titre</label>
  <div class=\"col-md-4\">                     
    <textarea class=\"form-control\" id=\"textarea\" name=\"modifListe_titre\">$titre</textarea>
  </div>
</div>

<!-- Textarea -->
<div class=\"form-group\">
  <label class=\"col-md-4 control-label\" for=\"textarea\">Description : </label>
  <div class=\"col-md-4\">                     
    <textarea class=\"form-control\" id=\"textarea\" name=\"modifListe_description\">$description</textarea>
    <BR>
    <button type='submit' name='valider'>Valider</button>
  </div>
</div>
</fieldset>
</form>
</br>
<a href='$this->lienAffichageListe'>Retour à l'affichage de la liste</a>
        ";
        return $res;
    }




    public function render(){
        $menu = self::getMenu();
        $footer = self::getFooter();
        $content = self::modificationListe();
        $html = "
                $menu
                $content
                $footer";
        echo $html;
    }
}