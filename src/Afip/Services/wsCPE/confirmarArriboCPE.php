<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Método para informe de contingencia de una CPE existente
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class confirmarArriboCPE extends baseMethod {

	public function run($input)
	{
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cuitSolicitante'   => $input['cuitSolicitante'],
					'cartaPorte'        => array(
							'tipoCPE'       => $input['tipoCPE'],
							'sucursal'      => $input['sucursal'],
							'nroOrden'      => $input['nroOrden']
					)
				)
		);

		try {
			$response = parent::ExecuteRequest('confirmarArriboCPE', $params);

			if (isset($response->respuesta)){
			    return $this->processSuccess($response->respuesta);
			}
			return $this->processError($response);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
