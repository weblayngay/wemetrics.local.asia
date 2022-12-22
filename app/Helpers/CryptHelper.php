<?php
namespace App\Helpers;

class CryptHelper
{
    /**
     * @param string $icon
     * @return string
     */
    public static function EnCryptEmail($data): string
    {
        $n = 0;
        $result = '';
        $lengthData = strlen($data);
        for($i=0; $i < $lengthData; $i++ )
        {
            $n = mb_ord(substr($data, $i, 1), "utf8");
            if( $n >= 8364 )
            {
                $n = 128;
            }
            $n = $n+1;
            $result .= chr( $n );
        }
        return $result;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function UnCryptEmail($data): string
    {
        $n = 0;
        $result = '';
        $lengthData = strlen($data); 
        for( $i = 0; $i < $lengthData; $i++)
        {
            $n = mb_ord(substr($data, $i, 1), "utf8");
            if( $n >= 8364 )
            {
                $n = 128;
            }
            $n = $n - 1;
            $result .= chr( $n );
        }
        return $result;
    }

    public static function CryptSHA1($data, $length = 32)
    {
        $hash = $data;
        $result = substr(sha1($hash), 0, $length);
        return $result;
    }

    public static function CryptBin2Hex($data, $length = 32)
    {
        $hash = $data.random_bytes($length);
        $result = substr(bin2hex($hash), 0, $length);
        return $result;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function CryptClientId(): string
    {
        $bytes = 32;
        $length = 22;
        $result = substr(preg_replace('/\W/', "", base64_encode(bin2hex(random_bytes($bytes)))), 0, $length);
        return $result;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function CryptClientKey(): string
    {
        $length = 32;
        $result = preg_replace('/\W/', "", base64_encode(substr(sha1(rand().time()), 0, $length)));
        return $result;
    }

    public static function encryptCombineBase64Sha1($data)
    {
        $length = 32;
        $result = preg_replace('/\W/', "", base64_encode(substr(sha1($data), 0, $length)));
        return $result;
    }// encrypt

    public static function encryptCombineBase64Sha256($string, $key)
    {
        $result = hash_hmac('sha256', $string, $key, true);
        return base64_encode($result);
    }// encrypt
}
