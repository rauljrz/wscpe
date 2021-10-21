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

	public function run()
	{		
		$tipoCPE = 74; // 74: Automotor, 75: Ferroviaria, 76:Flete Corto
		$sucursal = 212;
		$nroOrden = 2;
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'tipoCPE'       => $tipoCPE,
					'sucursal'      => $sucursal,
					'nroOrden'      => $nroOrden
				)
		);

		try {
			$response = parent::ExecuteRequest('consultarCPEAutomotor', $params);
var_dump($response);
			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->cartaPorte);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}