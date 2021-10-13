<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'alias', 'password', 'estadoprocesousuarioid', 'conectado', 'empleadoid', 'perfilusuarioadminid'
    ];


    protected $hidden = [
        'password'
    ];

    public static function ListarGeneral(){
        return $table =   DB::table('admins as us')
                            ->join('empleado as emp', 'us.empleadoid', 'emp.id')
                            ->join('estadoproceso as edo', 'us.estadoprocesousuarioid', 'edo.id')
                            ->join('perfilusuarioadmin as per', 'us.perfilusuarioadminid', 'per.id')
                            ->select('us.id','emp.clave', DB::raw("(emp.nombres||' '||emp.apellidos) as Nombre"), 'us.alias', 'per.nombre as perfil', 'edo.nombre as estado')
                            ->orderbydesc('us.id')
                            ->get();

    }
    public static function ValidarAlias($alias,$idUsuario){
        $data = Admin::where('alias',$alias)->first();
        if($idUsuario==null){
            //cuando es nuevo us
            if(isset($data->id)){
                return false;
            }
        }else{
            //cuando es modif
            if(isset($data->id)){
                if($data->id==$idUsuario){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        return true;
    }

    public static function ValidarTieneUsuario($idEmpleado){
        $result = DB::table('empleado as emp')
            ->join('admins as us', 'emp.id', 'us.empleadoid')
            ->where('emp.id', $idEmpleado)
            ->first();
        if($result == null){
            return false;
        }
        return true;
    }

    public static function ObtenerRegistro($idUsuario){
        return Admin::where('id', $idUsuario)
                ->select('id','alias', 'estadoprocesousuarioid', 'conectado', 'empleadoid', 'perfilusuarioadminid')
                ->first();
    }

}
