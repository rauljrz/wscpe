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
                    'CantReg' => $input['FeCabReq']['CantReg'],
                    'CbteTipo' => $input['FeCabReq']['CbteTipo'],
                    'PtoVta' => $input['FeCabReq']['PtoVta']
                ),
                'FeDetReq' => array (
                    'FECAEDetRequest' => array(
                        'Concepto' => $input['FeDetReq']['Concepto'],
                        'DocTipo' => $input['FeDetReq']['DocTipo'],
                        'DocNro' => $input['FeDetReq']['DocNro'],
                        'CbteDesde' => $input['FeDetReq']['CbteDesde'],
                        'CbteHasta' => $input['FeDetReq']['CbteHasta'],
                        'CbteFch' => $input['FeDetReq']['CbteFch'],
                        'ImpTotal' => number_format(abs($input['FeDetReq']['ImpTotal']),2,'.',''),
                        'ImpTotConc' => number_format(abs($input['FeDetReq']['ImpTotConc']),2,'.',''),
                        'ImpNeto' => number_format(abs($input['FeDetReq']['ImpNeto']),2,'.',''),
                        'ImpOpEx' => number_format(abs($input['FeDetReq']['ImpOpEx']),2,'.',''),
                        'ImpTrib' => number_format(abs($input['FeDetReq']['ImpTrib']),2,'.',''),
                        'ImpIVA' => number_format(abs($input['FeDetReq']['ImpIVA']),2,'.',''),
                        'FchServDesde' => $input['FeDetReq']['FchServDesde'],
                        'FchServHasta' => $input['FeDetReq']['FchServHasta'],
                        'FchVtoPago' => $input['FeDetReq']['FchVtoPago'],
                        'MonId' => $input['FeDetReq']['MonId'],
                        'MonCotiz' => $input['FeDetReq']['MonCotiz']
                    )
                )
            ),
		);
        
        if (isset($input['CbtesAsoc'])){
            $CbtesAsoc = array(
                'CbteAsoc' => array()
            );
            foreach ($input['CbtesAsoc'] as $comprobante) {
                $CbtesAsoc['CbteAsoc'][] = array(
                    'Tipo' => $comprobante['Tipo'],
                    'PtoVta' => $comprobante['PtoVta'],
                    'Nro' => $comprobante['Nro'],
                    'Cuit' => $comprobante['Cuit'],
                    'CbteFch' => $comprobante['CbteFch']
                );
            }

            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['CbtesAsoc'] = $CbtesAsoc;
        }
        
        if (isset($input['Tributos']) ) {
            $Tributos = array(
                'Tributo' => array ()
            );
            foreach ($input['Tributos'] as $unTributo) {
                $Tributos['Tributo'][] = array(
                        'Id' => $unTributo['Id'],
                        'Desc' => $unTributo['Desc'],
                        'BaseImp' => number_format(abs($unTributo['BaseImp']),2,'.',''),
                        'Alic' => number_format(abs($unTributo['Alic']),2,'.',''),
                        'Importe' => number_format(abs($unTributo['Importe']),2,'.','')
                );
            }
            
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Tributos'] = $Tributos;
        }

        if (isset($input['Iva'])) {
            $Iva = array(
                'AlicIva' => array()
            );
            foreach ($input['Iva'] as $alicuota) {
                $Iva['AlicIva'][] = array(
                    'Id' => $alicuota['Id'],
                    'BaseImp' => number_format(abs($alicuota['BaseImp']),2,'.',''),
                    'Importe' => number_format(abs($alicuota['Importe']),2,'.','')
                );
            }

            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Iva'] = $Iva;
        }

        if (isset($input['Opcionales'])) {
            $Opcionales = array(
                'Opcional' => array()
            );
            foreach ($input['Opcionales'] as $opcional) {
                $Opcionales['Opcional'][] = array(
                    'Id' => $opcional['Id'],
                    'Valor' => $opcional['Valor']
                );
            }
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Opcionales'] = $Opcionales;
        }

        if (isset($input['Compradores'])) {
            $Compradores = array(
                'Comprador' => array()
            );
            foreach ($input['Compradores'] as $comprador) {
                $Compradores['Comprador'][] = array(
                    'DocTipo' => $comprador['DocTipo'],
                    'DocNro' => $comprador['DocNro'],
                    'Porcentaje' => $comprador['Porcentaje']
                );
            }
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Compradores'] = $Compradores;
        }

        if (isset($input['PeriodoAsoc'])) {
            $PeriodoAsoc = array(
                "FchDesde" => $input['PeriodoAsoc']['FchDesde'],
                "FchHasta" => $input['PeriodoAsoc']['FchHasta']
            );
            $params['FeCAEReq']['FeDetReq']['FECAEDetRequest']['PeriodoAsoc'] = $PeriodoAsoc;
        }

        if (isset($input['Actividades'])) {
            $Actividades = array(
                'Actividad' => array()
            );
            foreach ($input['Actividades'] as $actividad) {
                $Actividades['Actividad'][] = array(
                    'Id' => $actividad['Id']
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
