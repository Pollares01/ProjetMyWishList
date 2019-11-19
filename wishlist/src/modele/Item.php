<?php

namespace wishlist\modele;

class Item extends \Illuminate\Database\Eloquent\Model
{


    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public static function findById($id) {
        print ('afficher un item en particulier, dont l\'id est passé en paramêtre dans l\'url (test.php?id=1)' . '<br>');
        $liste = Item::where('id', '=', 1)->first();
        echo ($liste);
    }

    public function liste() {
        return $this->belongsTo('wishlist\modele\Liste','no');
    }

}