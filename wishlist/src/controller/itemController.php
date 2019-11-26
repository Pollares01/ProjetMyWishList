<?php

class itemController{

    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        echo($item);
    }
}