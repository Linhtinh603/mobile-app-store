<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Quản lý ứng dụng - Developer</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

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
                <tr>
                    <th scope="row">1</th>
                    <td>Facebook</td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-success"> Miễn phí </span> </td>
                    <td> 0đ </td>
                    <td> <span class="badge badge-Info"> Đang chờ duyệt </span> </td>
                    <td> <a href="#">Cập nhật</a> | <a href="#">Gỡ bỏ</a>  <td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Facebook</td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-primary"> Có phí </span> </td>
                    <td> 10 000đ </td>
                    <td> <span class="badge badge-Light"> Bản nháp </span> </td>
                    <td> <a href="#">Cập nhật</a> | <a href="#">Gỡ bỏ</a>  <td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Facebook</td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-primary"> Có phí </span> </td>
                    <td> 10 000đ </td>
                    <td> <span class="badge badge-dark"> Từ chối </span> </td>
                    <td> <a href="#">Cập nhật</a> | <a href="#">Gỡ bỏ</a>  <td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>