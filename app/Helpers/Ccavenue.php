<?php

namespace App\Helpers;

class Ccavenue
{
    /**
     * Encrypt merchant data using AES-128-CBC.
     *
     * @param string $plainText
     * @param string $key 32-character hex string (128-bit key)
     * @return string
     * @throws \Exception
     */
//    public static function encrypt($plainText, $key)
// {
//     $key = self::hextobin(md5($key));
//     $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
//     $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
//     $encryptedText = bin2hex($openMode);
//     return $encryptedText;
// }

// public static function decrypt($encryptedText, $key)
// {
//     $key = self::hextobin(md5($key));
//     $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
//     $encryptedText = self::hextobin($encryptedText);
//     $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
//     return $decryptedText;
// }


public static function encrypt($plainText, $key)
{
    $key = hex2bin(md5($key));
    $initVector = pack('C*', ...range(0, 15));
    $encryptedText = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return bin2hex($encryptedText);
}

public static function decrypt($encryptedText, $key)
{
    $key = hex2bin(md5($key));
    $initVector = pack('C*', ...range(0, 15));
    $encryptedText = hex2bin($encryptedText);
    return openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
}

public static function hextobin($hexString)
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
}
