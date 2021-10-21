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

class regresoOrigenCPEAutomotor extends baseMethod {

	public function run()
	{		
		$tipoCPE  = 74; // 74: Automotor, 75: Ferroviaria, 76:Flete Corto
		$sucursal = 21;
		$nroOrden = 1;
		$cuitDestinatario     = 27000000014;
		$fechaHoraPartida= '2021-10-08T12:47:22';
		$kmRecorrer      = 10;

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cartaPorte'        => array(
							'tipoCPE'       => $tipoCPE,
							'sucursal'      => $sucursal,
							'nroOrden'      => $nroOrden
					),
					'destinatario'          => array(
							'cuit'             => $cuitDestinatario
					),
					'transporte'       => array(
							'fechaHoraPartida' => $fechaHoraPartida,
							'kmRecorrer'       => $kmRecorrer,
					) 
				)
		);

		try {
			$response = parent::ExecuteRequest('regresoOrigenCPEAutomotor', $params);

			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->cartaPorte);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}