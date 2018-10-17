<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //table name
    protected $table = 'customers';
    //Set PK to not auto incrementing
    public $incrementing = false;
    //primary key
    public $primaryKey = 'contractor_ean';
    //Timestamps
    public $timestamps = true;

    protected $fillable = array('contractor_ean', 'nume', 'adresa', 'iln', 'cui');

}
