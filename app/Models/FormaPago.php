<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FormaPago extends Model
{
    protected $table = 'formapago';
    protected $fillable= ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('formapago')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }

    
}
