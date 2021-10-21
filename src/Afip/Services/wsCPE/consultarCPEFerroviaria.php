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

class consultarCPEFerroviaria extends baseMethod {

	public function run()
	{		
				$tipoCPE = 75; // 74: Automotor, 75: Ferroviaria, 76:Flete Corto
		$sucursal = 21;
		$nroOrden = 1;
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
			$response = parent::ExecuteRequest('consultarCPEFerroviaria', $params);

			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->nroOrden);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}