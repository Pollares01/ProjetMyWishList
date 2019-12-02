<?php
namespace wishlist\controller;
use wishlist\modele\Item;
use wishlist\vue\VueParticipant;

class ItemController{
    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        $vue = new VueParticipant($item, 'ITEM_ID');
        $vue->render();
    }
}
