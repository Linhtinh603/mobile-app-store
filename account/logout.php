<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\AccountUtility;
use App\Utility\ViewUtility;

AccountUtility::logout();
ViewUtility::redirectUrl();
