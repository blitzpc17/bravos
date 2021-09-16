<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TipoServicioBravos extends Model
{
    protected $table = 'tiposerviciobravos';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('tiposerviciobravos')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }
}
