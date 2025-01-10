<?php
/**
 * AFIP - Web Service Liquidacion Primaria de Grano (ws LpgService)
 *
 * Buscar CTG a certificar (cgBuscarCtg)
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class cgConsultarXCoe extends baseMethod {

	public function run($input)
	{		
		$params = array(
			'auth' => array(
					'token' => $this->ta->token,
					'sign' 	=> $this->ta->sign,
					'cuit' 	=> $this->cuit
				),
			'coe' => $input['coe']
		);

		try {
			$response = parent::ExecuteRequest('cgConsultarXCoe', $params);

			return $this->processResponse($response);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
