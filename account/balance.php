<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Nạp tiền / Lịch sử nạp tiền</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="naptien">
<div class="shadow-sm p-2 m-2 bg-white rounded">
    <div class="row m-3">

        <div class="col-2 list-group list-group-flush">
            <a href="./"
                class="list-group-item list-group-item-action ">Thông tin cá nhân</a>
            <a href="./"
                class="list-group-item list-group-item-action ">Ứng dụng của tôi</a> 
            <a href="#"
                class="list-group-item list-group-item-action active">Nạp tiền / Lịch sử nạp</a>
            <a href="../developer/my-dev-app.php"
                class="list-group-item list-group-item-action">Developer - Quản lý ứng dụng</a>
            <a href="../developer/my-order-list.php"
                class="list-group-item list-group-item-action">Developer - Xem đơn hàng</a>   
        </div>

        <div class="col">
        <h3 class="text-center font-weight-bolder">Thông tin tài khoản</h3>
            <div class="font-weight-bolder">
                Số dư hiện tại: <span class="badge badge-info">520 000 <span>đ
            </div>

            <div>
                <h5 class="font-weight-normal mt-3"> Nạp tiền </h5>
                <div class="input-group m-3">
                    <input type="text" class="form-control" placeholder="Nhập mã số Seri" aria-label="seri-number" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-info" type="button" id="button-addon2">Nạp</button>
                    </div>
                </div>
            </div>  


            <h5 class="font-weight-normal">Lịch sử nạp tiền</h5>
            <table class="table table-striped m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã thẻ</th>
                <th scope="col">Mệnh giá</th>
                <th scope="col">Ngày nạp</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>1212*********21321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>1212*********21321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>1212*********21321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                </tr>
            </tbody>
            </table>

        </div>
    
    </div>


</div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>