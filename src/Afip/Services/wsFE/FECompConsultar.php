<?php
/**
 * AFIP - Web Service Factura Electronica
 * Método  para consultar Comprobantes Emitidos y su código de autorización
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-18
 **/

class FECompConsultar extends baseMethod {

	public function run($input)
	{		
		$params = array(
			'Auth' => array(
				'Token' => $this->ta->token,
				'Sign' => $this->ta->sign,
				'Cuit' => $this->cuit
			),
			'FeCompConsReq' => array(
				'CbteTipo' => $input['CbteTipo'],
				'CbteNro' => $input['CbteNro'],
				'PtoVta' => $input['PtoVta']
			)
		);
		
		try {
			$retrieved = parent::ExecuteRequest('FECompConsultar', $params);

			return $this->processResponse($retrieved, 'FECompConsultarResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
