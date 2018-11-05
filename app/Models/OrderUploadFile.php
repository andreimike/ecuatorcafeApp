<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUploadFile extends Model
{
    protected $table = 'orders_uploads_files';

    public $primaryKey = 'id';

    public $timestamps = 'true';

    public $fillable = array('orders_uploads_path', 'id_utilizator');
}
