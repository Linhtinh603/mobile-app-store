<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Quản lý danh mục - Admin</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="kiemduyetungdung">
<div class="shadow-sm p-2 m-2 bg-white rounded">
        
<div class="row m-3">

    <div class="col-2 list-group list-group-flush">
        <a href="./"
            class="list-group-item list-group-item-action ">Thống kê</a>
        <a href="./app-censorship.php"
            class="list-group-item list-group-item-action ">Kiểm duyệt ứng dụng</a> 
        <a href="./money-card.php"
            class="list-group-item list-group-item-action">Quản lý mã thẻ</a>
        <a href="#"
            class="list-group-item list-group-item-action active">Quản lý danh mục</a>
    </div>

    <div class="col">
        
        <h3 class="text-center font-weight-bolder">Quản lý danh mục</h3>

        <h5>Thêm mới danh mục</h5>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nhập tên danh mục">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Thêm</button>
            </div>
        </div>


        <table class="table table-hover m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên danh mục</th>
                <th scope="col">Tác vụ</th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <th scope="row">1</th>
                    <td> <input value="Trò chơi" class="form-control" > </input></td>
                    <td> <a href="">Cập nhật</a>   |
                            <a href="">Xoá</a>
                    <td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td> <input value="Mua sắm" class="form-control" > </input></td>
                    <td> <a href="">Cập nhật</a>   |
                            <a href="">Xoá</a>
                    <td>
                </tr>
            </tbody>
        </table>


    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>