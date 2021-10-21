<?php
/**
 * AFIP - Web Service Carta de Porte Electronica (wscpe)
 *
 * Método para informe de contingencia de una CPE existente
 *
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsCPE
 * @version 1.0
 **/

class cerrarContingenciaCPE extends baseMethod {

	public function run()
	{
		$tipoCPE  = 74; 
		$sucursal = 1; 
		$nroOrden = 1; 

		$concepto = 'F' ; // •A - Siniestro.       • B – Imposibilidad de tránsito por zona desfavorable.
                          // • C – Desperfecto mecánico.  • D - Accidente.
                          // • E – Demora descarga.       • F – Otro.

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
					'concepto'       =>  $concepto
				)
		);

		try {
			$response = parent::ExecuteRequest('cerrarContingenciaCPE', $params);

			if (isset($response->respuesta->errores->error)){
				return $this->processError($response->respuesta->errores);
			}
			return $this->processSuccess($response->respuesta->cartaPorte);

		} catch (Exception $e) {
			return $this->processError($e->getMessage());
		}
	}
}