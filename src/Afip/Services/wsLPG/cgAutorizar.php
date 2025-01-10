<?php
/**
 * AFIP - Web Service Liquidacion Primaria de Grano (ws LpgService)
 *
 * Autorizar CTG (cgAutorizar)
 * El método sirve para autorizar y dar de alta los siguientes certificados:
 * • Primaria.
 * • Retiro.
 * • Transferencia.
 * • Preexistente.
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsLPG
 * @version 1.0
 * @date 2024-05-20
 **/

class cgAutorizar extends baseMethod {

	public function run($input)
	{		
		// Auth params
		$params = array(
			'auth' => array(
				'token' => $this->ta->token,
				'sign' => $this->ta->sign,
				'cuit' => $this->cuit
			)
		);

		// Cabecera obligatoria
		$params['cabecera'] = array(
			'tipoCertificado' => $input['cabecera']['tipoCertificado'],
			'ptoEmision' => $input['cabecera']['ptoEmision'],
			'nroOrden' => $input['cabecera']['nroOrden'],
			'nroIngBrutoDepositario' => $input['cabecera']['nroIngBrutoDepositario'],
			'titularGrano' => $input['cabecera']['titularGrano'],
			'codGrano' => $input['cabecera']['codGrano'],
			'campania' => $input['cabecera']['campania']
		);

		// Cabecera opcional
		if (isset($input['cabecera']['cuitDepositante'])) {
			$params['cabecera']['cuitDepositante'] = $input['cabecera']['cuitDepositante'];
		}
		if (isset($input['cabecera']['nroIngBrutoDepositante'])) {
			$params['cabecera']['nroIngBrutoDepositante'] = $input['cabecera']['nroIngBrutoDepositante'];
		}
		if (isset($input['cabecera']['cuitCorredor'])) {
			$params['cabecera']['cuitCorredor'] = $input['cabecera']['cuitCorredor'];
		}
		if (isset($input['cabecera']['datosAdicionales'])) {
			$params['cabecera']['datosAdicionales'] = $input['cabecera']['datosAdicionales'];
		}

		// Primaria opcional
		if (isset($input['primaria'])) {
			$params['primaria'] = array(
				'nroActDepositario' => $input['primaria']['nroActDepositario'],
				'descripcionTipoGrano' => $input['primaria']['descripcionTipoGrano'],
				'montoAlmacenaje' => $input['primaria']['montoAlmacenaje'],
				'montoAcarreo' => $input['primaria']['montoAcarreo'],
				'montoGastosGenerales' => $input['primaria']['montoGastosGenerales'],
				'montoZarandeo' => $input['primaria']['montoZarandeo'],
				'porcentajeSecadoDe' => $input['primaria']['porcentajeSecadoDe'],
				'porcentajeSecadoA' => $input['primaria']['porcentajeSecadoA'],
				'montoSecado' => $input['primaria']['montoSecado'],
				'montoPorCadaPuntoExceso' => $input['primaria']['montoPorCadaPuntoExceso'],
				'montoOtros' => $input['primaria']['montoOtros'],
				'pesoNetoMermaVolatil' => $input['primaria']['pesoNetoMermaVolatil']
			);

			// CTG array
			if (isset($input['primaria']['ctg'])) {
				$params['primaria']['ctg'] = array();
				foreach ($input['primaria']['ctg'] as $ctg) {
					$params['primaria']['ctg'][] = array(
						'nroCTG' => $ctg['nroCTG'],
						'nroCartaDePorte' => $ctg['nroCartaDePorte'],
						'pesoNetoConfirmadoDefinitivo' => $ctg['pesoNetoConfirmadoDefinitivo'],
						'porcentajeSecadoHumedad' => $ctg['porcentajeSecadoHumedad'],
						'importeSecado' => $ctg['importeSecado'],
						'pesoNetoMermaSecado' => $ctg['pesoNetoMermaSecado'],
						'tarifaSecado' => $ctg['tarifaSecado'],
						'importeZarandeo' => $ctg['importeZarandeo'],
						'pesoNetoMermaZarandeo' => $ctg['pesoNetoMermaZarandeo'],
						'tarifaZarandeo' => $ctg['tarifaZarandeo']
					);
				}
			}

			// Calidad
			if (isset($input['primaria']['calidad'])) {
				$params['primaria']['calidad'] = array(
					'analisisMuestra' => $input['primaria']['calidad']['analisisMuestra'],
					'nroBoletin' => $input['primaria']['calidad']['nroBoletin'],
					'codGrado' => $input['primaria']['calidad']['codGrado'],
					'valorContProteico' => $input['primaria']['calidad']['valorContProteico'],
					'valorFactor' => $input['primaria']['calidad']['valorFactor']
				);
			}

			// Servicios opcionales
			if (isset($input['primaria']['serviciosConceptosNoGravados'])) {
				$params['primaria']['serviciosConceptosNoGravados'] = $input['primaria']['serviciosConceptosNoGravados'];
			}
			if (isset($input['primaria']['serviciosPercepcionesIVA'])) {
				$params['primaria']['serviciosPercepcionesIVA'] = $input['primaria']['serviciosPercepcionesIVA'];
			}
			if (isset($input['primaria']['serviciosOtrasPercepciones'])) {
				$params['primaria']['serviciosOtrasPercepciones'] = $input['primaria']['serviciosOtrasPercepciones'];
			}
		}

		try {
			$response = parent::ExecuteRequest('cgAutorizar', $params);
			
			return $this->processResponse($response);

			

			if (is_string($response)) throw new \Exception($response);

			if (isset($response->respuesta)) return $this->processSuccess($response->respuesta);

			if (isset($response->oReturn->errores)) {
				return $this->processError($response->oReturn->errores);
			}
			return $this->processError($response);
		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}
