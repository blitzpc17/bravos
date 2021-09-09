<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleos extends Model
{
    protected $table = 'ocupacion';
    protected $fillable= ['nombre'];
    public $timestamps = false;
}
