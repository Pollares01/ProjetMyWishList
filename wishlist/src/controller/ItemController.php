<?php
namespace wishlist\controller;
use wishlist\modele\Item;
use Illuminate\Database\Capsule\Manager as DB;

$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();

class ItemController{
    public static function afficherItemID($id){
        $item = Item::where("id" , "=" , $id)->first();
        echo($item);
    }
}
