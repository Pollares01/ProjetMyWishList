<?php
namespace wishlist\controller;
use wishlist\modele\Item;
use wishlist\vue\VueCreerItem;
use wishlist\vue\VueParticipant3;

class ItemController{
    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueParticipant3($item,null,null, 'ITEM_ID');
        $vue->render();
    }

    public static function afficherToutItems(){
        $item = Item::get();
        $vue = new VueParticipant3($item,null,null, 'TOUT_ITEM');
        $vue->render();
    }

}
