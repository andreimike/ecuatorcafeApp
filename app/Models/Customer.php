<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //table name
    protected $table = 'customers';
    //primary key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = array('nume', 'adresa', 'iln', 'cui');

}
