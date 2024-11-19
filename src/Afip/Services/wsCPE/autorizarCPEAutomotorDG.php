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

class autorizarCPEAutomotorDG extends baseMethod {

    public function run($input)
    {		
        // Origen
        $esUsuarioIndustria = $input['solicitud']['origen']['esUsuarioIndustria'];
        $plantaOrigen = $input['solicitud']['origen']['planta'] ?? null;
        $cuitTitularPlanta = $input['solicitud']['origen']['cuitTitularPlanta'] ?? null;
        $domicilioOrigenTipo = $input['solicitud']['origen']['domicilioOrigen']['tipo'];
        $domicilioOrigenOrden = $input['solicitud']['origen']['domicilioOrigen']['orden'];

        // Intervinientes
        $cuitRemitenteComercial = $input['solicitud']['intervinientes']['cuitRemitenteComercial'] ?? null;
        $cuitMercadoATermino = $input['solicitud']['intervinientes']['cuitMercadoATermino'] ?? null;
        $cuitComisionista = $input['solicitud']['intervinientes']['cuitComisionista'] ?? null;
        $cuitCorredor = $input['solicitud']['intervinientes']['cuitCorredor'] ?? null;

        // DatosCarga
        $codGrano = $input['solicitud']['datosCarga']['codGrano'];
        $codDerivadoGranario = $input['solicitud']['datosCarga']['codDerivadoGranario'];
        $pesoBruto = $input['solicitud']['datosCarga']['pesoBruto'];
        $pesoTara = $input['solicitud']['datosCarga']['pesoTara'];
        $tipoEmbalaje = $input['solicitud']['datosCarga']['tipoEmbalaje'];
        $otroEmbalaje = $input['solicitud']['datosCarga']['otroEmbalaje'] ?? null;
        $unidadMedida = $input['solicitud']['datosCarga']['unidadMedida'];
        $cantidadUnidades = $input['solicitud']['datosCarga']['cantidadUnidades'] ?? null;
        $kgLitroM3 = $input['solicitud']['datosCarga']['kgLitroM3'] ?? null;
        $lote = $input['solicitud']['datosCarga']['lote'] ?? null;
        $fechaLote = $input['solicitud']['datosCarga']['fechaLote'] ?? null;

        // Destino y Destinatario
        $cuitDestino = $input['solicitud']['destino']['cuit'];
        $plantaDestino = $input['solicitud']['destino']['planta'] ?? null;
        $domicilioDestinoTipo = $input['solicitud']['destino']['domicilioDestino']['tipo'];
        $domicilioDestinoOrden = $input['solicitud']['destino']['domicilioDestino']['orden'];
        $cuitDestinatario = $input['solicitud']['destinatario']['cuit'];

        // Transporte
        $cuitTransportista = $input['solicitud']['transporte']['cuitTransportista'];
        $dominio = $input['solicitud']['transporte']['dominio'];
        $fechaHoraPartida = $input['solicitud']['transporte']['fechaHoraPartida'];
        $kmRecorrer = $input['solicitud']['transporte']['kmRecorrer'];
        $cuitChofer = $input['solicitud']['transporte']['cuitChofer'];
        $tarifa = $input['solicitud']['transporte']['tarifa'] ?? null;
        $cuitPagadorFlete = $input['solicitud']['transporte']['cuitPagadorFlete'];
        $cuitIntermediarioFlete = $input['solicitud']['transporte']['cuitIntermediarioFlete'] ?? null;

        $params = array(
            'auth' => array(
                'token' => $this->ta->token,
                'sign' => $this->ta->sign,
                'cuitRepresentada' => $this->cuit
            ),
            'solicitud' => array(
                'cabecera' => array(
                    'tipoCP' => $input['cabecera']['tipoCP'],
                    'sucursal' => $input['cabecera']['sucursal'],
                    'nroOrden' => $input['cabecera']['nroOrden']
                ),
                'origen' => array(
                    'esUsuarioIndustria' => $esUsuarioIndustria,
                    'planta' => $plantaOrigen,
                    'domicilioOrigen' => array(
                        'tipo' => $domicilioOrigenTipo,
                        'orden' => $domicilioOrigenOrden
                    )
                ),
                'datosCarga' => array(
                    'codGrano' => $codGrano,
                    'codDerivadoGranario' => $codDerivadoGranario,
                    'pesoBruto' => $pesoBruto,
                    'pesoTara' => $pesoTara,
                    'tipoEmbalaje' => $tipoEmbalaje,
                    'unidadMedida' => $unidadMedida
                ),
                'destino' => array(
                    'cuit' => $cuitDestino,
                    'domicilioDestino' => array(
                        'tipo' => $domicilioDestinoTipo,
                        'orden' => $domicilioDestinoOrden
                    )
                ),
                'destinatario' => array(
                    'cuit' => $cuitDestinatario
                ),
                'transporte' => array(
                    'cuitTransportista' => $cuitTransportista,
                    'dominio' => $dominio,
                    'fechaHoraPartida' => $fechaHoraPartida,
                    'kmRecorrer' => $kmRecorrer,
                    'cuitChofer' => $cuitChofer,
                    'cuitPagadorFlete' => $cuitPagadorFlete
                )
            )
        );

        // Agregar campos opcionales
        if ($plantaOrigen) {
            $params['solicitud']['origen']['planta'] = $plantaOrigen;
        }
        if ($cuitTitularPlanta) {
            $params['solicitud']['origen']['cuitTitularPlanta'] = $cuitTitularPlanta;
        }

        // Intervinientes opcionales
        $intervinientes = array_filter([
            'cuitRemitenteComercial' => $cuitRemitenteComercial,
            'cuitMercadoATermino' => $cuitMercadoATermino,
            'cuitComisionista' => $cuitComisionista,
            'cuitCorredor' => $cuitCorredor
        ]);
        
        if (!empty($intervinientes)) {
            $params['solicitud']['intervinientes'] = $intervinientes;
        }

        // DatosCarga opcionales
        if ($otroEmbalaje) {
            $params['solicitud']['datosCarga']['otroEmbalaje'] = $otroEmbalaje;
        }
        if ($cantidadUnidades) {
            $params['solicitud']['datosCarga']['cantidadUnidades'] = $cantidadUnidades;
        }
        if ($kgLitroM3) {
            $params['solicitud']['datosCarga']['kgLitroM3'] = $kgLitroM3;
        }
        if ($lote) {
            $params['solicitud']['datosCarga']['lote'] = $lote;
        }
        if ($fechaLote) {
            $params['solicitud']['datosCarga']['fechaLote'] = $fechaLote;
        }

        // Destino opcional
        if ($plantaDestino) {
            $params['solicitud']['destino']['planta'] = $plantaDestino;
        }

        // Transporte opcional
        if ($tarifa) {
            $params['solicitud']['transporte']['tarifa'] = $tarifa;
        }
        if ($cuitIntermediarioFlete) {
            $params['solicitud']['transporte']['cuitIntermediarioFlete'] = $cuitIntermediarioFlete;
        }

        // Observaciones opcional
        if (isset($input['solicitud']['observaciones'])) {
            $params['solicitud']['observaciones'] = $input['solicitud']['observaciones'];
        }

        try {
            $response = parent::ExecuteRequest('autorizarCPEAutomotorDG', $params);
            if (is_string($response)) throw new \Exception($response);

            if (isset($response->respuesta)) {
                if (isset($response->respuesta->pdf)) {
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