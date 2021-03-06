<?php
/**
 * Filename: Utils.php
 * Project: api.aq2e.local
 * Editor: PhpStorm
 * Namespace: ${NAMESPACE}
 * Class:
 * Type:
 *
 * @author: Frank Decker
 * @since : 5/24/2017 2:02 AM
 */
//require_once('');

class UUID {
	
	/*
	 * Generate v3 UUID
	 *
	 * Version 3 UUIDs are named based. They require a namespace (another
	 * valid UUID) and a value (the name). Given the same namespace and
	 * name, the output is always the same.
	 *
	 * @param	uuid	$namespace
	 * @param	string	$name
	 */
	
	public static function v3($namespace, $name)
	{
		if(!self::is_valid($namespace)) return false;
		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);
		// Binary Value
		$nstr = '';
		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2)
		{
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}
		// Calculate hash value
		$hash = md5($nstr . $name);
		return sprintf('%08s-%04s-%04x-%04x-%12s',
			// 32 bits for "time_low"
			           substr($hash, 0, 8),
			// 16 bits for "time_mid"
			           substr($hash, 8, 4),
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 3
			           (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			           (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
			// 48 bits for "node"
			           substr($hash, 20, 12)
		);
	}
	
	/**
	 *
	 * Generate v4 UUID
	 *
	 * Version 4 UUIDs are pseudo-random.
	 */
	
	public static function v4()
	{
		$t = unpack('S8', openssl_random_pseudo_bytes(16));
		// four most significant bits of 3rd group hold version number 4
		$t[3] = $t[3] | 0x4000;
		// two most significant bits of 4th group hold zero and one for variant DCE1.1
		$t[4] = $t[4] | 0x8000;
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', ...$t);
	}
	
	/*
	 * Generate v5 UUID
	 *
	 * Version 5 UUIDs are named based. They require a namespace (another
	 * valid UUID) and a value (the name). Given the same namespace and
	 * name, the output is always the same.
	 *
	 * @param	uuid	$namespace
	 * @param	string	$name
	 */
	
	public static function v5($namespace, $name)
	{
		if(!self::is_valid($namespace)) return false;
		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);
		// Binary Value
		$nstr = '';
		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2)
		{
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}
		// Calculate hash value
		$hash = sha1($nstr . $name);
		
		return sprintf('%08s-%04s-%04x-%04x-%12s',
			// 32 bits for "time_low"
			           substr($hash, 0, 8),
			// 16 bits for "time_mid"
			           substr($hash, 8, 4),
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 5
			           (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			           (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
			// 48 bits for "node"
			           substr($hash, 20, 12)
		);
	}
	
	public static function is_valid($uuid) {
		
		return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.'[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
		
	}
	
}

class Utils {
	
	/* variables */
	/* constants */
	
	function index() {
	}

	function gen_api_key() {
		$uuid = UUID::v4();
		echo $uuid;
	}
	
	/*
	function Utils() {
	
	}
	*/
} // end of Utils