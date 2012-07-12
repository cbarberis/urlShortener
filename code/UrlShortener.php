<?php

class UrlShortener extends Controller {
	
	private static $bitly_username;
	
	private static $bitly_api_key;
	
	public static function set_bitly_username($username) {
		self::$bitly_username = $username;
	}
	
	protected function get_bitly_username() {
		return self::$bitly_username;
	}
	
	public static function set_bitly_api_key($key) {
		self::$bitly_api_key = $key;
	}
	
	protected static function get_bitly_api_key() {
		return self::$bitly_api_key;
	}

	static function ready_to_short() {
		return (self::$bitly_api_key && self::$bitly_username);
	}
	
	function makeShortUrl($UrlSegment = null) {
		if(!$UrlSegment) return '';
		if(strrpos($UrlSegment,'localhost') || !self::ready_to_short()) return $UrlSegment;

		$req = new RestfulService("http://api.bitly.com/v3/shorten?login=".self::get_bitly_username()."&apiKey=".self::get_bitly_api_key()."&longUrl=".urlencode($UrlSegment)."&format=json",0);
		$response = $req->request();
		$short = json_decode($response->getBody(), true);
				
		return (isset($short['data']['url'])) ? $short['data']['url'] : '';

	}
}
