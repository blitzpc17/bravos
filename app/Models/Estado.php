<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Estado extends Model
{
    protected $table = 'estadoproceso';
    protected $fillable = ['nombre', 'procesoid'];
    public $timestamps = false;

    public static function Modificar($data, $id, $procesoId)
    {
        $result = DB::table('estadoproceso')
                    ->where('id', $id)
                   // ->where('procesoid', $procesoId)
                    ->update($data);
        return $result;
    }

    public static function ListarEstados(){
        return  DB::table('estadoproceso as edo')
                ->join('proceso as pro', 'edo.procesoid', 'pro.id')
                ->select('edo.id', 'edo.nombre', 'pro.id as ProcesoId', 'pro.nombre as NombreProceso')
                ->get();
    }

    public static function ObtenerEstado($idEstado, $idProceso){
        return DB::table('estadoproceso as edo')
                ->join('proceso as pro', 'edo.procesoid', 'pro.id')
                ->select('edo.id', 'edo.nombre', 'pro.id as ProcesoId', 'pro.nombre as NombreProceso')
                ->where('edo.id', $idEstado)
                ->where('pro.id', $idProceso)
                ->first();
    }
}
