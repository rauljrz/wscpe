<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Retorna el último número de orden de CPE autorizado según número de sucursal.
 * 
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class consultarUltNroOrden extends baseMethod {

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
					'tipoCPE' 		=> $input['tipoCPE' ]
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarUltNroOrden', $params);

			return $this->processSuccess($response->respuesta);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
