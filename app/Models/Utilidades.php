<?php
    namespace App\Models;
    class Utilidades{
        public static function MensajesValidacion(){
            $arrayMsj = array(
                'beetween' => 'El campo :attribute debe ser mayor a  :min y menor a :min.',
                'required' => 'El campo :attribute es obligatorio.' 
            );
            return $arrayMsj;
        }

    }


?>