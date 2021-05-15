<?php

use App\DAO\Database;

class Common
{
    public static function init() {
        
    }

    public static function sum($a, $b)
    {
        return $a + $b;
    }

    public static function getPdo(): \PDO{
        $db = Database::getInstance();
        return $db->getPDO();
    }
}
?>

