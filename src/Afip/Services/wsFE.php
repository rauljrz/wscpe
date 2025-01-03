<?php
/**
 * AFIP - Web Service Factura Electronica (wsFE)
 * 
 * @link https://www.afip.gob.ar/ws/WSFEV1/documentos/manual-desarrollador-COMPG-v3-4-2.pdf
 *
 * @author  http://rauljrz.me	
 * @package wsFE
 * @version 1.0
 * @date 2025-01-03
 **/
include_once  __DIR__.'/wsFE/baseMethod.php';
class wsFE {
	var $afip;

	function __construct($afip)
	{
		$this->afip = $afip;
	}

	/**
	 * If the method does not exist, look in the trunk for the corresponding class.
	 * 
	 * @since 1.0
	 *
	 * @param string 	$property 	method of the webservice to consult. 
	 *
	 * @return mixed Operation results 
	 **/
	public function __get($property)
	{
		if (isset($this->{$property})) {
			return $this->{$property};
		} else {
			$file = __DIR__.'/wsFE/'.$property.'.php';
			if (!file_exists($file)) 
				throw new \Exception("Failed to open method ".$property."\n", 1);

			include_once $file;

			return ($this->{$property} = new $property($this->afip));
		}
	}
}

