<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * El método dummy verifica el estado y la disponibilidad de los 
 * elementos principales del servicio (aplicación, autenticación y base de datos).
 * 
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class dummy extends baseMethod {

	public function run()
	{		
		$params = array(
			'token' 			=> $this->ta->token,
			'sign' 				=> $this->ta->sign,
			'cuitRepresentada' 	=> $this->cuit
		);

		try {
			$response = parent::ExecuteRequest('dummy', $params);

			return $this->processSuccess($response->respuesta);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}