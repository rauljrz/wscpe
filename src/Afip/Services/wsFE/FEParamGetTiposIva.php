<?php
/**
 * AFIP - Web Service Factura Electronica
 * FEParamGetTiposIva
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-23
 **/

class FEParamGetTiposIva extends baseMethod {

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
			$retrieved = parent::ExecuteRequest('FEParamGetTiposIva', $params);

			return $this->processResponse($retrieved, 'FEParamGetTiposIvaResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
