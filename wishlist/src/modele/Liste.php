<?php


namespace wishlist\modele;


class Liste extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamp = false;

    public function items() {
        return $this->hasMany('wishlist\modele\Item','id');
    }
}