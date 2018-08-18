<?php

namespace App\Http\Libraries;
use Faker\Provider\DateTime;
use Carbon\Carbon;

/**
* 
*/
class XMLRPC
{
	public static function get_iso_date($date = ''){
		if($date!=''){
			$date = new Carbon($date);
			$datetime = $date->toIso8601String();
			xmlrpc_set_type($datetime,'datetime');
		}else{
			$date = Carbon::now();
			$datetime = $date->toIso8601String();
			xmlrpc_set_type($datetime,'datetime');
		}
		$datetime->scalar = substr($datetime->scalar,0,-6);
		
		return $datetime;
	}
	
	public static function create_hash($method, $params = array(),$password) {
		$value =  $method.implode('',$params);
		return hash_hmac('sha1', $value, $password);
	}
	
	public function call($method, $params = array()) {
		$request = xmlrpc_encode_request(
			$method,
			$params,
			array('escaping' => 'markup', 'encoding' => $this->encoding)
		);

		//echo $request;exit;

		$context = stream_context_create(array('http' => array(
			'method' => "POST",
			'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\nHost: ".$this->server."\r\n",
			'content' => $request
		)));

		$server = "http://".$this->server.$this->endpoint;

		$file = file_get_contents($server, false, $context);

		return xmlrpc_decode($file);
	}
	
	public static function callMethod($method, $params = array(),$server,$endpoint,$encoding) {
		$request = xmlrpc_encode_request(
			$method,
			$params,
			array('escaping' => 'markup', 'encoding' => $encoding)
		);

		// echo $request;exit;

		$context = stream_context_create(array('http' => array(
			'method' => "POST",
			'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\nHost: ".$server."\r\n",
			'content' => $request
		)));

		$server = "http://".$server.$endpoint;

		$file = file_get_contents($server, false, $context);
		// echo $file;
		return xmlrpc_decode($file);
	}
	
	public static function callMethodHttps($method, $params = array(),$server,$endpoint,$encoding) {
		$request = xmlrpc_encode_request(
			$method,
			$params,
			array('escaping' => 'markup', 'encoding' => $encoding)
		);

		//echo $request;exit;

		$context = stream_context_create(array('http' => array(
			'method' => "POST",
			'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\nHost: ".$server."\r\n",
			'content' => $request
		)));

		$server = "https://".$server.$endpoint;

		$file = file_get_contents($server, false, $context);

		return xmlrpc_decode($file);
	}
}
