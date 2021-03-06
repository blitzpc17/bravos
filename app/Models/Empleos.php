<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Empleos extends Model
{
    protected $table = 'empleos';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('empleos')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }
}
