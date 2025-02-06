<?php
/**
 * AFIP - Web Service Factura Electronica
 * FEParamGetCondicionIvaReceptor 
 *
 * @link https://www.afip.gob.ar/ws/documentacion/manuales/manual-desarrollador-ARCA-COMPG-v4-0.pdf 
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2025-02-06
 **/

class FEParamGetCondicionIvaReceptor extends baseMethod {

	public function run($input)
	{		
		// Auth params
		$params = array(
			'Auth' => array(
				'Token' => $this->ta->token,
				'Sign' => $this->ta->sign,
				'Cuit' => $this->cuit
			),
		);

		if (isset($input['clasecmp'])) {
			$params['ClaseCmp'] = $input['clasecmp'];
		}

		try {
			$retrieved = parent::ExecuteRequest('FEParamGetCondicionIvaReceptor', $params);

			return $this->processResponse($retrieved, 'FEParamGetCondicionIvaReceptorResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
