<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    public $incrementing = false;

    public $primaryKey = "product_ean";

    public $timestamps = true;

    protected $fillable = array('product_ean', 'nume_produs', 'pret');

}
