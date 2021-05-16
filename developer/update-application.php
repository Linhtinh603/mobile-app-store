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
    $pdo = Common::getPdo();
    $DOMAIN_URL = Config::get('publicPath');

    AccountUtility::requireLogin();
    if(!AccountUtility::isDev()){
        ViewUtility::redirectUrl();
    }
    if(!isset($_GET['id'])){
        ViewUtility::redirectUrl();
    }

    $app_id_get = $_GET['id'];

    $now = date('Y-m-d H:i:s');
    $user_id_current = AccountUtility::getId();

    $sql_get_user = "SELECT * from accounts where id = $user_id_current";

    $balance = 0;
    foreach($pdo->query($sql_get_user) as $val){
        $user_cd = $val['id'];
    }

    $sql_get_app = "SELECT * from apps where id = $app_id_get";
    $name = $icon = $descript = $descript_detail = $img_list = $category = $file_setting = '';
    $price = 0;
    $status = 0;
    $size = 0;
    foreach($pdo->query($sql_get_app) as $v){
        $name = $v['name'];
        $icon = $v['icon'];
        $descript =  $v['short_description'];
        $descript_detail =  $v['detail_description'];
        $img_list =  $v['images'];
        $category =  $v['category_id'];
        $file_setting = $v['download_location'];
        $price = $v['price'];
        $status = $v['status'];
        $size = $v['status'];
    }

    $sql_get_category = "SELECT * from categories";

    if(isset($_POST['postApp']) && $_POST['postApp']){
        $name_p = $_POST['name'];
        $descript_p = isset($_POST['descript']) && $_POST['descript'] ? $_POST['descript'] : '';
        $descript_detail_p = isset($_POST['descript_detail']) && $_POST['descript_detail'] ? $_POST['descript_detail'] : '';
        $category_p = $_POST['category'];
        $price_p = isset($_POST['price']) && $_POST['price'] ? $_POST['price'] : 0;
      
        $update_state = 0;
        if(isset($_POST['checkPostAppSave']) && $_POST['checkPostAppSave']){
            $update_state = 1;
        }
        // nếu status hiện tại = 0 và update_state mới nhận được là 1 thì mới update lại status = 1
        $update_status = '';
        if($status == 0 && $update_state == 1){
            $update_status = ' ,status = 1 ';
        }
        
        $sql_update_app = "UPDATE apps set name = '$name_p',short_description = '$descript_p', detail_description = '$descript_detail_p',
                                    category_id = '$category_p', price= '$price_p', created_time = '$now' $update_status
                                    where id = $app_id_get";
        $update_app = $pdo->exec($sql_update_app);
    
        $id_apps = $app_id_get;

        // upload icon app
        $sql_icon = $icon;
        if(!isset($_FILES['icon']) || $_FILES['icon']['error'] > 0){
        }
        else{
            $path_img = "../public/upload_app_icon/$id_apps";
            $path_upload = "../public/upload_app_icon/$id_apps/0";
            $v = uploadOneImg('icon', $path_img, $path_upload);

            $sql_icon = "upload_app_icon/$id_apps/0.jpg"; 
        }

        // upload list img
        $sql_list_img = $img_list;
        $total = count($_FILES['img_list']['name']);
        if($total > 0){
            $path_img = "../public/upload_app_images/$id_apps";
            $path_upload = "../public/upload_app_images/$id_apps/";
            $list_img = uploadMultipleImg('img_list',$total, $path_img, $path_upload);
            $list_img = $list_img;

            $sql_list_img = $list_img;
        }

        // upload file .zip
        $sql_get_size_zip = $size;
        $download_location = $file_setting;
        if($status == 2){
            // nếu đã duyệt thì không đổi được file cài đặt
        }else{
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
                    }
                }
            }
        }

        $sql_update_post_app = "UPDATE apps set icon = '$sql_icon',images = '$sql_list_img', 
                                    size = $sql_get_size_zip, download_location = '$download_location'
                                where id = $id_apps";
        $pdo->exec($sql_update_post_app);
        
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
            <li class="breadcrumb-item active" aria-current="page">Cập nhật ứng dụng</li>
            
    </nav>

    <div class="developer-body shadow-sm p-3 m-4 bg-white rounded">
        <h3 class="text-center font-weight-bolder">Cập nhật thông tin ứng dụng</h3>
        <span style="color:red">(*)</span> Yêu cầu bắt buộc nhập/ Nếu đăng tải không lưu nháp thì yêu cầu nhập hết các trường
        <form action="" method="post" id="submitFormPostApp" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="font-weight-bold">Tên ứng dụng <span style="color:red">(*)</span> </label>
                <input type="text" class="form-control" id="name" placeholder="Vui lòng nhập tên ứng dụng" name="name" value="<?=$name?>">
            </div>
            <div class="form-group">
                <label for="icon" class="font-weight-bold">Icon ứng dụng (File JPG, PNG, JPEG)</label>
                <?php if($icon){ ?>
                    <br>
                    <label class="font-weight-light">Bạn đã chọn FILE nếu muốn thay đổi hay chọn lại!</label>
                <?php } ?>
                <input type="file" class="form-control-file" id="icon" name="icon" value="<?=$DOMAIN_URL.$icon?>" accept="image/png, image/jpeg">
            </div>
            <div class="form-group">
                <label for="descript" class="font-weight-bold">Mô tả ngắn</label>
                <input type="text" class="form-control" id="descript" placeholder="Vui lòng nhập mô tả ngắn" name="descript" value="<?=$descript?>">
            </div>
            <div class="form-group">
                <label for="descript_detail" class="font-weight-bold">Mô tả chi tiết</label>
                <textarea type="text" class="form-control" id="descript_detail" placeholder="Vui lòng nhập mô tả chi tiết" name="descript_detail"><?=$descript_detail?></textarea>
            </div>
            <div class="form-group">
                <label for="img_list" class="font-weight-bold">Danh sách ảnh giới thiệu (File JPG, PNG, JPEG)</label>
                <?php if($img_list){ ?>
                    <br>
                    <label class="font-weight-light">Bạn đã chọn FILE nếu muốn thay đổi hay chọn lại!</label>
                <?php } ?>
                <input type="file" class="form-control-file" id="img_list" name="img_list[]"  multiple="multiple" accept="image/png, image/jpeg">
            </div>
            <div class="form-group">
                <label for="category" class="font-weight-bold">Thể loại <span style="color:red">(*)</span> </label>
                <select class="form-control" id="category" name="category">
                    <?php foreach($pdo->query($sql_get_category) as $v){ ?>
                        <option value="<?=$v['id']?>" <?php if($category == $v['id']){echo 'selected';}?>><?=$v['name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category_app" class="font-weight-bold">Loại ứng dụng <span style="color:red">(*)</span> </label>
                <select class="form-control" id="category_app" name="category_app">
                    <option value="free" <?php if($price == 0){echo 'selected';} ?>>Miễn Phí</option>
                    <option value="not_free" <?php if($price > 0){echo 'selected';} ?>>Có Phí</option>
                </select>
            </div>
            <div class="form-group" style="display: none;" id="show-price-app">
                <label for="price" class="font-weight-bold">Giá bán: </label>
                <input type="number" class="form-control" id="price" value="<?=$price?>"
                    placeholder="Vui lòng nhập giá bán cho ứng dụng có phí" name="price">
            </div>
            <div class="form-group">
                <label for="file_setting" class="font-weight-bold">Upload file cài đặt (File .zip): (Dung lượng tối đa: 1000000)</label>
                <?php if(!$file_setting){ ?>
                    <input type="file" class="form-control-file" id="file_setting" <?php if($status == 2){echo 'disabled';} ?>
                        name="file_setting" accept="zip/*" >
                <?php }else{ ?>
                    <br>
                    <label class="font-weight-light">Bạn đã UPLOAD FILE và không thể thay đổi</label>
                <?php } ?>
            </div>

            <input type="hidden" id="checkIcon" value="<?=$icon?>">
            <input type="hidden" id="checkImgList" value="<?=$name?>">
            <input type="hidden" id="checkFileSetting">
            <input type="hidden" name="postApp" value="1">
            <input type="hidden" name="checkPostAppSave" id="checkPostAppSave" value = "">
            
            <?php if($status == 0){ ?>
                <button type="button" class="btn btn-success" onclick="clickPostAppTemp()"> Thay đổi thông tin </button>
            <?php } ?>
            <?php if($status == 2 || $status == 1){ ?>
                <button type="button" class="btn btn-success" onclick="clickPostApp()"> Cập nhật ứng dụng </button>
            <?php } ?>
            <!-- Chỉ hiển thị khi app đó đang ở bản nháp-->
            <?php if($status == 0){ ?>
                <button type="button" class="btn btn-primary" onclick="clickPostApp()">Đăng tải </button>
            <?php } ?>
        </form>
    </div>
    <div class="developer-footer">

    </div>
</body>
<script>
    var status = <?= $status ?>;
    var file_setting = '<?=$file_setting?>';
    var icon_p = '<?=$icon?>';
    var img_list_p = '<?=$img_list?>';

</script>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

