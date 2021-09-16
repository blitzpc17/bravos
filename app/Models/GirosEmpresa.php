<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GirosEmpresa extends Model
{
    protected $table = 'giroempresa';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('giroempresa')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }

   
}
