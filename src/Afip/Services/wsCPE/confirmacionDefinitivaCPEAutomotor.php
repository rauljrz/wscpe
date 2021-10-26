<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Método para informar el nuevo destino / destinatario de una carta de porte existente.
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class confirmacionDefinitivaCPEAutomotor extends baseMethod {

	public function run($input)
	{		
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cuitSolicitante'   => $input['cuitSolicitante'],
					'cartaPorte'        => array(
							'tipoCPE'       => $input['tipoCPE' ],
							'sucursal'      => $input['sucursal'],
							'nroOrden'      => $input['nroOrden']
					),
					'pesoBrutoDescarga' => $input['pesoBrutoDescarga'],
					'pesoTaraDescarga'  => $input['pesoTaraDescarga' ]
				)
		);

		try {
			$response = parent::ExecuteRequest('confirmacionDefinitivaCPEAutomotor', $params);

			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->cartaPorte);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
