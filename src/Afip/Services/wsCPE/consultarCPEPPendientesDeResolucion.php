<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Permite la consulta de CPE que se encuentran pendientes de resolución.
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class consultarCPEPPendientesDeResolucion extends baseMethod {

	public function run()
	{		
		$perfil = 'S'; // • S: Solicitante. • D: Destino.

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'perfil'       => $perfil
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarCPEPPendientesDeResolucion', $params);

			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->cartaPorte);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}