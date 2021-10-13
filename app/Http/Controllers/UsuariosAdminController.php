<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use \App\Models\Empleado;
use \App\Models\Utilidades;
use \App\Models\Estado;
use \App\Models\Perfil;
use \App\Models\Admin;

class UsuariosAdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    public function index(){
        $user = Auth::user();
        $perfiles = Perfil::all();        
        $estados = Estado::ListarEstadoProceso(43);//cambiar como quede el catalogo
        return view('Backend.sistema.usuarios', compact('estados', 'perfiles', 'user'));
    }


    public function save(Request $r){
        try{
                $msjVal = Utilidades::MensajesValidacion();
                $niceNames = [
                    'alias'           =>  'Usuario',
                    'password'        =>  'Contraseña',
                    'perfil'          =>  'Perfil',
                    'empleado'        =>  'Empleado',
                    'estado'          =>  'Estado',              
                ]; 
                $rules = array(
                    'alias'           =>  'required|min:6',
                    'perfil'          =>  'required',
                    'estado'          =>  'required',
                    'empleado'        =>  'required',                
                );            

                $validator = Validator::make($r->all(), $rules, $msjVal, $niceNames);
                if(!$validator->passes()){
                    return response()->json(['code'=>"400", "Contenido"=>$validator->errors(), "msj"=>"Verifique que la información que ingreso sea correcta."]);
                }
                $password = "";
                
                if($r->iden==null)
                {
                    //validar al isnert si el empelado ya tiene usuario
                    if($r->password == null){
                        return response()->json(["code"=>400, "msj"=>"Debe ingresar una contraseña.","control"=>"password"]);
                    }
                    $tiene = Admin::ValidarTieneUsuario($r->empleado);
                    if($tiene){
                        return response()->json(["code"=>400, "msj"=>"El empleado ya tiene asignado un usuario."]);
                    }             
                }

                $valido = Admin::ValidarAlias($r->alias, $r->iden);
                if(!$valido){
                    return response()->json(["code"=>400, "msj"=>"El nombre de usuario que desea agregar ya esta en uso, genere otro."]);
                }

                $arrayData = array(
                    'alias'                 => \mb_strtoupper($r->alias),                    
                    'perfilusuarioadminid'  => $r->perfil,
                    'estadoprocesousuarioid'=> $r->estado,
                    'conectado'             => 0,
                    'empleadoid'            => $r->empleado,
                );
            
                if($r->iden==null)
                {
                    $arrayData = array_merge($arrayData,['password' => Hash::make(\mb_strtoupper($r->password))]);
                    $result = Admin::create($arrayData);
                }else{
                    if($r->password!=null){
                        $arrayData = array_merge($arrayData,['password' => Hash::make(\mb_strtoupper($r->password))]);
                    }
                    $result = Admin::where('id', $r->iden)->update($arrayData);
                }  

                return response()->json(['code'=>"200", "msj"=>"Registro guardado correctamente."]);



        }catch(\Exception $ex){
            dd($ex);
        }
    }

    public function ListarRegistros(){
        return response()->json(['data'=>Admin::ListarGeneral()]);
    }

    public function ObtenerRegistro($id){
        return response()->json(Admin::ObtenerRegistro($id));
    }
}
