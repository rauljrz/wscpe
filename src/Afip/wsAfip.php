<?php
/**
 * Software Development Kit for AFIP web services
 * 
 * This release of Afip SDK is intended to facilitate 
 * the integration to other different web services that 
 * Electronic Billing   
 *
 * @link http://www.afip.gob.ar/ws/ AFIP Web Services documentation
 *
 * @author 	Afip SDK afipsdk@gmail.com
 * @package Afip
 * @version 0.5
 **/
namespace App\Afip;

include_once  __DIR__.'/AfipWebService.php';

class wsAfip {
	/**
	 * File name for the WSDL corresponding to WSAA
	 *
	 * @var string
	 **/
	var $WSAA_WSDL;

	/**
	 * The url to get WSAA token
	 *
	 * @var string
	 **/
	var $WSAA_URL;

	/**
	 * File name for the X.509 certificate in PEM format
	 *
	 * @var string
	 **/
	var $CERT;

	/**
	 * File name for the private key correspoding to CERT (PEM)
	 *
	 * @var string
	 **/
	var $PRIVATEKEY;

	/**
	 * The passphrase (if any) to sign
	 *
	 * @var string
	 **/
	var $PASSPHRASE;

	/**
	 * Afip resources folder
	 *
	 * @var string
	 **/
	var $RES_FOLDER;

	/**
	 * Afip ta folder
	 *
	 * @var string
	 **/
	var $TA_FOLDER;

	/**
	 * The CUIT to use
	 *
	 * @var int
	 **/
	var $CUIT;

	var $isLogging;

	/**
	 * Logger folder
	 *
	 * @var string
	 **/
	var $LOG_FOLDER;

	/**
	 * Implemented Web Services
	 *
	 * @var array[string]
	 **/
	var $implemented_ws = array(
		'ElectronicBilling',
		'RegisterScopeFour',
		'RegisterScopeFive',
		'RegisterInscriptionProof',
		'RegisterScopeTen',
		'RegisterScopeThirteen',
		'wsCPE',
		'wsLPG',
		'wsFE'
	);

	function __construct($options)
	{
		ini_set("soap.wsdl_cache_enabled", "0");

		if (!isset($options['CUIT'])) {
			throw new \Exception("CUIT field is required in options array");
		} else {
			$this->CUIT = $options['CUIT'];
		}

		if (!isset($options['production'])) {
			$options['production'] = FALSE;
		}

		if (!isset($options['passphrase'])) {
			$options['passphrase'] = 'xxxxx';
		}

		if (!isset($options['cert'])) {
			$options['cert'] = $this->CUIT.'_cert';
		}

		if (!isset($options['key'])) {
			$options['key'] = $this->CUIT.'_key';
		}

		if (!isset($options['res_folder'])) {
			$this->RES_FOLDER = __DIR__.'/Afip_res/';
		} else {
			$this->RES_FOLDER = $options['res_folder'];
		}

		if (!isset($options['ta_folder'])) {
			$this->TA_FOLDER = __DIR__.'/Afip_res/';
		} else {
			$this->TA_FOLDER = $options['ta_folder'];
		}

		if (!isset($options['APP_DEBUG'])) {
			$this->isLogging = true;
		} else {
			$this->isLogging = $options['APP_DEBUG'];
		}

		if (!isset($options['log_folder'])) {
			$this->LOG_FOLDER = __DIR__.'/logs/';
		} else {
			$this->LOG_FOLDER = $options['log_folder'];
		}

		$this->PASSPHRASE = $options['passphrase'];

		$this->options = $options;

		$this->CERT 		= $this->RES_FOLDER.$options['cert'];
		$this->PRIVATEKEY 	= $this->RES_FOLDER.$options['key'];

		$this->WSAA_WSDL 	= __DIR__.'/Afip_res/'.'wsaa.wsdl';
		if ($options['production'] === TRUE) {
			$this->WSAA_URL = 'https://wsaa.afip.gov.ar/ws/services/LoginCms';
		} else {
			$this->WSAA_URL = 'https://wsaahomo.afip.gov.ar/ws/services/LoginCms';
		}
		if (!file_exists($this->CERT)) 
			throw new \Exception("No se encontro el archivo: ".strstr($this->CERT, '/certificados')."\n", 1);
		if (!file_exists($this->PRIVATEKEY)) 
			throw new \Exception("No se encontro el archivo: ".strstr($this->PRIVATEKEY, '/certificados')."\n", 2);
		if (!file_exists($this->WSAA_WSDL)) 
			throw new \Exception("No se encontro el archivo: ".strstr($this->WSAA_WSDL, '/certificados')."\n", 3);
	}
	/**
	 * Gets token authorization for an AFIP Web Service
	 *
	 * @since 0.1
	 *
	 * @param string $service Service for token authorization
	 *
	 * @throws Exception if an error occurs
	 *
	 * @return TokenAutorization Token Autorization for AFIP Web Service 
	**/
	public function GetServiceTA($service, $continue = TRUE)
	{
		$typeProduct = ($this->options['production'] === TRUE ? '-production' : '');
		$fileNameXML = $this->TA_FOLDER.'TA-'.$this->options['CUIT'].'-'.$service.$typeProduct.'.xml';

		if (file_exists($fileNameXML)) {
			$TA = new \SimpleXMLElement(file_get_contents($fileNameXML));

			$actual_time 		= new \DateTime(date('c',date('U')+600));
			$expiration_time 	= new \DateTime($TA->header->expirationTime);

			if ($actual_time < $expiration_time) {
				return new TokenAutorization($TA->credentials->token, $TA->credentials->sign);
			}
			else if ($continue === FALSE)
				throw new \Exception("Error Getting TA", 5);
		}
		if ($this->CreateServiceTA($service)) 
			return $this->GetServiceTA($service, FALSE);
	}

	/**
	 * Create an TA from WSAA
	 *
	 * Request to WSAA for a tokent authorization for service and save this
	 * in a xml file
	 *
	 * @since 0.1
	 *
	 * @param string $service Service for token authorization
	 *
	 * @throws Exception if an error occurs creating token authorization
	 *
	 * @return true if token authorization is created success
	**/
	private function CreateServiceTA($service)
	{
		$xmlFile_Service = $this->TA_FOLDER.'TRA-'.$this->options['CUIT'].'-'.$service.'.xml';
		$tmpFile_Service = $this->TA_FOLDER."TRA-".$this->options['CUIT'].'-'.$service.".tmp";
		//Creating TRA
		$TRA = new \SimpleXMLElement(
		'<?xml version="1.0" encoding="UTF-8"?>' .
		'<loginTicketRequest version="1.0">'.
		'</loginTicketRequest>');
		$TRA->addChild('header');
		$TRA->header->addChild('uniqueId',date('U'));
		$TRA->header->addChild('generationTime',date('c',date('U')-600));
		$TRA->header->addChild('expirationTime',date('c',date('U')+600));
		$TRA->addChild('service',$service);
		$TRA->asXML($xmlFile_Service);

		//Signing TRA
		$STATUS = openssl_pkcs7_sign($xmlFile_Service, $tmpFile_Service, "file://".$this->CERT,
			array("file://".$this->PRIVATEKEY, $this->PASSPHRASE),
			array(),
			!PKCS7_DETACHED
		);
		if (!$STATUS) {return FALSE;}
		$inf = fopen($tmpFile_Service, "r");
		$i = 0;
		$CMS="";
		while (!feof($inf)) {
			$buffer=fgets($inf);
			if ( $i++ >= 4 ) {$CMS.=$buffer;}
		}
		fclose($inf);

		if (!$this->isLogging and 1==0){ 
			unlink($xmlFile_Service);
			unlink($tmpFile_Service);
		}

		//Request TA to WSAA
		$client = new \SoapClient($this->WSAA_WSDL, array(
					'soap_version'   => SOAP_1_2,
					'location'       => $this->WSAA_URL,
					'trace'          => 1,
					'exceptions'     => 0,
					'stream_context' => stream_context_create(['ssl'=> ['ciphers'=> 'AES256-SHA','verify_peer'=> false,'verify_peer_name'=> false]])
		));
		$results=$client->loginCms(array('in0'=>$CMS));

		$this->logger($client->__getLastRequest(), 'loginCms.log');

		if (is_soap_fault($results)) 
			throw new \Exception("Error al loguearse en ARCA: ".$results->faultcode." - ".$results->faultstring, 4);

		$TA = $results->loginCmsReturn;

		if (file_put_contents($this->TA_FOLDER.'TA-'.$this->options['CUIT'].'-'.$service.($this->options['production'] === TRUE ? '-production' : '').'.xml', $TA)) 
			return TRUE;
		else
			throw new \Exception('Error writing "TA-'.$this->options['CUIT'].'-'.$service.'.xml"', 5);
	}

	public function __get($property)
	{
		if (in_array($property, $this->implemented_ws)) {
			if (isset($this->{$property})) {
				return $this->{$property};
			} else {
				$file = __DIR__.'/Services/'.$property.'.php';
				if (!file_exists($file)) 
					throw new \Exception("Failed to open ".$file."\n", 1);

				include_once $file;

				return ($this->{$property} = new $property($this));
			}
		} else {
			return $this->{$property};
		}
	}

	protected function logger($message, $file){
		if ($this->isLogging) {
			$filer_Log = (isset($file) || empty($file)) ? 'logger.log' : $file;

			file_put_contents($this->LOG_FOLDER.$filer_Log, $message);
		}
	}
}

/**
/**
 * Token Autorization
 *
 * @since 0.1
 *
 * @package Afip
 * @author 	Afip SDK afipsdk@gmail.com
 **/
class TokenAutorization {
	/**
	 * Authorization and authentication web service Token
	 *
	 * @var string
	 **/
	var $token;

	/**
	 * Authorization and authentication web service Sign
	 *
	 * @var string
	 **/
	var $sign;

	function __construct($token, $sign)
	{
		$this->token 	= $token;
		$this->sign 	= $sign;
	}
}
