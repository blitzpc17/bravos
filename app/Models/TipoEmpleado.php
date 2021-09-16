<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TipoEmpleado extends Model
{
    protected $table = 'tipoempleado';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('tipoempleado')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }

    
}
