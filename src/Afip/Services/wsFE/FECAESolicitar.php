<?php
/**
 * AFIP - Web Service Factura Electronica
 * FECAESolicitar 
 *
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2024-01-23
 **/

class FECAESolicitar extends baseMethod {

	public function run($input)
	{		
		// Auth params
		$params = array(
			'Auth' => array(
				'Token' => $this->ta->token,
				'Sign' => $this->ta->sign,
				'Cuit' => $this->cuit
			),
			'FeCAEReq' => array (
                'FeCabReq' => array (
                    'CantReg' => $input['fecabreq']['cantreg'],
                    'CbteTipo' => $input['fecabreq']['cbtetipo'],
                    'PtoVta' => $input['fecabreq']['ptovta']
                ),
                'FeDetReq' => array (
                    'FECAEDetRequest' => array(
                        'Concepto' => $input['fedetreq']['concepto'],
                        'DocTipo' => $input['fedetreq']['doctipo'],
                        'DocNro' => $input['fedetreq']['docnro'],
                        'CbteDesde' => $input['fedetreq']['cbtedesde'],
                        'CbteHasta' => $input['fedetreq']['cbtehasta'],
                        'CbteFch' => $input['fedetreq']['cbtefch'],
                        'ImpTotal' => number_format(abs($input['fedetreq']['imptotal']),2,'.',''),
                        'ImpTotConc' => number_format(abs($input['fedetreq']['imptotconc']),2,'.',''),
                        'ImpNeto' => number_format(abs($input['fedetreq']['impneto']),2,'.',''),
                        'ImpOpEx' => number_format(abs($input['fedetreq']['impopex']),2,'.',''),
                        'ImpTrib' => number_format(abs($input['fedetreq']['imptrib']),2,'.',''),
                        'ImpIVA' => number_format(abs($input['fedetreq']['impiva']),2,'.',''),
                        'FchServDesde' => $input['fedetreq']['fchservdesde'],
                        'FchServHasta' => $input['fedetreq']['fchservhasta'],
                        'FchVtoPago' => $input['fedetreq']['fchvtopago'],
                        'MonId' => $input['fedetreq']['monid'],
                        'MonCotiz' => $input['fedetreq']['moncotiz']
                    )
                )
            ),
		);
        
        if (isset($input['cbtesasoc'])){
            $CbtesAsoc = array(
                'CbteAsoc' => array()
            );
            foreach ($input['cbtesasoc'] as $comprobante) {
                $CbtesAsoc['CbteAsoc'][] = array(
                    'Tipo' => $comprobante['tipo'],
                    'PtoVta' => $comprobante['ptovta'],
                    'Nro' => $comprobante['nro'],
                    'Cuit' => $comprobante['cuit'],
                    'CbteFch' => $comprobante['cbtefch']
                );
            }

            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['CbtesAsoc'] = $CbtesAsoc;
        }
        
        if (isset($input['tributos']) ) {
            $Tributos = array(
                'Tributo' => array ()
            );
            foreach ($input['tributos'] as $unTributo) {
                $Tributos['Tributo'][] = array(
                        'Id' => $unTributo['id'],
                        'Desc' => $unTributo['desc'],
                        'BaseImp' => number_format(abs($unTributo['baseimp']),2,'.',''),
                        'Alic' => number_format(abs($unTributo['alic']),2,'.',''),
                        'Importe' => number_format(abs($unTributo['importe']),2,'.','')
                );
            }
            
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Tributos'] = $Tributos;
        }

        if (isset($input['iva'])) {
            $Iva = array(
                'AlicIva' => array()
            );
            foreach ($input['iva'] as $alicuota) {
                $Iva['AlicIva'][] = array(
                    'Id' => $alicuota['id'],
                    'BaseImp' => number_format(abs($alicuota['baseimp']),2,'.',''),
                    'Importe' => number_format(abs($alicuota['importe']),2,'.','')
                );
            }

            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Iva'] = $Iva;
        }

        if (isset($input['opcionales'])) {
            $Opcionales = array(
                'Opcional' => array()
            );
            foreach ($input['opcionales'] as $opcional) {
                $Opcionales['Opcional'][] = array(
                    'Id' => $opcional['id'],
                    'Valor' => $opcional['valor']
                );
            }
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Opcionales'] = $Opcionales;
        }

        if (isset($input['compradores'])) {
            $Compradores = array(
                'Comprador' => array()
            );
            foreach ($input['compradores'] as $comprador) {
                $Compradores['Comprador'][] = array(
                    'DocTipo' => $comprador['doctipo'],
                    'DocNro' => $comprador['docnro'],
                    'Porcentaje' => $comprador['porcentaje']
                );
            }
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Compradores'] = $Compradores;
        }

        if (isset($input['periodoasoc'])) {
            $PeriodoAsoc = array(
                "FchDesde" => $input['periodoasoc']['fchdesde'],
                "FchHasta" => $input['periodoasoc']['fchhasta']
            );
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['PeriodoAsoc'] = $PeriodoAsoc;
        }

        if (isset($input['actividades'])) {
            $Actividades = array(
                'Actividad' => array()
            );
            foreach ($input['actividades'] as $actividad) {
                $Actividades['Actividad'][] = array(
                    'Id' => $actividad['id']
                );
            }
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Actividades'] = $Actividades;
        }


		try {
			$retrieved = parent::ExecuteRequest('FECAESolicitar', $params);

			return $this->processResponse($retrieved, 'FECAESolicitarResult');
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
