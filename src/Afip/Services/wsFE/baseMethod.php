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