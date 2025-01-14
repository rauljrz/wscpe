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

    protected function processResponse($retrieved)
    {
        if (!isset($retrieved->oReturn) && !isset($retrieved->liqUltNroOrdenReturn))
            return $this->processError('Respuesta inválida del servicio', 502);

        $oReturn = $retrieved->oReturn ?? $retrieved->liqUltNroOrdenReturn;

        if (isset($oReturn->errores)) {
            $error = [
                'codigo' => is_array($oReturn->errores) 
                    ? $oReturn->errores[0]->codigo
                    : $oReturn->errores->error->codigo,
                'descripcion' => is_array($oReturn->errores)
                    ? $oReturn->errores[0]->descripcion
                    : $oReturn->errores->error->descripcion
            ];
            
            return $this->processError(['error' => $error], 422);
        }

        return $this->processSuccess($oReturn);
    }

    protected function processSuccess($message)
    {
        if (!isset($message) || (empty($message) && !is_numeric($message)))
            return $this->processError('No se recibieron datos', 204);
        
        return [
            'status' => 'success',
            'data' => $message,
            'code' => 200
        ];
    }

    protected function processError($message, $code = 500)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'code' => $code
        ];
    }

}
