<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Quản lý ứng dụng - Developer</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<?php 
    use App\Utility\AccountUtility;
    use App\Utility\ViewUtility;

    $pdo = Common::getPdo();
    $DOMAIN_URL = Config::get('publicPath');

    if(!AccountUtility::isLogin()){
        ViewUtility::redirectUrl();
    }   
    $user_id_current = AccountUtility::getId();

    $sql_get_category = "SELECT a.name as app_name, ca.name as cate_name, ph.purchased_price 
                        from app_purchased_history ph left join apps a on ph.app_id = a.id 
                        left join categories ca on a.category_id = ca.id 
                        where ph.account_id = $user_id_current order by a.id desc";

?>
  
<body class="quanlyapp ">
<div class="shadow-sm p-2 m-2 bg-white rounded">

    <div class="row m-3">

        <div class="col-2 list-group list-group-flush">
            <a href="./"
                class="list-group-item list-group-item-action ">Thông tin cá nhân</a>
            <a href="#"
                class="list-group-item list-group-item-action active">Ứng dụng của tôi</a> 
            <a href="./balance.php"
                class="list-group-item list-group-item-action">Nạp tiền / Lịch sử nạp</a>
            <a href="../developer/upgrade.php" 
                class="list-group-item list-group-item-action">Nâng cấp tài khoản</a>
            <a href="../developer/my-dev-app.php"
                class="list-group-item list-group-item-action">Developer - Quản lý ứng dụng</a>
            <a href="../developer/my-order-list.php"
                class="list-group-item list-group-item-action">Developer - Xem đơn hàng</a>   
        </div>

        <div class="col">
        <h3 class="text-center font-weight-bolder">Danh sách ứng dụng đã mua hoặc đã tải</h3>
            <table class="table table-hover m-3">
                <thead>
                    <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên ứng dụng</th>
                    <th scope="col">Thể loại</th>
                    <th scope="col">Loại ứng dụng</th>
                    <th scope="col">Giá bán</th>
                    <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- badge-Light: Bản nháp | badge-Info: đang chờ duyệt | badge-success: Đã được duyệt | badge-dark: đã từ chối  | badge-Danger: Đã gỡ |  -->
                    <?php 
                        $i = 1;
                        foreach($pdo->query($sql_get_category) as $v){ 
                    ?>
                        <tr>
                            <th scope="row"><?=$i?></th>
                            <td><?=$v['app_name']?></td>
                            <td><?=$v['cate_name']?></td>
                            <?php if($v['purchased_price'] == 0){ ?>
                                <td> <span class="badge badge-success"> Miễn phí </span> </td>
                                <td> 0đ </td>
                            <?php }else{ ?>
                                <td> <span class="badge badge-primary"> Mất Phí </span> </td>
                                <td> <?=$v['purchased_price']?> </td>
                            <?php } ?>
                            <td> <a href="#">Tải xuống</a>  <td>
                        </tr>
                    <?php $i ++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>