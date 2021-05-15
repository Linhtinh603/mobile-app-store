<?php
ob_start();
session_start();
require_once __DIR__ . '/Config/Config.php';
Config::init();

require_once __DIR__ . '/auto_load.php';

require_once 'Common.php';

use App\Utility\AccountUtility;

AccountUtility::isLogin();
