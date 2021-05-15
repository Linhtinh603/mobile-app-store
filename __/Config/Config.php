<?php

class Config
{
    private static $config = [];

    public static function init()
    {
        self::$config = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'dev-config.ini');
    }

    public static function get(string $key)
    {
        return self::$config[$key] ?? null;
    }
}
