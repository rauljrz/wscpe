<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 * 
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class consultarCPEAutomotor extends baseMethod {

	public function run($input)
	{		
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'sucursal' 		=> $input['sucursal'],
					'tipoCPE' 		=> $input['tipoCPE' ],
					'nroOrden'      => $input['nroOrden']
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarCPEAutomotor', $params);
			if (!isset($response->respuesta)){
				return $this->processSuccess($response->respuesta);
			}
			return $this->processError($response->respuesta->errores);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
