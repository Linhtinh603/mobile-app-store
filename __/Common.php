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

    public static function getPagination($url_current, $current_page, $total_page, $number_btn)
    {
        $list_page = '';
        $url_current .= 'page=';
       
        $position_start = $current_page - floor($number_btn / 2);
        $position_start = $position_start > 0 ? $position_start :  1;
        /*first*/
        if ($current_page > 1) {
            $black = $current_page - 1;
            $list_page .= <<<EOD
<li><a href="{$url_current}{$black}">pre</a></li>
EOD;
        }
        
        /*center*/
        $limit_btn = $position_start + $number_btn;
        for ($i = $position_start; $i < $limit_btn; $i++) {
            $class = ($i == $current_page) ? 'active' : '';
            if ($i > 0 && $i <= $total_page) {
                $list_page .= <<<EOD
<li><a class="{$class}" href="{$url_current}{$i}">{$i}</a></li>
EOD;
            }
        }
        
        /*last*/
        if ($current_page < $total_page) {
            $to = $current_page + 1;
            $list_page .= <<<EOD
<li><a href="{$url_current}{$to}">next</a></li>

EOD;
        }
        
        return $list_page;
    }

}
?>

