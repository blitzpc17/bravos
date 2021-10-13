<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;
use \App\Models\Empleado;
use \App\Models\Utilidades;
use \App\Models\TipoEmpleado;
use \App\Models\Estado;
use \App\Models\PuestoBravos;

class EmpleadosController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $user = Auth::user();
        $tipoEmpleados = TipoEmpleado::all();
        $estados = Estado::ListarEstadoProceso(29);//cambiar como quede el catalogo
        $puestos = PuestoBravos::all();
        return view('Backend.sistema.empleados', compact('tipoEmpleados', 'estados', 'puestos', 'user'));
    }


    public function save(Request $r){
        try{
            $urlLicencia = []; 
            $urlFoto='';
            $urlIne = [];
            $carpetaDestino = 'empleados/expedientes/';
            $clave='';
            

            $msjVal = Utilidades::MensajesValidacion();
            $niceNames = [
                'nombres'           =>  'Nombre(s)',
                'apellidos'         =>  'Apellidos',
                'telefono'          =>  'Télefono',
                'correo'            =>  'Correo',
                'dni'               =>  'DNI',
                'curp'              =>  'CURP',
                'docIne'            =>  'INE',
                'docFotografia'     =>  'FOTOGRAFÍA',
                'tipoEmpleado'      =>  'TIPO EMPLEADO',
                'estado'            =>  'ESTADO EMPLEADO',
                'puestos'           =>  'PUESTO',
                'estadoUbicacion'   =>  'ESTADO',
                'codigoPostal'      =>  'CÓDIGO POSTAL',
                'municipio'         =>  'MUNICIPIO',
                'localidad'         =>  'LOCALIDAD',
                'calle'             =>  'CALLE',
                'noext'             =>  'NO. Exterior',
                'colonia'           =>  'COLONIA'
            ]; 
            $rules = array(
                'nombres'           =>  'required',
                'apellidos'         =>  'required',
                'telefono'          =>  'required|integer|min:10',
                'correo'            =>  'required|email:rfc,dns',
                'dni'               =>  'required|max:13',
                'curp'              =>  'required|max:18',              
                'tipoEmpleado'      =>  'required',
                'estado'            =>  'required',
                'puestos'           =>  'required',
                'estadoUbicacion'   =>  'required',
                'codigoPostal'      =>  'required',
                'municipio'         =>  'required',
                'localidad'         =>  'required',
                'calle'             =>  'required',
                'noext'             =>  'required',
                'colonia'           =>  'required',
            );
             

            $validator = Validator::make($r->all(), $rules, $msjVal, $niceNames);
            if(!$validator->passes()){
                return response()->json(['code'=>"400", "Contenido"=>$validator->errors(), "msj"=>"Verifique que la información que ingreso sea correcta."]);
            }
            
            if(isset($r->claveRegistro)){
                //modificar
                $clave = $r->claveRegistro;
            }else{
                //insert
                $clave = Empleado::GenerarClave();
            }  
            $arrayData = array(
                'nombres'            => $r->nombres,
                'apellidos'          => $r->apellidos,
                'telefono'           => $r->telefono,
                'correo'             => $r->correo,
                'cp'                 => $r->codigoPostal,
                'estado'             => $r->estadoUbicacion,
                'calle'              => $r->calle,
                'noext'              => $r->noext,
                'noint'              => $r->noint,
                'colonia'            => $r->colonia,
                'municipio'          => $r->municipio,
                'localidad'          => $r->localidad,
                'dni'                => $r->dni,
                'curp'               => $r->curp,
                'tipoempleadoid'     => $r->tipoEmpleado,
                'estadoprocesoid'    => $r->estado,
                'puestobravosid'     => $r->puestos,

            );
            $carpetaDestino.="EMP_".$clave;

            
            if($r->file('docLicencia')!=null){
                $contadorCredenciales = 0;
                foreach($r->file('docLicencia') as $img){                    
                    $contadorCredenciales++;
                    $nombreArchivo =  $clave.'_licencia'.$contadorCredenciales.'.'.$img->extension();
                    $img->storeAs($carpetaDestino,$nombreArchivo, 'public');
                    array_push($urlLicencia, $nombreArchivo);
                }
            }else{
                $urlLicencia = ["SIN ARCHIVOS"];
            }
            if($r->file('docIne')!=null){
                $contadorCredenciales = 0;
                foreach($r->file('docIne') as $img){
                    $contadorCredenciales++;
                    $nombreArchivo =  $clave.'_ine'.$contadorCredenciales.'.'.$img->extension();
                    $img->storeAs($carpetaDestino, $nombreArchivo, 'public');
                    array_push($urlIne, $nombreArchivo);
                }
            }else{
                $urlIne = ["SIN ARCHIVOS"];
            }          
            if($r->file('docFotografia')!=null){
                $nombreFoto = $clave.'_foto'.'.'.$r->file('docFotografia')->getClientOriginalExtension();
                $r->file('docFotografia')->storeAs($carpetaDestino, $nombreFoto, 'public');
                
            }else{
                $nombreFoto = "SIN ARCHIVOS";
            }

                $urlLicencia = implode($urlLicencia,',');
                $urlFoto =  $nombreFoto;
                $urlIne = implode($urlIne, ',');


            //add clave e imagenes
            $arrayData = \array_merge($arrayData, ["clave"=>$clave, "urllicencia"=>$urlLicencia, "urlfotocara"=>$urlFoto, "urline"=>$urlIne]);
            if(isset($r->claveRegistro)){
                //modificar
                $result = Empleado::where('clave', $clave)->update($arrayData);
            }else{
                //insert
                $result = Empleado::create($arrayData);
            }   

            return response()->json(['code'=>"200", "msj"=>"Registro guardado correctamente."]);



        }catch(\Exception $ex){
            dd($ex);
        }
    }

    public function ListarRegistros(){
        return response()->json(['data'=>Empleado::ListarGeneral()]);
    }

    public function ObtenerRegistro($idEmpleado){
        return response()->json(Empleado::ObtenerEmpleado($idEmpleado));
    }

    public function ListarEmpleadosCbx(){
       return Empleado::ListarEmpleadosCbx();
    }
}
