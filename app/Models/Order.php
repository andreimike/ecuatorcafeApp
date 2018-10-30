<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    public $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = array('order_number', 'contractor_ean_id', 'product', 'notice_number', 'notice', 'conformity_declaration', 'dpd_shipping', 'smart_bill_invoice', 'serial_number');

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'contractor_ean_id');
    }
}


