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

class consultarTiposGrano extends baseMethod {

	public function run()
	{		
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarTiposGrano', $params);

			return $this->processSuccess($response->respuesta->grano);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}