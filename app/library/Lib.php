<?php
namespace App\library;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Lib {
    public static $dictionaryList;
    public static function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
        return $token;
    }

    public static function getNumberToken($length){
        $token = "";
        $codeAlphabet = "0123456789";
        $max = strlen($codeAlphabet); // edited
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
        return $token;
    }

    public static function createFile($type, $type_id, $folder_depth = false)
    {

        if($folder_depth == false) {
            $dir_name = $type;
            if (!file_exists($type)) {
                mkdir($type, 0777, true);
            }
        } else {
            $year = date("Y");
            $month = date("m");
            $date = date("d");

            $dir_name = $type.'/'.$year.'/'.$month.'/'.$date;

            if (!file_exists($type.'/'.$year.'/'.$month.'/'.$date)) {
                mkdir($type.'/'.$year.'/'.$month.'/'.$date, 0777, true);
            }
        }


        $token = self::getToken(6);
        $file_name = $type . "_" . $type_id . "_" . $token;
        $file['directory'] = $dir_name;
        $file['file_name'] = $file_name;

        return $file;
    }

    public static function ipAddress()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }
        else if(getenv('HTTP_X_REAL_IP')) {
            $ipaddress = getenv('HTTP_X_REAL_IP');
        }
        else if(getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        }
        else if(getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        }
        else if(getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        }
        else if(getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        }
        else if(getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        }
        else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public static function makeWordHash( $word ) {
        $word = preg_replace('/\s+/', ' ', trim($word));
        $str = implode( " ", array_filter( explode( " ", $word ) ) );
        return sha1( strtolower( trim( $str ) ) );
    }

    public static function getDictionaryList() {
        return empty(self::$dictionaryList) ? request()->session()->get('dictionaryList') : self::$dictionaryList ;
    }

    public static function getWebTranslation( $wordToTranslate ) {
        $langCode = Session('user_language');
        $dictionaryList = self::getDictionaryList();
        $getCode = self::makeWordHash( $wordToTranslate );
        return $dictionaryList[$langCode."_".$getCode] ?? $wordToTranslate;
    }

}
