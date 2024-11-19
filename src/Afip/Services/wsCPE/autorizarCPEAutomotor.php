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
		$correspondeRetiroProductor= $input['solicitud']['origen']['correspondeRetiroProductor'];
		$esSolicitanteCampo        = $input['solicitud']['origen']['esSolicitanteCampo'];
        //retiroProductor
        $cuitRemitenteComercialProductor = $input['solicitud']['retiroProductor']['cuitRemitenteComercialProductor'];
        $cuitRemitenteComercialVentaPrimaria = $input['solicitud']['intervinientes']['cuitRemitenteComercialVentaPrimaria'];
        $cuitRemitenteComercialVentaSecundaria= $input['solicitud']['intervinientes']['cuitRemitenteComercialVentaSecundaria'];
        $cuitRemitenteComercialVentaSecundaria2= $input['solicitud']['intervinientes']['cuitRemitenteComercialVentaSecundaria2'];
        $cuitMercadoATermino = $input['solicitud']['intervinientes']['cuitMercadoATermino'];
        $cuitCorredorVentaPrimaria = $input['solicitud']['intervinientes']['cuitCorredorVentaPrimaria'];
        $cuitCorredorVentaSecundaria = $input['solicitud']['intervinientes']['cuitCorredorVentaSecundaria'];
        $cuitRepresentanteEntregador = $input['solicitud']['intervinientes']['cuitRepresentanteEntregador'];
        $cuitRepresentanteRecibidor = $input['solicitud']['intervinientes']['cuitRepresentanteRecibidor'];
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
        $tarifa            = $input['solicitud']['transporte']['tarifa'];
        $cuitPagadorFlete  = $input['solicitud']['transporte']['cuitPagadorFlete'];
        $cuitIntermediarioFlete = $input['solicitud']['transporte']['cuitIntermediarioFlete'];
		$mercaderiaFumigada= $input['solicitud']['transporte']['mercaderiaFumigada'];


        if ($esSolicitanteCampo==0){
            $origen = array(
                'operador' => array(
                    'codProvincia' => $input['solicitud']['origen']['operador']['codProvinciaOperador'],
                    'codLocalidad' => $input['solicitud']['origen']['operador']['codLocalidadOperador'],
                    'planta'       => $input['solicitud']['origen']['operador']['plantaOperador']
                ));
        } else {
            $origen = array(
                'productor' => array(
                    'codProvincia' => $input['solicitud']['origen']['productor']['codProvinciaProductor'],
                    'codLocalidad' => $input['solicitud']['origen']['productor']['codLocalidadProductor']
                ));
        }

    
        $intervinientes = array();
        if ($cuitRemitenteComercialVentaPrimaria!=0) {
            $intervinientes['cuitRemitenteComercialVentaPrimaria'] = $cuitRemitenteComercialVentaPrimaria;
        }
        if ($cuitRemitenteComercialVentaSecundaria!=0) {
            $intervinientes['cuitRemitenteComercialVentaSecundaria'] = $cuitRemitenteComercialVentaSecundaria;
        }
        if ($cuitRemitenteComercialVentaSecundaria2!=0) {
            $intervinientes['cuitRemitenteComercialVentaSecundaria2'] = $cuitRemitenteComercialVentaSecundaria2;
        }
        if ($cuitMercadoATermino!=0) {
            $intervinientes['cuitMercadoATermino'] = $cuitMercadoATermino;
        }
        if ($cuitCorredorVentaPrimaria!=0) {
            $intervinientes['cuitCorredorVentaPrimaria'] = $cuitCorredorVentaPrimaria;
        }
        if ($cuitCorredorVentaSecundaria!=0) {
            $intervinientes['cuitCorredorVentaSecundaria'] = $cuitCorredorVentaSecundaria;
        }
        if ($cuitRepresentanteEntregador!=0) {
            $intervinientes['cuitRepresentanteEntregador'] = $cuitRepresentanteEntregador;
        }
        if ($cuitRepresentanteRecibidor!=0) {
            $intervinientes['cuitRepresentanteRecibidor'] = $cuitRepresentanteRecibidor;
        }

		$params = array(
			'auth' => array(
					'token' 			=> $this->ta->token,
					'sign' 				=> $this->ta->sign,
					'cuitRepresentada' 	=> $this->cuit
				),
			'solicitud' => array(
					'cabecera' => array(
						'tipoCP'          => $input['cabecera']['tipoCP'],
						'cuitSolicitante' => $input['cabecera']['cuitSolicitante'],
						'sucursal'        => $input['cabecera']['sucursal'],
						'nroOrden'        => $input['cabecera']['nroOrden']
					),
                    'origen' => $origen,
					'correspondeRetiroProductor' => $correspondeRetiroProductor,
					'esSolicitanteCampo' 		 => $esSolicitanteCampo,
                    'intervinientes' => $intervinientes,
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

        if ($cuitRemitenteComercialProductor!=0){
            $params['solicitud']['retiroProductor']['cuitRemitenteComercialProductor']=$cuitRemitenteComercialProductor;
        } 

        if (!empty(trim($codigoTurno))){
		    $params['solicitud']['transporte']['codigoTurno'] = $codigoTurno;
        }
        if ($tarifa>0){
            $params['solicitud']['transporte']['tarifa'] = $tarifa;
        }
        if ($cuitPagadorFlete>0){
            $params['solicitud']['transporte']['cuitPagadorFlete'] = $cuitPagadorFlete;
        }
        if ($cuitIntermediarioFlete>0){
             $params['solicitud']['transporte']['cuitIntermediarioFlete'] = $cuitIntermediarioFlete;
        }
        if (isset($input['solicitud']['observaciones'])){
		    $params['solicitud']['observaciones'] = $input['solicitud']['observaciones'];
        }

		try {
			$response = parent::ExecuteRequest('autorizarCPEAutomotor', $params);
			if (is_string($response)) throw new \Exception($response);

			if (isset($response->respuesta)){
			    if (isset($response->respuesta->pdf)){
                    $response->respuesta->pdf = base64_encode($response->respuesta->pdf);
                }
				return $this->processSuccess($response->respuesta);
			}
			return $this->processError($response->respuesta->errores);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}

}
