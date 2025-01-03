<?php
/**
 * AFIP - Web Service Factura Electronica
 * Dummy FE (FEDummy)
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-03
 **/

class FEDummy extends baseMethod {

	public function run()
	{		
		// Auth params
		$params = array(
			'auth' => array(
				'token' => $this->ta->token,
				'sign' => $this->ta->sign,
				'cuit' => $this->cuit
			)
		);

		try {
			$response = parent::ExecuteRequest('FEDummy', $params);
			if (is_string($response)) throw new \Exception($response);

			if (isset($response->respuesta)) return $this->processSuccess($response->respuesta);

			if (isset($response->oReturn->errores)) {
				return $this->processError($response->oReturn->errores);
			}
			return $this->processError($response);
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
