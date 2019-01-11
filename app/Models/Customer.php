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

    protected $fillable = array('contractor_ean', 'nume', 'adresa', 'cod_postal', 'localitate', 'judet', 'tara', 'iln', 'cui', 'reg_com', 'banca', 'iban', 'pers_contact', 'email', 'telefon', 'observatii');

    public function order()
    {

        return $this->hasOne('App\Models\Order', 'contractor_ean_id', 'contractor_ean');
    }

}
