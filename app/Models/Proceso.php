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

    public static function ListarProcesosTermino($term){
        $result = DB::table('proceso')
            ->where('nombre', 'like', '%'.$term.'%')
            ->select('proceso.id as id', 'proceso.nombre as text')
        //    ->tosql();
            ->get();

            return $result;

    }





}
