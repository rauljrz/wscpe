<?php
/**
 * AFIP - Web Service Liquidacion Primaria de Grano (ws LpgService)
 *
 * Consultar el último número de orden registrado de una certificación (cgConsultarUltimoNroOrden)
 *
 * Método que retorna el identificador (Nº de Orden) de la última certificación enviada y
 * autorizada para la CUIT (<auth><cuit>) y el punto de emisión indicado en el requerimiento.
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsLPG
 * @version 1.0
 * @date 2024-05-20
 **/

class cgConsultarUltimoNroOrden extends baseMethod {
	public function run($input)
	{		
		$params = array(
			'auth' => array(
					'token' => $this->ta->token,
					'sign' 	=> $this->ta->sign,
					'cuit' 	=> $this->cuit
				),
			'ptoEmision' => $input['ptoEmision']
		);

		try {
			$retrieved = parent::ExecuteRequest('cgConsultarUltimoNroOrden', $params);

			return $this->processResponse($retrieved);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
