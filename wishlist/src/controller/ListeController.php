<?php
namespace wishlist\controller;
use wishlist\modele\Liste;
use Illuminate\Database\Capsule\Manager as DB;

$file = parse_ini_file('src/conf/conf.ini');
$db = new DB();
$db->addConnection($file);
$db->setAsGlobal();
$db->bootEloquent();

class ListeController
{
    public static function afficherListe()
    {
        $list = Liste::get();
        foreach ($list as $value) {
            echo $value;
            echo "<br>";
        }
    }

    public static function afficherItemDeListe($no)
    {
        $liste = Liste::where('no', '=', $no)->first();
        $items2 = $liste->items()->get();
        foreach ($items2 as $value) {
            echo($value);
            echo "<br>";
        }
    }
}