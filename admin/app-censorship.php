<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Kiểm duyệt ứng dụng - Admin</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="kiemduyetungdung">
<div class="shadow-sm p-2 m-2 bg-white rounded">
        
<div class="row m-3">

    <div class="col-2 list-group list-group-flush">
        <a href="./"
            class="list-group-item list-group-item-action ">Thống kê</a>
        <a href="#"
            class="list-group-item list-group-item-action active">Kiểm duyệt ứng dụng</a> 
        <a href="./money-card.php"
            class="list-group-item list-group-item-action">Quản lý mã thẻ</a>
        <a href="./category"
            class="list-group-item list-group-item-action ">Quản lý danh mục</a>
    </div>

    <div class="col">
        
        <h3 class="text-center font-weight-bolder">Danh sách ứng dụng đang chờ duyệt</h3>
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
                <th scope="col">Nhà phát triển</th>
                <th scope="col">Tác vụ</th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-success"> Miễn phí </span> </td>
                    <td> 0đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                    <td> <a href="./app-detail-censorship.php?app-id=''">Xem chi tiết</a>  <td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-info"> Có phí </span> </td>
                    <td> 12 440đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                    <td> <a href="./app-detail-censorship.php?app-id=''">Xem chi tiết</a>  <td>
                </tr>
            </tbody>
        </table>



        <h3 class="text-center font-weight-bolder mt-5">Danh sách ứng dụng đã từ chối</h3>
        <p class="font-weight-lighter">Dưới đây là danh sách ứng dụng đã được bạn từ chối, nhưng chưa được gỡ bỏ từ nhà phát triển.<br>
            Ứng dụng đã từ chối sẽ không hiển thị lên trên trang web.
        </p>
        <table class="table table-hover table-secondary m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên ứng dụng</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Loại ứng dụng</th>
                <th scope="col">Giá bán</th>
                <th scope="col">Nhà phát triển</th>   
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-success"> Miễn phí </span> </td>
                    <td> 0đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-success"> Miễn phí </span> </td>
                    <td> 0đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>