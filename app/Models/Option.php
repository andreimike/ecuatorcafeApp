<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //table name
    protected $table = 'options';

    //primary key
    public $primaryKey = 'id';
    //Timestamps

    public $timestamps = false;

    protected $fillable = array('serial_number');
}