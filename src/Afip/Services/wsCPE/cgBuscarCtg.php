<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Buscar CTG a certificar (cgBuscarCtg)
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class cgBuscarCtg extends baseMethod {

	public function run($input)
	{		
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'tipoCertificado' => $input['tipoCertificado'],
			'cuitDepositante' => $input['cuitDepositante'],
			'nroPlanta'       => $input['nroPlanta'],
			'codGrano'        => $input['codGrano'],
			'campania'        => $input['campania']
		);

		try {
			$response = parent::ExecuteRequest('cgBuscarCtg', $params);

			if (isset($response->respuesta)){
			    return $this->processSuccess($response->respuesta);
			}
			return $this->processError($response);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
