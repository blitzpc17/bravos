<?php
    namespace App\Models;
    use \App\Models\VariableGlobal;
    use DB;
    class Utilidades{

        public static function MensajesValidacion(){
            $arrayMsj = array(
               'beetween' => 'El campo :attribute debe ser mayor a  :min y menor a :min.',
               'required' => 'El campo :attribute es obligatorio.', 
               'numeric'  => 'El campo :attrubute debe tener un valor décimales.',
               'string'   => 'El campo :attribute solo acepta letras.',
               'email'    => 'El campo :attribute solo acepta formato de correo electronico.',
               'size'     => 'El campo :attribute debe tener un tamaño de :size.',
               'min'      => 'El campo :attribute debe tener como mínimo :min cáracteres.',
               'max'      => 'El campo :attribute debe tener como máximo :max cáracteres.',
               'integer'  => 'El campo :attribute debe ser números enteros.',
               'string'   => 'El campo :attribute debe ser texto.'
            );
                return $arrayMsj;
        }

        public static function ObtenerVariableGlobal($nombre){
            $data = DB::table('variableglobal as glo')
                    ->where('nombre', $nombre)
                    ->select('contenido')
                    ->first();

            return \json_decode($data->contenido,true);
        }

        public static function ModificarContenidoVariableGlobal($nombre, $valor){
            VariableGlobal::where('nombre', $nombre)->update(["contenido"=>$valor]);
        }

        public static function ConvertirArrayToCollection($array){
            $list = collect($array)->map(function($item){
                return (object)$item;
            });

            return $list;
        }

        public static function ConvertirColeccionObjetosToArray($collection){
            $lstObjetos = [];
            foreach($collection as $item){
                $lstObjetos[] = (array)$item;
            }
            return $lstObjetos;
        }




    }


?>