<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proceso extends Model
{
    protected $table = 'proceso';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public static function Modificar($data, $id)
    {
        $result = DB::table('proceso')
                    ->where('id', $id)
                    ->update($data);
        return $result;
    }





}
