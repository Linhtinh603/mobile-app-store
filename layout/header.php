<html>
<head>
<?php

use App\Utility\AccountUtility;

require_once __DIR__ . '/head.php' ?>
</head>

<?php
    $pdo = Common::getPdo();

    $sql_get_category = "SELECT * from categories";
    $DOMAIN_URL = Config::get('publicPath');

    $app_name = '';
    if(isset($_GET['name_app']) && $_GET['name_app']){
        $app_name = $_GET['name_app'];
    }
 
?>
   
<div class="header mb-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Mobi App Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="<?=  Config::get('publicPath') ?>">Trang chủ <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Top Ứng Dụng
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?=$DOMAIN_URL?>app/app-listing.php?dow_app=buy_a_lot">Mua Nhiều</a>
                <a class="dropdown-item" href="<?=$DOMAIN_URL?>app/app-listing.php?dow_app=download_a_lot">Miễn Phí Tải Nhiều</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Thể Loại
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php foreach($pdo->query($sql_get_category) as $v){ ?>
                    <a class="dropdown-item" href="<?=$DOMAIN_URL?>app/app-listing.php?category=<?=$v['id']?>&category_name=<?=$v['name']?>"><?=$v['name']?></a>
                <?php } ?>
            </div>
        </li>
       
        </ul>
        <form class="form-inline my-2 my-lg-0"  method="GET">
            <input class="form-control mr-sm-2" type="search" value="<?=$app_name?>"
                placeholder="Tìm kiếm ứng dụng" aria-label="Search" name="name_app">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
        </form>
        <ul class="navbar-nav mr-auto">
            <?php if(AccountUtility::isLogin()) { ?>
                <li class="nav-item dropdown">
                <img class="avatar" src="<?=  Config::get('publicPath') . 'public/' . AccountUtility::get('avatar') ?>"></img>
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= AccountUtility::getFullName() ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?=  Config::get('publicPath') . 'account' ?>">Thông tin cá nhân</a>
                <a class="dropdown-item" href="<?=  Config::get('publicPath') . 'account/balance.php' ?>">Nạp tiền</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?=  Config::get('publicPath') . 'account/logout.php' ?>">Đăng xuất</a>
                </div>
            </li>
            <?php } else { ?>
            <a class="nav-link" href="<?=  Config::get('publicPath') . 'account/login.php' ?>">Đăng nhập</a>
            <a class="nav-link" href="<?=  Config::get('publicPath') . 'account/register.php' ?>">Đăng ký</a>
            <?php } ?>
        </ul>
    </div>
    </nav>
</div>
