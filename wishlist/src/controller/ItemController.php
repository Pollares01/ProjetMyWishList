<?php
namespace wishlist\controller;
use wishlist\modele\Item;


class ItemController{
    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        echo($item);
    }
}
