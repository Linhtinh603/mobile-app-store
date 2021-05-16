<?php
require_once __DIR__ . '/../__/bootstrap.php';
use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

AccountUtility::requireLogin();
if (!AccountUtility::isAdmin()) {
    ViewUtility::redirectUrl();
}

// tinh tong so luong app
$pdo = Common::getPdo();
$sql = 'SELECT count(*) as count FROM apps WHERE status = 2';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$res = $sth->fetchAll();
$totalApps = $res[0]['count'];

// tinh tong so luong app mien phi
$sql = 'SELECT count(*) as count FROM apps WHERE status = 2 AND price = 0';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$res = $sth->fetchAll();
$totalFreeApps = $res[0]['count'];

$totalPaidApps = $totalApps - $totalFreeApps;

// tinh tong so luong tai app
$pdo = Common::getPdo();
$sql = 'SELECT count(*) as count FROM app_purchased_history';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$res = $sth->fetchAll();
$totalDownloads = $res[0]['count'];

// tinh tong so luong tai app mien phi
$pdo = Common::getPdo();
$sql = 'SELECT count(*) as count FROM app_purchased_history WHERE purchased_price = 0';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$res = $sth->fetchAll();
$totalFreeDownloads = $res[0]['count'];

$totalPaidDownloads = $totalDownloads - $totalFreeDownloads;

?>
<html>

<head>
    <title>Trang thống kê - Developer</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="quanlyapp">
<div class="shadow-sm p-2 m-2 bg-white rounded">
        
<div class="row m-3">

    <div class="col-2 list-group list-group-flush">
        <a href="#"
            class="list-group-item list-group-item-action active">Thống kê</a>
        <a href="./app-censorship.php"
            class="list-group-item list-group-item-action ">Kiểm duyệt ứng dụng</a> 
        <a href="./money-card.php"
            class="list-group-item list-group-item-action">Quản lý mã thẻ</a>
        <a href="./category.php"
            class="list-group-item list-group-item-action ">Quản lý danh mục</a>
    </div>

    <div class="col">

        <h3 class="text-center font-weight-bolder">Thống kê tổng quan</h3>
        <p class="font-weight-lighter">Chỉ những ứng dụng đã được duyệt mới được hiển thị trên website và được cho phép tải về,
            Ứng dụng bị từ chối thì bạn vui lòng nhấn gỡ bỏ.
        </p>
        <table class="table table-hover m-3">
            <tbody>
                <tr>
                    <th scope="row">Tổng số ứng dụng</th>
                    <td><?= $totalApps ?></td> 
                </tr>
                <tr>
                    <th scope="row">Số ứng dụng miễn phí</th>
                    <td><?= $totalFreeApps ?> (<?= round($totalFreeApps/$totalApps * 100, 2) ?>%)</td> 
                </tr>
                <tr>
                    <th scope="row">Tổng số lượt tải miễn phí</th>
                    <td><?= $totalFreeDownloads ?></td> 
                </tr>
                <tr>
                    <th scope="row">Số ứng dụng có phí</th>
                    <td><?= $totalPaidApps ?> (<?= round($totalPaidApps/$totalApps * 100, 2) ?>%)</td> 
                </tr>
                <tr>
                    <th scope="row">Tổng số lượt mua ứng dụng</th>
                    <td><?= $totalPaidDownloads ?></td> 
                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>