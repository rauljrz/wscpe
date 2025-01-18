<?php
/**
 * AFIP - Web Service Factura Electronica (wsfe)
 * 
 * @link 
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 **/

class baseMethod extends AfipWebService {

	var $soap_version = SOAP_1_1;
    var $WSDL 		  = 'wsfe-production.wsdl';
	var $URL 		  = 'https://servicios1.afip.gov.ar/wsfev1/service.asmx';
	var $WSDL_TEST 	  = 'wsfe.wsdl';
	var $URL_TEST 	  = 'https://wswhomo.afip.gov.ar/wsfev1/service.asmx';

    var $ta  = null;
    var $cuit= null;
    
    function __construct($params)
    {
        parent::__construct($params);
        $this->ta  = $this->afip->GetServiceTA('wsfe');
        $this->cuit= $this->afip->CUIT;
    }

    protected function processResponse($retrieved, string $metodo)
    {
        
        if (!isset($retrieved->$metodo))
            return $this->processError('Respuesta inválida del servicio');

        $object = $retrieved->$metodo;

        if (isset($object->errores)) {
            $error = [
                'codigo' => is_array($object->errores) 
                    ? $object->errores[0]->codigo
                    : $object->errores->error->codigo,
                'descripcion' => is_array($object->errores)
                    ? $object->errores[0]->descripcion
                    : $object->errores->error->descripcion
            ];
            
            return $this->processError(['error' => $error]);
        }

        return $this->processSuccess($object->ResultGet);
    }
    protected function processSuccess($message)
    {
        if (!isset($message) || (empty($message) && !is_numeric($message)))
            return $this->processError('No se recibieron datos');
        
        return [
            'status' => 'success',
            'data' => $message
        ];
    }

    protected function processError($message)
    {
        return [
            'status' => 'error',
            'message' => $message
        ];
    }
}