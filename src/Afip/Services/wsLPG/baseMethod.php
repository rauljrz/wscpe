<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 * 
 * @link 
 *
 * @author  http://rauljrz.me	
 * @package wsLpgService 
 * @version 1.0
 **/

class baseMethod extends AfipWebService {

	var $soap_version = SOAP_1_1;
    var $WSDL 		  = 'ws_lpg-production.wsdl';
	var $URL 		  = 'https://serviciosjava.afip.gob.ar/wslpg/LpgService';
	var $WSDL_TEST 	  = 'ws_lpg.wsdl';
	var $URL_TEST 	  = 'https://fwshomo.afip.gov.ar/wslpg/LpgService';

    var $ta  = null;
    var $cuit= null;
    
    function __construct($params)
    {
        parent::__construct($params);
        $this->ta  = $this->afip->GetServiceTA('wslpg');
        $this->cuit= $this->afip->CUIT;
    }

    protected function processSuccess($message)
    {
        if (isset($message) && empty($message) && !is_int($message)) {
            return $this->jsonResponse('error', 'No se recibio datos', 201);
        }
        return $this->jsonResponse('success', $message, 200);
    }

    protected function processError($message)
    {
        return $this->jsonResponse('error', $message, 511);
    }

    protected function jsonResponse(string $status, $message, int $code)
    {
        return $message;
    }

}
