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
                class="list-group-item list-group-item-action ">Thống kê</a>
            <a href="./app-censorship.php"
                class="list-group-item list-group-item-action ">Kiểm duyệt ứng dụng</a> 
            <a href="#"
                class="list-group-item list-group-item-action active">Quản lý mã thẻ</a>
            <a href="./category"
                class="list-group-item list-group-item-action ">Quản lý danh mục</a>
        </div>

        <div class="col">
        <h3 class="text-center font-weight-bolder">Quản lý mã thẻ</h3>
            <div class="font-weight-bolder">
                Tổng giá trị tiền thẻ chưa nạp: <span class="badge badge-info">520 000 <span>đ
            </div>

            <div class="mt-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="menhgia">Mệnh giá</label>
                    </div>
                    <select class="custom-select" id="menhgia">
                        <option value="50" selected>50 000 VNĐ</option>
                        <option value="100">100 000 VNĐ</option>
                        <option value="200">200 000 VNĐ</option>
                        <option value="500">500 000 VNĐ</option>
                    </select>
                </div>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Số lượng</span>
                    <input type="number" class="form-control" placeholder="Số lượng thẻ" aria-label="card-count">
                </div>
                
                <button class="btn btn-success mt-3">Tạo mã thẻ</button>
            </div>
            
            <h5 class="font-weight-normal mt-5">Danh sách mã thẻ vừa được tạo thành công</h5>

            <table class="table m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã thẻ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>121212312124121321</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>121212312124121321</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>121212312124121321</td>
                </tr>
            </tbody>
            </table>


            <h5 class="font-weight-light mt-5">Danh sách mã thẻ đã tạo trước đây</h5>
            <table class="table table-striped m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã thẻ</th>
                <th scope="col">Mệnh giá</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>121212312124121321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                    <td><span class="badge badge-secondary"> Đã dùng </span></td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>121212312124121321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                    <td><span class="badge badge-success"> Chưa dùng </span></td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>121212312124121321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                    <td><span class="badge badge-secondary"> Đã dùng </span></td>
                </tr>
            </tbody>
            </table>

        </div>
    
    </div>


</div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>