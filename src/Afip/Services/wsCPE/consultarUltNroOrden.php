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

	public function run()
	{		
		$tipoCPE  = 74; // 74: Automotor, 75: Ferroviaria, 76:Flete Corto
		$sucursal = 1;

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'sucursal' 		=> $sucursal,
					'tipoCPE' 		=> $tipoCPE
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarUltNroOrden', $params);

			return $this->processSuccess($response->respuesta->nroOrden);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}