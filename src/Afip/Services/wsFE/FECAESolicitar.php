<?php
/**
 * AFIP - Web Service Factura Electronica
 * FECAESolicitar 
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-23
 **/

class FECAESolicitar extends baseMethod {

	public function run($input)
	{		
		// Auth params
		$params = array(
			'Auth' => array(
				'Token' => $this->ta->token,
				'Sign' => $this->ta->sign,
				'Cuit' => $this->cuit
			)
		);

		try {
			$retrieved = parent::ExecuteRequest('FECAESolicitar', $params);

			return $this->processResponse($retrieved, 'FECAESolicitarResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
