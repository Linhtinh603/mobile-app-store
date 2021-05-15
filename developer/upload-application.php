<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '__' . DIRECTORY_SEPARATOR . 'bootstrap.php';
use App\Utility\AccountUtility;
use App\Utility\ViewUtility;

?>
<html>
<head>
<title>Đăng tải ứng dụng mới</title>
<?php 
    require_once '../layout/head.php'; 
    require_once __DIR__ . '/../layout/header.php';
?>

</head>

<?php 
    AccountUtility::requireLogin();
    if(!AccountUtility::isDev()){
        ViewUtility::redirectUrl();
    }

    $pdo = Common::getPdo();
    $now = date('Y-m-d H:i:s');
    $user_id_current = AccountUtility::getId();

    $sql_get_user = "SELECT * from accounts where id = $user_id_current";

    $balance = 0;
    foreach($pdo->query($sql_get_user) as $val){
        $user_cd = $val['id'];
    }

    $sql_get_category = "SELECT * from categories";

    if(isset($_POST['postApp']) && $_POST['postApp']){
        $name = $_POST['name'];
        $descript = isset($_POST['descript']) && $_POST['descript'] ? $_POST['descript'] : '';
        $descript_detail = isset($_POST['descript_detail']) && $_POST['descript_detail'] ? $_POST['descript_detail'] : '';
        $category = $_POST['category'];
        $price = isset($_POST['price']) && $_POST['price'] ? $_POST['price'] : 0;
      
        $sql_insert_app_post = "INSERT into apps(name, short_description, detail_description, category_id, price, status, created_by, created_time)
                                values ('{$name}', '{$descript}', '{$descript_detail}', '{$category}', '{$price}', 0, '{$user_cd}', '{$now}')";
        $insert_app = $pdo->exec($sql_insert_app_post);   

        if($insert_app){
            // get app_id last
            $sql_get_last_app_id = "SELECT id from apps order by id desc limit 1";
            $id_apps = 0;
            foreach($pdo->query($sql_get_last_app_id) as $v){
                $id_apps = $v['id'];
            }

            // upload icon app
            $sql_icon = '';
            if(!isset($_FILES['icon']) || $_FILES['icon']['error'] > 0){
            }
            else{
                $path_img = "../public/upload_app_icon/$id_apps";
                $path_upload = "../public/upload_app_icon/$id_apps/0";
                $v = uploadOneImg('icon', $path_img, $path_upload);

                $sql_icon = "upload_app_icon/$id_apps/0.jpg"; 
            }

            // upload list img
            $sql_list_img = '';
            $total = count($_FILES['img_list']['name']);
            if(!isset($_FILES['img_list'])){
            }else{
                print_r($_FILES['img_list']['name']);
                print_r($total);
                if($total > 0){
                    $path_img = "../public/upload_app_images/$id_apps";
                    $path_upload = "../public/upload_app_images/$id_apps/";
                    $list_img = uploadMultipleImg('img_list',$total, $path_img, $path_upload);
                    $list_img = $list_img;

                    $sql_list_img = $list_img;
                }
            }

            // upload file .zip
            $sql_get_size_zip = 0;
            $download_location = '';
            if(!isset($_FILES['file_setting']) || $_FILES['file_setting']['error'] > 0){
            }
            else{
                $storeFolder = '../__/file_setting';
                if((!empty($_FILES)) && !empty($_FILES['file_setting']['name'])) {
                    if(preg_match('/[.](zip)$/', $_FILES['file_setting']['name'])) {

                        $tempFile = $_FILES['file_setting']['tmp_name'];
                        $targetPath = $storeFolder . '/'.$id_apps.'/';
                        if (!file_exists($targetPath)) {
                            mkdir($targetPath, 0777);
                        }
                        $targetFile = $targetPath.'0.zip';
                        $check = move_uploaded_file($tempFile,$targetFile);
                        $size_file_zip = filesize("../__/file_setting/$id_apps/0.zip");

                        $sql_get_size_zip = $size_file_zip;
                        $download_location = "$id_apps/0.zip";
                    }
                }
            }

            $sql_update_post_app = "UPDATE apps set icon = '$sql_icon',images = '$sql_list_img', 
                                        size = $sql_get_size_zip, download_location = '$download_location'
                                    where id = $id_apps";
            $pdo->exec($sql_update_post_app);
        }

        ViewUtility::redirectUrl('developer/my-dev-app.php');
    } 

    // function upload 1 img
    function uploadOneImg($img_name, $path_img, $path_upload){
        $img_extension = '.jpg';
        $path_upload = $path_upload.$img_extension;

        if (!file_exists($path_img)) {
            mkdir($path_img, 0777);
        }
        copy($_FILES[$img_name]['tmp_name'],  $path_upload);
    }
    // function upload nhiều img
    function uploadMultipleImg($img_name, $total, $path_img, $path_upload ){
        $str = [];
        for( $i=0 ; $i < $total ; $i++ ) {
            if (!file_exists($path_img)) {
                mkdir($path_img, 0777);
            }
            $tmpFilePath = $_FILES[$img_name]['tmp_name'][$i];
            if ($tmpFilePath != ""){
                $path_upload = $path_upload.$i.'.jpg';
                if(move_uploaded_file($tmpFilePath, $path_upload)) {
                    $str[]= $i;
                }
            }
        }
        return json_encode($str);
    }


?>

<body class="developer-index">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../">Home</a></li>
                <li class="breadcrumb-item"><a href="./my-dev-app.php">Quản lý ứng dụng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đăng tải ứng dụng</li>
            </ol>
    </nav>
    <div class="developer-body shadow-sm p-3 m-4 bg-white rounded">
        <h3 class="text-center font-weight-bolder">Đăng tải ứng dụng mới</h3>
        <span style="color:red">(*)</span> Yêu cầu bắt buộc nhập/ Nếu đăng tải không lưu nháp thì yêu cầu nhập hết các trường
        <form action="" method="post" id="submitFormPostApp" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="font-weight-bold">Tên ứng dụng <span style="color:red">(*)</span> </label>
                <input type="text" class="form-control" id="name" placeholder="Vui lòng nhập tên ứng dụng" name="name">
            </div>
            <div class="form-group">
                <label for="icon" class="font-weight-bold">Icon ứng dụng</label>
                <input type="file" class="form-control-file" id="icon" name="icon">
            </div>
            <div class="form-group">
                <label for="descript" class="font-weight-bold">Mô tả ngắn</label>
                <input type="text" class="form-control" id="descript" placeholder="Vui lòng nhập mô tả ngắn" name="descript">
            </div>
            <div class="form-group">
                <label for="descript_detail" class="font-weight-bold">Mô tả chi tiết</label>
                <textarea type="text" class="form-control" id="descript_detail" placeholder="Vui lòng nhập mô tả chi tiết" name="descript_detail"></textarea>
            </div>
            <div class="form-group">
                <label for="img_list" class="font-weight-bold">Danh sách ảnh giới thiệu </label>
                <input type="file" class="form-control-file" id="img_list" name="img_list[]"  multiple="multiple">
            </div>
            <div class="form-group">
                <label for="category" class="font-weight-bold">Thể loại <span style="color:red">(*)</span> </label>
                <select class="form-control" id="category" name="category">
                    <?php foreach($pdo->query($sql_get_category) as $v){ ?>
                        <option value="<?=$v['id']?>"><?=$v['name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category_app" class="font-weight-bold">Loại ứng dụng <span style="color:red">(*)</span> </label>
                <select class="form-control" id="category_app" name="category_app">
                    <option value="free">Miễn Phí</option>
                    <option value="not_free">Có Phí</option>
                </select>
            </div>
            <div class="form-group" style="display: none;" id="show-price-app">
                <label for="price" class="font-weight-bold">Giá bán: </label>
                <input type="number" class="form-control" id="price" value="0" placeholder="Vui lòng nhập giá bán cho ứng dụng có phí" name="price">
            </div>
            <div class="form-group">
                <label for="file_setting" class="font-weight-bold">Upload file cài đặt: </label>
                <input type="file" class="form-control-file" id="file_setting" name="file_setting" accept="zip/*" >
            </div>

            <p class="font-weight-lighter">Sau khi đăng tải ứng dụng thì bạn cần chờ đợi để quản trị viên duyệt ứng dụng của bạn.
                <br> Bạn có thể kiểm tra trạng thái ứng dụng ở mục quản lý ứng dụng ở tại trang thông tin cá nhân
            </p>
            <p class="font-weight-lighter">Bạn cũng có thể lưu bản nháp ứng dụng này và chỉnh sửa đăng tải lại sau.
            </p>

            <input type="hidden" id="checkIcon">
            <input type="hidden" id="checkImgList">
            <input type="hidden" id="checkFileSetting">
            <input type="hidden" name="postApp" value="1">

            <button type="button" class="btn btn-secondary" onclick="clickPostAppTemp()">Lưu bản nháp</button>
            <button type="button" class="btn btn-primary" onclick="clickPostApp()">Đăng tải</button>
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
            $('#price').val('');
        }
    });

    $("#icon" ).change(function() {
        if (this.files[0].size > 0) {
            $('#checkIcon').val('1');
        }else{
            $('#checkIcon').val('');
        }
    });

    $("#file_setting" ).change(function() {
        if (this.files[0].size >= 1000000) {
            alert('Dung lượng file phải < 1000000');
            return;
        }

        if (this.files[0].size > 0) {
            $('#checkFileSetting').val('1');
        }else{
            $('#checkFileSetting').val('');
        }
        
        if (this.files[0].size > 0) {
            $('#checkFileSetting').val('1');
        }else{
            $('#checkFileSetting').val('');
        }
    });

    $("#img_list" ).change(function() {
        if (this.files[0].size > 0) {
            $('#checkImgList').val('1');
        }else{
            $('#checkImgList').val('');
        }
    });

    function clickPostAppTemp(){
        var name = $('#name').val(),
            descript = $('#descript').val(),
            descript_detail = $('#descript_detail').val(),
            category = $('#category').val(),
            category_app = $('#category_app').val(),
            price = $('#price').val(),
            checkIcon = $('#checkIcon').val(),
            checkFileSetting = $('#checkFileSetting').val(),
            checkImgList = $('#checkImgList').val();

        if(!name || !category || !category_app){
            alert('Bạn phải nhập Name , Tên thể loại , Loại ứng dụng');
            return ;
        }
        $('#submitFormPostApp').submit();
    }


    function clickPostApp(){
        var name = $('#name').val(),
            descript = $('#descript').val(),
            descript_detail = $('#descript_detail').val(),
            category = $('#category').val(),
            category_app = $('#category_app').val(),
            price = new Number($('#price').val()),
            checkIcon = $('#checkIcon').val(),
            checkFileSetting = $('#checkFileSetting').val(),
            checkImgList = $('#checkImgList').val();

        if(!name || !descript || !descript_detail || !category || !category_app 
            || !checkIcon || !checkFileSetting || !checkImgList){
                $er = name + descript + descript_detail + category + category_app + checkIcon + checkFileSetting+ checkImgList;
                console.log($er);

            alert('Bạn phải nhập hết các trường');
            return ;
        }
        if(category_app == 'not_free' && price <= 0){
            alert('Giá phí phải > 0');
            return ;
        }

        $('#submitFormPostApp').submit();
    }

</script>