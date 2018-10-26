<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //table name
    protected $table = 'options';
    //Set PK to not auto incrementing
    //primary key
    public $primaryKey = 'id';
    //Timestamps

    public $timestamps = true;

    protected $fillable = array('order_id', 'serial_number', 'order_serial_number');

//    public function order()
//    {
//
//        return $this->hasOne('App\Models\Order', 'contractor_ean_id', 'contractor_ean');
//    }
}