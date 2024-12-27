<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 * 
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class consultarCPEAutomotorDG extends baseMethod {

	public function run($input)
	{
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cuitSolicitante' 		=> $input['cuitSolicitante'],
					'nroCTG' 		=> $input['nroCTG' ]
				)
		);
		try {
			$response = parent::ExecuteRequest('consultarCPEAutomotorDG', $params);

			if (isset($response->respuesta->pdf)){
                $response->respuesta->pdf = base64_encode($response->respuesta->pdf);

				return $this->processSuccess($response->respuesta);
			}

			return $this->processError($response->respuesta);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
