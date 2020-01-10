<?php
namespace wishlist\controller;
use wishlist\modele\Item;
use wishlist\vue\VueCreerItem;
use wishlist\vue\VueItem;
use wishlist\vue\VueParticipant3;

class ItemController{

    /**public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueParticipant3($item,null,null, 'ITEM_ID');
        $vue->render();
    }**/

    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueItem($item);
        $vue->render();
    }

    public static function afficherToutItems(){
        $item = Item::get();
        $vue = new VueParticipant3($item,null,null, 'TOUT_ITEM');
        $vue->render();
    }

    public static function modifierItem($id){
        $item = Item::where('id','=',$id)->first();
        if(isset($_POST['afficherItem_participant'])){
            $item->participant = $_POST['afficherItem_participant'];
        }
        if(isset($_POST['afficherItem_messageParticipant'])){
            $item->messageParticipant = $_POST['afficherItem_messageParticipant'];
        }
        $item->save();
        $vue = new VueItem($item);
        $vue->render();
    }
}
