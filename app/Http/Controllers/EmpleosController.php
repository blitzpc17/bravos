<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Empleos;
use \App\Models\Utilidades;
use Validator;
use Illuminate\Support\Facades\Log;

class EmpleosController extends Controller
{
    public function index(){
        return view('Backend.sistema.Empleos');
    }

    public function save(Request $r)
    {
        try{
            $msjVal = Utilidades::MensajesValidacion();
            $niceNames = [
                'nombre'  => 'Nombre',
            ]; 
            $rules = array(
                "nombre"  => 'required', 
            );            
            $validator = Validator::make($r->all(), $rules, $msjVal, $niceNames);
            if(!$validator->passes()){
                return response()->json(['code'=>"401", "Contenido"=>$validator->errors(), "msj"=>"Verifique que la información que ingreso sea correcta."]);
            }

            if($r->op=='I')
            {                
                $arrayData = array("nombre"=>$r->nombre);
                $result = Empleos::create($arrayData);
                if(isset($result->id)){
                    return response()->json(["code"=>200, "msj"=>"Registro guardado correctamente."]);
                }
            }else if($r->op=='M')
            {
                $data = array(
                    "nombre" => $r->nombre
                );
                $result = Empleos::Modificar($data ,$r->id);
                if($result==1){
                    return response()->json(["code"=>200, "msj"=>"Registro modificado correctamente."]);
                }else if($result>1){
                    throw new \ErrorException("Se modificarón varios registros con el mismo Id: ".$r->Id." en el modulo de Procesos.");
                }else{
                    return response()->json(["code"=>400, "msj"=>"Verifique que la información que ingreso sea correcta."]);
                }
            }else{
                return response()->json(["code"=>400, "msj"=>"Operación inválida."]);
            }
           

        }catch(\Exception $ex){
             Log::error(__CLASS__ . "::" . __METHOD__ . "  " . $ex->getMessage(). ". En la línea: ".$ex->getLine());
            return response()->json(["code"=>500, "msj"=>"Ocurrió un error interno en el sistema, vuelva a cargar la pagina e intentelo nuevamente."]);
        }
    }

    public function ListarRegistros(){
        return response()->json(["data"=>Empleos::all()]);
    }
    public function ObtenerRegistro($id){
        return Empleos::where('id', $id)->first();

    }
    public function EliminarRegistro($id){
        try{
            $result = Empleos::where('id', $id)->delete();
            if($result == 1){
                return response()->json(["code"=>200, "msj"=>"Registro eliminado correctamente."]);
            }else if($result < 1){
                return response()->json(["code"=>400, "msj"=>"No se encontro el registro a eliminar, intentelo nuevamente o vuelca a cargar la página."]);
            }else{
                throw new \ErrorException("Se modificarón varios registros con el mismo Id: ".$r->Id." en el modulo de Procesos.");
               
            }
        }catch(\Exception $ex){
            //guardar excepcion
            //retornar error al usuario
            Log::error(__CLASS__ . "::" . __METHOD__ . "  " . $ex->getMessage(). ". En la línea: ".$ex->getLine());
            return response()->json(["code"=>500, "msj"=>"Ocurrió un error interno en el sistema, vuelva a cargar la pagina e intentelo nuevamente."]);
        }
        
    }
}
