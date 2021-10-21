<?php
/**
/**
 * Token Autorization
 *
 * @since 0.1
 *
 * @package Afip
 * @author 	Afip SDK afipsdk@gmail.com
 **/
class TokenAutorizationAfip {
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