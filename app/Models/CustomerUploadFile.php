<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerUploadFile extends Model
{
    protected $table = 'customers_uploads_files';

    public $primaryKey = 'id';

    public $timestamps = 'true';

    public $fillable = array('customers_uploads_path', 'id_utilizator');

}
