<?php

namespace App\Utility;

class AccountUtility
{
    const ADMIN = 0;
    const USER = 1;
    const DEV = 2;
    private static $info = null;
    public static function setLogin($info)
    {
        self::$info = $info;
        $_SESSION['account'] = $info;
    }

    public static function logout(){
        self::$info = null;
        unset($_SESSION['account']);
    }

    public static function isLogin()
    {
        if(self::$info === null && isset($_SESSION['account'])){
            self::$info = $_SESSION['account'];
        }
        return self::$info !== null;
    }

    public static function isAdmin(){
        return self::$info['account_type'] == self::ADMIN;
    }

    public static function isUser(){
        return self::$info['account_type'] == self::USER;
    }

    public static function isDev(){
        return self::$info['account_type'] == self::DEV;
    }

    public static function get($key){
        return self::$info[$key] ?? null;
    }

    public static function set($key,$valule){
        self::$info[$key] = $valule;
        $_SESSION['account'] = self::$info;
    }

    public static function getId(){
        return self::$info['id'] ?? null;
    }

    public static function getEmail() {
        return self::$info['email'] ?? null;
    }

    public static function getFullName(){
        return self::$info['full_name'] ?? null;
    }

    public static function requireLogin(){
        if(!self::isLogin()){
            $actual_link = ViewUtility::getCurrentUrl();
            ViewUtility::redirectUrl("account/login.php?redirect=$actual_link");
        }
    }
}
