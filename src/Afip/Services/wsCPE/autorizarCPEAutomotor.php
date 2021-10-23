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

	public function run($input)
	{		
		// cabecera
		$tipoCP               = $input['cabecera']['tipoCP'];
		$cuitSolicitante      = $input['cabecera']['cuitSolicitante'];
		$sucursal             = $input['cabecera']['sucursal'];
		$nroOrden             = $input['cabecera']['nroOrden'];
		// origen - operador
		$codProvinciaOperador = $input['solicitud']['origen']['operador']['codProvinciaOperador'];
		$codLocalidadOperador = $input['solicitud']['origen']['operador']['codLocalidadOperador'];
		$plantaOperador       = $input['solicitud']['origen']['operador']['plantaOperador'];
		//productor
		$codProvinciaProductor= $input['solicitud']['origen']['productor']['codProvinciaProductor'];
		$codLocalidadProductor= $input['solicitud']['origen']['productor']['codLocalidadProductor'];

		$correspondeRetiroProductor= $input['solicitud']['origen']['correspondeRetiroProductor'];
		$esSolicitanteCampo        = $input['solicitud']['origen']['esSolicitanteCampo'];
		// datosCarga
		$codGrano  = $input['solicitud']['datosCarga']['codGrano'];
		$cosecha   = $input['solicitud']['datosCarga']['cosecha'];
		$pesoBruto = $input['solicitud']['datosCarga']['pesoBruto'];
		$pesoTara  = $input['solicitud']['datosCarga']['pesoTara'];
		// destino
		$cuitDestino        = $input['solicitud']['destino']['cuitDestino'];
		$esDestinoCampo     = $input['solicitud']['destino']['esDestinoCampo'];
		$codProvinciaDestino= $input['solicitud']['destino']['codProvinciaDestino'];
		$codLocalidadDestino= $input['solicitud']['destino']['codLocalidadDestino'];
		$plantaDestino      = $input['solicitud']['destino']['plantaDestino'];
		// destinatario
		$cuitDestinatario  = $input['solicitud']['destinatario']['cuitDestinatario'];
		// transporte
		$cuitTransportista = $input['solicitud']['transporte']['cuitTransportista'];
		$dominio           = $input['solicitud']['transporte']['dominio'];
		$fechaHoraPartida  = $input['solicitud']['transporte']['fechaHoraPartida'];
		$kmRecorrer        = $input['solicitud']['transporte']['kmRecorrer'];
		$codigoTurno       = $input['solicitud']['transporte']['codigoTurno'];
		$cuitChofer        = $input['solicitud']['transporte']['cuitChofer'];
		$mercaderiaFumigada= $input['solicitud']['transporte']['mercaderiaFumigada'];

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
						'operador' => array(
							'codProvincia' => $codProvinciaOperador,
							'codLocalidad' => $codLocalidadOperador,
							'planta'       => $plantaOperador
						)
						//,
						// 'productor' => array(
						// 	'codProvincia' => $codProvinciaProductor,
						// 	'codLocalidad' => $codLocalidadProductor
						// )
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
						'codigoTurno'		=> $codigoTurno,
						'cuitChofer'        => $cuitChofer,
						'mercaderiaFumigada' => $mercaderiaFumigada
					)
				)
		);

		try {
			$response = parent::ExecuteRequest('autorizarCPEAutomotor', $params);
			if (!isset($response->respuesta)){
				return $this->processSuccess($response->respuesta);
			}
			//var_dump($response->respuesta->nroOrden); die();
			return $this->processError($response->respuesta->errores);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}

}
