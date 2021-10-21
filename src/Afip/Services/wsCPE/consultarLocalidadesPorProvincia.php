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

class consultarLocalidadesPorProvincia extends baseMethod {

	public function run($codProvincia)
	{		
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
				'solicitud' => array(
					'codProvincia' 		=> $codProvincia
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarLocalidadesPorProvincia', $params);

			return $this->processSuccess($response->respuesta->localidad);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}