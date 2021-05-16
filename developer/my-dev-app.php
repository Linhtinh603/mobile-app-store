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

    if(!AccountUtility::isDev()){
        ViewUtility::redirectUrl();
    }   
    $user_id_current = AccountUtility::getId();

    $sql_get_app_by_user = "SELECT a.*, c.name as category_name from apps a 
                        left join categories c on a.category_id = c.id 
                        WHERE a.created_by = $user_id_current 
                        order by id asc";

?>

<body class="quanlyapp">
<div class="shadow-sm p-2 m-2 bg-white rounded">
        
<div class="row m-3">

    <div class="col-2 list-group list-group-flush">
        <a href="../account"
            class="list-group-item list-group-item-action ">Thông tin cá nhân</a>
        <a href="../account/my-app.php"
            class="list-group-item list-group-item-action ">Ứng dụng của tôi</a> 
        <a href="../account/balance.php"
            class="list-group-item list-group-item-action">Nạp tiền / Lịch sử nạp</a>
        <a href="#"
            class="list-group-item list-group-item-action active">Developer - Quản lý ứng dụng</a>
        <a href="./my-order-list.php"
            class="list-group-item list-group-item-action">Developer - Xem đơn hàng</a>   
    </div>

    <div class="col">

        <div class="ml-3">
            Hãy vào đây để đăng tải một ứng dụng lên website 
            
        </div>
        <a href="../developer/upload-application.php"><button type="button" class="btn btn-info m-3">Đăng tải ứng dụng ngay</button></a>

        <h3 class="text-center font-weight-bolder">Danh sách ứng dụng mà bạn đã tạo ra</h3>
        <p class="font-weight-lighter">Chỉ những ứng dụng đã được duyệt mới được hiển thị trên website và được cho phép tải về,
            Ứng dụng bị từ chối thì bạn vui lòng nhấn gỡ bỏ.
        </p>
        <table class="table table-hover m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên ứng dụng</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Loại ứng dụng</th>
                <th scope="col">Giá bán</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                <!-- badge-Light: Bản nháp | badge-Info: đang chờ duyệt | badge-success: Đã được duyệt | badge-dark: đã từ chối  | badge-Danger: Đã gỡ |  -->
                <?php 
                    $i = 1;
                    foreach($pdo->query($sql_get_app_by_user) as $v){ 
                ?>
                    <tr>
                        <th scope="row"><?=$i?></th>
                        <td><?=$v['name']?></td>
                        <td><?=$v['category_name']?></td>
                        <?php if($v['price'] > 0){ ?>
                            <td> <span class="badge badge-primary"> Có phí </span> </td>
                            <td> <?=number_format($v['price'])?>đ </td>
                        <?php }else{ ?>
                            <td> <span class="badge badge-success"> Miễn phí </span> </td>
                            <td> 0đ </td>
                        <?php } ?>
                        <?php if($v['status'] == 0){ ?>
                            <td> <span class="badge badge-Light"> Lưu nháp </span> </td>
                        <?php }else if($v['status'] == 1){ ?>
                            <td> <span class="badge badge-warning"> Đang chờ duyệt </span> </td>
                        <?php }else if($v['status'] == 2){ ?>
                            <td> <span class="badge badge-Info"> Đã duyệt </span> </td>
                        <?php }else if($v['status'] == 3){ ?>
                            <td> <span class="badge badge-danger"> Đã gỡ </span> </td>
                        <?php }else if($v['status'] == 4){ ?>
                            <td> <span class="badge badge-dark"> Bị từ chối </span> </td>
                        <?php } ?>
                        <td> 
                            <a class="btn btn-success" href="<?=$DOMAIN_URL.'developer/update-application.php?id='.$v['id']?>">Cập nhật</a>
                            <a class="btn btn-danger" onclick="resetStatusApp(<?=$v['id']?>, <?=$v['id']?>)">Gỡ bỏ</a>  
                        <td>
                    </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

<script>
    function resetStatusApp(id, status){
        var result = confirm("Bạn có muốn gỡ không ?");
        if (result) {
            $.ajax({
                url:'./ajax/ajax_reset_status.php',
                method:"POST",
                data: {
                    id: id,
                    status : status,
                    user_cd : <?=$user_id_current?>
                },
                dataType: 'JSON',
                success: function(res) {  
                    location.reload();  
                },
                error: function(err) {
                    console.log(err);
                }
            });   
        }
    }
</script>