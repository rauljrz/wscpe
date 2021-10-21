<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Permite la consulta de plantas activas.
 * 
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class consultarPlantas extends baseMethod {

	public function run()
	{		
		$cuitSolicitante = 20111111112; // 27000000014 - 20111111112 - 20111111112

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cuit'     => $cuitSolicitante
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarPlantas', $params);

			if (isset($response->respuesta->errores->error)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->planta);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}