<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Perfil extends Model
{
    protected $table = 'perfilusuarioadmin';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('perfilusuarioadmin')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }

    
}
