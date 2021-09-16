<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PuestoBravos extends Model
{
    protected $table = 'puestobravos';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('puestobravos')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }

    
}
