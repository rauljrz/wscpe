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

class descargadoDestinoCPE extends baseMethod {

	public function run()
	{		
		$tipoCPE = 74; // 74: Automotor, 75: Ferroviaria, 76:Flete Corto
		$sucursal = 21;
		$nroOrden = 1;
		$cuitSolicitante = 27000000014; // 20111111112   27000000014

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cuitSolicitante' => $cuitSolicitante,
					'cartaPorte'      => array(
						'tipoCPE'        => $tipoCPE,
						'sucursal'       => $sucursal,
						'nroOrden'       => $nroOrden
					)
				)
		);

		try {
			$response = parent::ExecuteRequest('descargadoDestinoCPE', $params);
			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->localidad);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}