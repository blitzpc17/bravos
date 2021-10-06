<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Utilidades;
use DB;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $fillable = [
        'clave',
        'nombres',
        'apellidos',
        'telefono',
        'correo',
        'cp',
        'estado',
        'calle',
        'noext',
        'noint',
        'colonia',
        'municipio',
        'localidad',
        'dni',
        'curp',
        'urline',
        'urlfotocara',
        'urllicencia',
        'tipoempleadoid',
        'estadoprocesoid',
        'puestobravosid'
    ];

    public static function GenerarClave(){
        return DB::transaction(function ()  {
            $data = Utilidades::ConvertirArrayToCollection(Utilidades::ObtenerVariableGlobal("AcumuladorEmpleados"));
            $clave = "00000";            
            $contadorActual = $data[0]->Contador++; 
            $clave = str_pad($contadorActual, 5,'0', STR_PAD_LEFT);
            $data = \json_encode(Utilidades::ConvertirColeccionObjetosToArray($data));
            Utilidades::ModificarContenidoVariableGlobal("AcumuladorEmpleados",$data);            
            return $clave;            
        });
    }

    public static function ListarGeneral(){
        return DB::table('empleado as emp')
            ->join('puestobravos as pue', 'emp.puestobravosid','pue.id')
            ->join('estadoproceso as edo','emp.estadoprocesoid','edo.id')
            ->select(DB::raw("(emp.nombres||' '||emp.apellidos) as Nombre"), 'pue.nombre as puesto', 'edo.nombre as estado', 'emp.id', 'emp.clave')
            ->get();
    }
    public static function ObtenerEmpleado($id){
        $data = DB::table('empleado')
                ->where('id', $id)
                ->first();
        return $data;
    }
}
