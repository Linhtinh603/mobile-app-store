<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Quản lý ứng dụng - Developer</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

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
                    <tr>
                        <th scope="row">1</th>
                        <td>Facebook</td>
                        <td>Mạng xã hội</td>
                        <td> <span class="badge badge-success"> Miễn phí </span> </td>
                        <td> 0đ </td>
                        <td> <a href="#">Tải xuống</a>  <td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Facebook</td>
                        <td>Mạng xã hội</td>
                        <td> <span class="badge badge-primary"> Có phí </span> </td>
                        <td> 10 000đ </td>
                        <td> <a href="#">Tải xuống</a>  <td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Facebook</td>
                        <td>Mạng xã hội</td>
                        <td> <span class="badge badge-primary"> Có phí </span> </td>
                        <td> 10 000đ </td>
                        <td> <a href="#">Tải xuống</a>  <td>
                    </tr>
                </tbody>
            </table>


        </div>

    </div>


</div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>