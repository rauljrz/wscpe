<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 *  Permite la consulta de CPE en calidad de destino para una planta y rango de fechas específicos.
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class consultarCPEPorDestino extends baseMethod {

	public function run()
	{		
		$planta = 520216; // 
		$planta = 2503;
		$fechaPartidaDesde = date('Y-m-d',strtotime('2021-10-07'));
		$fechaPartidaHasta = date('Y-m-d',strtotime('2021-10-10'));
		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'planta'     => $planta,
					'fechaPartidaDesde' => $fechaPartidaDesde,
					'fechaPartidaHasta' => $fechaPartidaHasta
				)
		);

		try {
			var_dump($params);
			$response = parent::ExecuteRequest('consultarCPEPorDestino', $params);
var_dump($response); die();
			if (isset($response->respuesta->errores)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->nroOrden);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}