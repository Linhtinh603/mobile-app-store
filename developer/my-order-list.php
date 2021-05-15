<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Xem danh sách đơn hàng - Developer</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

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
        <h5 class="color-red">Tổng doanh thu: 12 000 000 đ </h5>
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
                <!-- badge-Light: Bản nháp | badge-Info: đang chờ duyệt | badge-success: Đã được duyệt | badge-dark: đã từ chối  | badge-Danger: Đã gỡ |  -->
                <tr>
                    <th scope="row">1</th>
                    <td><a href=""> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> 120 000đ </td>
                    <td> 12 lượt  </td>
                    <td> 5 400 000đ  <td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>