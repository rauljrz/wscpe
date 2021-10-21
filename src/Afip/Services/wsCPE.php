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
include_once  __DIR__.'/wsCPE/baseMethod.php';

class wsCPE {

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
			$file = __DIR__.'/wsCPE/'.$property.'.php';
			if (!file_exists($file)) 
				throw new \Exception("Failed to open method ".$property."\n", 1);

			include_once $file;

			return ($this->{$property} = new $property($this->afip));
		}
	}
}

