<?php
/**
/**
 * Base class for AFIP web services 
 *
 * @since 0.5
 *
 * @package Afip
 * @author 	Afip SDK afipsdk@gmail.com
**/
class AfipWebService
{
	/**
	 * Web service SOAP version
	 *
	 * @var intenger
	 **/
	var $soap_version;

	/**
	 * File name for the Web Services Description Language
	 *
	 * @var string
	 **/
	var $WSDL;
	
	/**
	 * The url to web service
	 *
	 * @var string
	 **/
	var $URL;

	/**
	 * File name for the Web Services Description 
	 * Language in test mode
	 *
	 * @var string
	 **/
	var $WSDL_TEST;

	/**
	 * The url to web service in test mode
	 *
	 * @var string
	 **/
	var $URL_TEST;
	
	/**
	 * The Afip parent Class
	 *
	 * @var Afip
	 **/
	var $afip;
	
	function __construct($afip)
	{
		$this->afip = $afip;

		if ($this->afip->options['production'] === TRUE) {
			$this->WSDL = __DIR__.'/Afip_res/'.$this->WSDL;
		} else {
			$this->WSDL = __DIR__.'/Afip_res/'.$this->WSDL_TEST;
			$this->URL 	= $this->URL_TEST;
		}

		if (!file_exists($this->WSDL)) 
			throw new Exception("Failed to open ".$this->WSDL."\n", 3);
	}

	/**
	 * Sends request to AFIP servers
	 * 
	 * @since 1.0
	 *
	 * @param string 	$operation 	SOAP operation to do 
	 * @param array 	$params 	Parameters to send
	 *
	 * @return mixed Operation results 
	 **/
	public function ExecuteRequest($operation, $params = array())
	{
		$pathLogs = __DIR__.'/../../logs/';

		if (!isset($this->soap_client)) {
            ini_set("default_socket_timeout", 15);
			$this->soap_client = new SoapClient($this->WSDL, array(
				'soap_version' 	=> $this->soap_version,
				'location' 		=> $this->URL,
				'trace' 		=> 1,
                'exceptions' 	=> true,
                'connection_timeout' =>15,
				'stream_context' => stream_context_create(['ssl'=> ['ciphers'=> 'AES256-SHA','verify_peer'=> false,'verify_peer_name'=> false]])
			)); 
		}

		try {
            $results = $this->soap_client->{$operation}($params);

			$this->_CheckErrors($operation, $results);

        } catch (SoapFault $fault) {
			file_put_contents($pathLogs . 'error.log', $this->soap_client->__getLastRequest(), FILE_APPEND);
        	$results = $fault->getMessage();
		}

        $transaction_log = $pathLogs . 'transaction.log';
		file_put_contents($transaction_log, "\n#============================================================#\n", FILE_APPEND);
		file_put_contents($transaction_log, "#Date Time........: ".date("d-m-Y G:i:s")."\n", FILE_APPEND);
		file_put_contents($transaction_log, "#CUIT.............: ".$this->afip->CUIT."\n", FILE_APPEND);
		file_put_contents($transaction_log, "#URL..............: ".$this->URL."\n", FILE_APPEND);
		file_put_contents($transaction_log, "#Action...........: ".$operation."\n", FILE_APPEND);
		file_put_contents($transaction_log, "#Response Header..: \n", FILE_APPEND);
		file_put_contents($transaction_log, $this->soap_client->__getLastResponseHeaders()."\n", FILE_APPEND);
		file_put_contents($transaction_log, "#Response Body....: \n", FILE_APPEND);
		file_put_contents($transaction_log, json_encode($results)."\n", FILE_APPEND);
		//file_put_contents($transaction_log, $this->soap_client->__getLastResponse()."\n", FILE_APPEND);

		$fileName = $pathLogs . $operation.".log";
		file_put_contents($fileName, $this->soap_client->__getLastRequest());

		return $results;
	}

	/**
	 * Check if occurs an error on Web Service request
	 * 
	 * @since 1.0
	 *
	 * @param string 	$operation 	SOAP operation to check 
	 * @param mixed 	$results 	AFIP response
	 *
	 * @throws Exception if exists an error in response 
	 * 
	 * @return void 
	 **/
	private function _CheckErrors($operation, $results)
	{
		if (is_soap_fault($results)) 
			throw new Exception("SOAP Fault: ".$results->faultcode."\n".$results->faultstring."\n", 4);
	}
}
