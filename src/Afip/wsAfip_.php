<?php

namespace App\Afip;

class wsAfip {

    public function __construct($cuit){

    }

    public function consultarProvincias(){

        $provincias = array(
            array("codigo"=>20, "provincia"=>"tucuman"),
            array("codigo"=>21, "provincia"=>"mexico")
        );
        return $provincias;
    }

}
