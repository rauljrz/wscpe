<?php
/**
 * AFIP - Web Service Factura Electronica
 * Consulta de último autorizado (FECompUltimoAutorizado)
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-18
 **/

class FECompUltimoAutorizado extends baseMethod {

	public function run($input)
	{		
		$params = array(
			'Auth' => array(
				'Token' => $this->ta->token,
				'Sign' => $this->ta->sign,
				'Cuit' => $this->cuit
			),
			'PtoVta' => $input['PtoVta'],
			'CbteTipo' => $input['CbteTipo']
		);

		try {
			$retrieved = parent::ExecuteRequest('FECompUltimoAutorizado', $params);

			return $this->processResponse($retrieved, 'FECompUltimoAutorizadoResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
