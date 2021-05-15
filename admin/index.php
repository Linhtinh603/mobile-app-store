<?php
require_once __DIR__ . '/../__/bootstrap.php';
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
        <a href="./category"
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
                    <td>23</td> 
                </tr>
                <tr>
                    <th scope="row">Số ứng dụng miễn phí</th>
                    <td>12 (53%)</td> 
                </tr>
                <tr>
                    <th scope="row">Tổng số lượt tải miễn phí</th>
                    <td>55</td> 
                </tr>
                <tr>
                    <th scope="row">Số ứng dụng có phí</th>
                    <td>12 (43%)</td> 
                </tr>
                <tr>
                    <th scope="row">Tổng số lượt mua ứng dụng</th>
                    <td>55</td> 
                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>