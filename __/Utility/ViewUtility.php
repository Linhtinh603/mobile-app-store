<?php

namespace App\Utility;

use Config;

class ViewUtility
{
    public static function isPostReq(){
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function getPulicUrl(){
        return "http://$_SERVER[HTTP_HOST]" . Config::get('publicPath');
    }

    public static function getCurrentUrl(){
        return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }


    public static function redirectUrl(string $url = "",bool $other = false,bool  $exit = true){
        if($other){
            header("Location: " . $url);
        } else {
            header("Location: " . self::getPulicUrl() . $url);
        }

        if($exit){
            exit;
        }
    }

    public static function renderJSON($content, $statuscode = 200){
        ob_clean();
        http_response_code($statuscode);
        header('Content-type: application/json');
        echo json_encode($content);
    }

    public static function notBlank(string $value) {
        if(empty($value)){
            return false;
        }

        $value = trim($value);
        return $value != '';
    }

    public static function vaildLength(string $value, int $length) {
        if(strlen($value) == $length){
            return true;
        } else {
            return false;
        }
    }

    public static function vaildMaxLength(string $value, int $length) {
        if(strlen($value) <= $length){
            return true;
        } else {
            return false;
        }
    }

    public static function vaildMinLength(string $value, int $length) {
        if(strlen($value) >= $length){
            return true;
        } else {
            return false;
        }
    }

    public static function vaildBetween(string $value, int $min, int $max) {
        $length = strlen($value);
        if($min <= $length && $length <= $max){
            return true;
        } else {
            return false;
        }
    }


}
