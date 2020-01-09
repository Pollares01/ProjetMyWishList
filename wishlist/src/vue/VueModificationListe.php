<?php
namespace wishlist\vue;

class   VueModificationListe extends VuePrincipale{

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
        if(isset($_POST['ajoutItem_Valider'])){
            $txt = "Votre item est ajouté !";
        } else {
            $txt = "fazfez";
        }
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
        $lien2 = self::getApp()->urlFor('ajouter_item_reussi', ['tokenModif' => $tokenModif]);
        $url = self::getApp()->urlFor('modification_une_liste',['tokenModif'=>$tokenModif]);
        $res = "
                <form class=\"form-horizontal\" method='post' action=$url>
<fieldset>
<!-- Form Name -->
<legend>Modification d'une liste</legend>

<!-- Textarea -->

<div class=\"container\">
  <div class=\"row\">
    <div class=\"col\">
        <div class=\"form - group\">
  <label class=\"col - md - 4 control - label\" for=\"textarea\">Titre *</label>
  <div class=\"col - md - 4\">                     
    <textarea class=\"form - control\" required id=\"textarea\" name=\"modifListe_titre\">$titre</textarea>
  </div>
</div>

<!-- Textarea -->
<div class=\"form - group\">
  <label class=\"col - md - 4 control - label\"  for=\"textarea\">Description : *</label>
  <div class=\"col - md - 4\">                     
    <textarea class=\"form - control\" required id=\"textarea\" name=\"modifListe_description\">$description</textarea>
    <BR>
    <button type='submit' name='valider'>Valider</button>
  </div>
</div>
</fieldset>
</form>
</br>
    </div>
    <div class=\"col\">
      <legend>
                                    Ajout d'items !
                                </legend>
                                
                                <form id=\"myForm\" method=\"post\" action=\"$lien2\" >
	<br>Nom *<br><input name=\"nom\" id=\"text1\" type=\"text\" required placeholder=\"Item personnalisé\" >
	<br>Description *<br><textarea name=\"desc\" id=\"textarea2\" cols=\"18\" rows=\"5\" required placeholder=\"Une rapide description\" ></textarea>
	<br>Prix *<br><input name=\"prix\" id=\"text3\" type=\"number\" required placeholder=\"15€\" >
	<br>Lien vers cet item<br><input name=\"url\" id=\"url4\" type=\"url\" >
	<br><br><input name=\"ajoutItem_Valider\" type=\"submit\" value=\"Valider\" >
</form>
$txt
    </div>
  </div>
</div>






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
                <div class=\"container h - 100\">
                    <div class=\"row h - 100 align - items - center\">
                           <div class=\"col - 12 text - center\">
                                $content
                           </div>
                    </div>
                </div>
                $footer";
        echo $html;
    }
}