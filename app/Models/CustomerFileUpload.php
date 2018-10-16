<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFileUpload extends Model
{
    protected $table = 'upload_files';

    public $primaryKey = 'id';

    public $timestamps = 'true';

    public $fillable = array('cale_fisier', 'id_utilizator');

}
