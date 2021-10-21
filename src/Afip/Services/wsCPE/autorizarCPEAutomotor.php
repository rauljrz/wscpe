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

class autorizarCPEAutomotor extends baseMethod {

	public function run()
	{		
		// cabecera
		$tipoCP               = 74; // 74: Automotor, 75: Ferroviaria, 76: (274)Flete Corto
		$cuitSolicitante      = 20111111112;
		$sucursal             = 212;
		$nroOrden             = 5;
		// origen - operador
		$codProvinciaOperador = 5;
		$codLocalidadOperador = 287;
		$plantaOperador       = 202770;
		//productor
		$codProvinciaProductor= 1;
		$codLocalidadProductor= 1069;

		$correspondeRetiroProductor= 0;
		$esSolicitanteCampo        = 1;
		// datosCarga
		$codGrano  = 23;
		$cosecha   = 2021;
		$pesoBruto = 1520;
		$pesoTara  = 123;
		// destino
		$cuitDestino        = 27000000014;
		$esDestinoCampo     = 0;
		$codProvinciaDestino= 5;
		$codLocalidadDestino= 287;
		$plantaDestino      = 1782;
		// destinatario
		$cuitDestinatario  = 27000000014;
		// transporte
		$cuitTransportista = 20120372913;
		$dominio           = 'HO014EX';
//		$fechaHoraPartida  = '2021-09-03T12:47:22';
		$fechaHoraPartida  = '2021-10-19T13:47:22';
		$kmRecorrer        = 1003;
		$cuitChofer        = 20120372913;
		$mercaderiaFumigada= 1;

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cabecera' => array(
						'tipoCP'          => $tipoCP,
						'cuitSolicitante' => $cuitSolicitante,
						'sucursal'        => $sucursal,
						'nroOrden'        => $nroOrden
					),
					'origen' => array(
						// 'operador' => array(
						// 	'codProvincia' => $codProvinciaOperador,
						// 	'codLocalidad' => $codLocalidadOperador,
						// 	'planta'       => $plantaOperador
						// ),
						'productor' => array(
							'codProvincia' => $codProvinciaProductor,
							'codLocalidad' => $codLocalidadProductor
						)
					),
					'correspondeRetiroProductor' => $correspondeRetiroProductor,
					'esSolicitanteCampo' 		 => $esSolicitanteCampo,
					// 'retiroProductor' => array(
					// 	'certificadoCOE' => $certificadoCOE,
					// 	'cuitRemitenteComercialProductor' => $cuitRemitenteComercialProductor
					// ),
					// 'intervinientes' => array(
					// 	'cuitRemitenteComercialVentaPrimaria' => $cuitRemitenteComercialVentaPrimaria,
					// 	'cuitRemitenteComercialVentaSecundaria' => $cuitRemitenteComercialVentaSecundaria,
					// 	'cuitRemitenteComercialVentaSecundaria2' => $cuitRemitenteComercialVentaSecundaria2,

					// )
					'datosCarga' => array(
						'codGrano'  => $codGrano,
						'cosecha'   => $cosecha,
						'pesoBruto' => $pesoBruto,
						'pesoTara'  => $pesoTara
					),
					'destino' => array(
						'cuit' => $cuitDestino,
						'esDestinoCampo' => $esDestinoCampo,
						'codProvincia'   => $codProvinciaDestino,
						'codLocalidad'   => $codLocalidadDestino,
						'planta'         => $plantaDestino
					),
					'destinatario' => array(
						'cuit' => $cuitDestinatario
					),
					'transporte' => array(
						'cuitTransportista' => $cuitTransportista,
						'dominio'           => $dominio,
						'fechaHoraPartida'  => $fechaHoraPartida,
						'kmRecorrer'        => $kmRecorrer,
						'cuitChofer'        => $cuitChofer,
						'mercaderiaFumigada' => $mercaderiaFumigada
					)
				)
		);

		try {
			$response = parent::ExecuteRequest('autorizarCPEAutomotor', $params);
			//var_dump($response);
			if (!isset($response->respuesta->nroCTG)){
				return $this->processSuccess($response->respuesta);
			}
			//var_dump($response->respuesta->nroOrden); die();
			return $this->processError($response->respuesta->errores);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}

}