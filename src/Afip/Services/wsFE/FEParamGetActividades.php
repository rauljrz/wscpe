<?php
/**
 * AFIP - Web Service Factura Electronica
 * FEParamGetActividades
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-18
 **/

class FEParamGetActividades extends baseMethod {

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
			$retrieved = parent::ExecuteRequest('FEParamGetActividades', $params);

			return $this->processResponse($retrieved, 'FEParamGetActividadesResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
