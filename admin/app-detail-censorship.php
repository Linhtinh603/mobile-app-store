<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '__' . DIRECTORY_SEPARATOR . 'bootstrap.php';
?>
<html>
<head>
<title>Duyệt ứng dụng</title>
<?php require_once '../layout/head.php'; ?>
<?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="chitietkiemduyetungdung">

    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../">Home</a></li>
                <li class="breadcrumb-item"><a href="./app-censorship.php">Trang kiểm duyệt ứng dụng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Xem xét duyệt ứng dụng</li>
            </ol>
    </nav>

    <div class="shadow-sm p-3 m-4 bg-white rounded">
        <h3 class="text-center font-weight-bolder">Thông tin ứng dụng cần duyệt</h3>
        <table class="table">      
            <tr>
                img
        </tr>          
            <tr>
                <th scope="row"> <label for="name" class="font-weight-bold">Tên ứng dụng: </label> </th>
                <td>Facebook</td>
            </tr>
            <tr>
                <th scope="row"> <label for="descript" class="font-weight-bold">Mô tả ngắn</label> </th>
                <td>emak@fmafa.nv</td>
            </tr>
            <tr>
                <th scope="row">  <label for="descript_detail" class="font-weight-bold">Mô tả chi tiết</label> </th>
                <td>Developer</td>
            </tr>
            <tr>
                <th scope="row">  <label for="category" class="font-weight-bold">Thể loại </label> </th>
                <td> img </td>
            </tr>
            <tr>
                <th scope="row">  <label for="img_list" class="font-weight-bold">Danh sách ảnh giới thiệu </label> </th>
                <td> img </td>
            </tr>
            <tr>
                <th scope="row">  <label for="app_type" class="font-weight-bold">Loại ứng dụng </label> </th>
                <td> <span class="badge badge-success"> Miễn phí </span> </td>
            </tr>
            <tr>
                <th scope="row">   <label for="price" class="font-weight-bold">Giá bán: </label> </th>
                <td> 25 000đ </td>
            </tr>
            <tr>
                <th scope="row">    <label for="file_setting" class="font-weight-bold">Upload file cài đặt: </label>  </th>
                <td> <buton class="btn btn-info"> Tải xem trước</button> </td> <!-- Chèn link download vào đây-->
            </tr>
        </table>

            <p class="font-weight-lighter">Sau khi bạn nhấn đồng ý, ứng dụng sẽ được hiển thị ở trang web.
                <br> Nếu bạn nhấn từ chối, thì sẽ loại bỏ khỏi danh sách chờ duyêt, và chờ nhà phát triển gỡ bỏ app.
            </p>

            <button type="button" class="btn btn-success" onclick="appApprove()">Đồng ý duyệt</button>
            <button type="button" class="btn btn-secondary" onclick="appDecline()">Từ chối duyệt</button>
          
        </form>
    </div>
    <div class="developer-footer">

    </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

<script>

    $("#category_app" ).change(function() {
        var val = $(this).val();
        if(val == 'not_free'){
            $('#show-price-app').show();
        }else{
            $('#show-price-app').hide();
        }
    });

    function clickPostApp(){
        // name , icon , descript, descript_detail, img_list, category, 
        // category_app, price , file_setting
        $name = $('#name').val();
        $descript = $('#descript').val();
        $descript_detail = $('#descript_detail').val();
        $category = $('#category').val();
        $category_app = $('#category_app').val();
        $price = $('#price').val();

        console.log($name);

        $.ajax({
            method: 'post',
            url: 'ajax/ajax_post_app.php',
            type: 'json',
            data: {
                user_cd : ""
            },
            success: function (res) {
            
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }



</script>