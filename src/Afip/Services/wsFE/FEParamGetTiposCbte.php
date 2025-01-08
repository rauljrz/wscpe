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

class FEParamGetTiposCbte extends baseMethod {

	public function run()
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
			$response = parent::ExecuteRequest('FEParamGetTiposCbte', $params);
			if (is_string($response)) throw new \Exception($response);

			if (!isset($response->FEParamGetTiposCbteResult)) throw new \Exception('No se recibio objeto con respuestas');

			$result = $response->FEParamGetTiposCbteResult;
			if (isset($result->Errors)) throw new \Exception($result->Errors->Err->Msg);
			
			return $this->processSuccess($result->ResultGet);
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
