<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Xem danh sách đơn hàng - Developer</title>
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

    $sql_sum_my_app = "SELECT SUM(purchased_price) as total_price
                        from app_purchased_history
                        where account_id = $user_id_current";
    $total_price_my_app = 0;
    foreach($pdo->query($sql_sum_my_app) as $v){
        $total_price_my_app = number_format($v['total_price']);
    }

    $sql_get_app_sell = "SELECT a.*, count(app_id) as cnt_dow_app, sum(purchased_price) as sum_purchased_price, c.name as category_name 
                        from apps a left join app_purchased_history p on a.id = p.app_id 
                        left join categories c on a.category_id = c.id 
                        WHERE a.created_by = $user_id_current
                        GROUP by a.id order by cnt_dow_app desc";
    
    
?>

<body class="xemdonhang">
<div class="shadow-sm p-2 m-2 bg-white rounded">
        
<div class="row m-3">

    <div class="col-2 list-group list-group-flush">
        <a href="../account"
            class="list-group-item list-group-item-action ">Thông tin cá nhân</a>
        <a href="../account/my-app.php"
            class="list-group-item list-group-item-action ">Ứng dụng của tôi</a> 
        <a href="../account/balance.php"
            class="list-group-item list-group-item-action">Nạp tiền / Lịch sử nạp</a>
        <a href="./my-dev-app.php"
            class="list-group-item list-group-item-action">Developer - Quản lý ứng dụng</a>
        <a href="#"
            class="list-group-item list-group-item-action active">Developer - Xem đơn hàng</a>   
    </div>

    <div class="col">

        <h3 class="text-center font-weight-bolder">Thống kê danh sách ứng dụng mà bạn đang bán </h3>
        <p class="font-weight-lighter">Doanh thu của bạn được tính từ các ứng dụng có phí của bạn mà đã được người dùng mua với giá thời điểm lúc đó.
        </p>
        <h5 class="color-red">Tổng doanh thu: <?=$total_price_my_app?> đ </h5>
        <table class="table table-hover m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên ứng dụng</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Giá bán hiện tại</th>
                <th scope="col">Số lượt mua</th>
                <th scope="col">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    foreach($pdo->query($sql_get_app_sell) as $v){ 
                ?>
                    <tr>
                        <th scope="row"><?=$i?></th>
                        <td>
                            <a href=""> <img class="app-icon" src="<?=$DOMAIN_URL?>/public/<?=$v['icon']?>"></img>
                                <?=$v['name']?> 
                            </a> 
                        </td>
                        <td> <?=$v['category_name']?> </td>
                        <td> <?=number_format($v['price'])?>đ </td>
                        <td> <?=$v['cnt_dow_app']?> lượt  </td>
                        <td> <?=number_format($v['sum_purchased_price'])?>đ  <td>
                    </tr>
                <?php $i ++; } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>