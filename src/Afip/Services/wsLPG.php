<?php
/**
 * AFIP - Certificacion y Liquidacion de Granos - Web Service lpgService
 * 
 * @link https://www.afip.gob.ar/ws/documentos/manual_wscpe_1.5.pdf WS Specification
 *
 * @author  http://rauljrz.me	
 * @package wsLPG 
 * @version 1.0
 **/
include_once  __DIR__.'/wsLPG/baseMethod.php';

class wsLPG {

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
			$file = __DIR__.'/wsLPG/'.$property.'.php';
			if (!file_exists($file)) 
				throw new \Exception("Failed to open method ".$property."\n", 1);

			include_once $file;

			return ($this->{$property} = new $property($this->afip));
		}
	}
}

