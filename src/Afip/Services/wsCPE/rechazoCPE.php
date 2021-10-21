<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Método para informar el rechazo de una carta de porte existente.
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class rechazoCPE extends baseMethod {

	public function run()
	{
		$tipoCPE  = 74; 
		$sucursal = 1; 
		$nroOrden = 1; 

		$cuitSolicitante = 20228065464;

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cuitSolicitante'   => $cuitSolicitante,
					'cartaPorte'        => array(
							'tipoCPE'       => $tipoCPE,
							'sucursal'      => $sucursal,
							'nroOrden'      => $nroOrden
					)
				)
		);

		try {
			$response = parent::ExecuteRequest('rechazoCPE', $params);

			if (isset($response->respuesta->errores->error)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->cartaPorte);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}