<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;
?>
<html>
<head>
<?php require_once '../layout/head.php'; ?>
<?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<?php
// check log in 
    AccountUtility::requireLogin();
    if (!AccountUtility::isUser()) {
        ViewUtility::redirectUrl();
    }

    $pdo = Common::getPdo();
    $DOMAIN_URL = Config::get('publicPath');

    $user_id_current = AccountUtility::getId();
    
    $sql_get_user = "SELECT * from accounts where id = $user_id_current and account_type = 1";
    $balance = 0;
    foreach($pdo->query($sql_get_user) as $val){
        $user_cd = $val['id'];
        $balance = $val['balance'];
    }

    if(isset($_POST['uprade']) && $_POST['uprade']){
        $develop_name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $img_extension1 = strtolower(pathinfo($_FILES["img_cmnd_1"]["name"],PATHINFO_EXTENSION));
        $img_extension2 = strtolower(pathinfo($_FILES["img_cmnd_1"]["name"],PATHINFO_EXTENSION));
        $balance_p =  $balance - 500000;
        uploadImg($user_cd, 'img_cmnd_1',$img_extension1);
        uploadImg($user_cd, 'img_cmnd_2',$img_extension2);
      
        $sql_update_uprade = "UPDATE accounts SET 
                                account_type = 2,
                                developer_name = '$develop_name', developer_email = '$email', 
                                developer_phone_number = '$phone', developer_address = '$address',
                                cmnd_front_image = 'upload_cmnd/$user_cd/img_cmnd_1.$img_extension1',
                                cmnd_back_image = 'upload_cmnd/$user_cd/img_cmnd_2.$img_extension2',
                                balance = $balance_p
                            WHERE id = $user_cd ";
        $pdo->exec($sql_update_uprade);   
        AccountUtility::set('account_type', AccountUtility::DEV);
        ViewUtility::redirectUrl('account');
        
        unset($_POST);
    }

    function uploadImg($user_cd, $img_name ,$img_extension){
        $path_img = "../public/upload_cmnd/".$user_cd;
        $path_upload = "../public/upload_cmnd/".$user_cd.'/'.$img_name.'.'.$img_extension;

        if (!file_exists($path_img)) {
            mkdir($path_img, 0777);
        }

        copy($_FILES[$img_name]['tmp_name'],  $path_upload);
    }

?>

<body class="developer-index">

    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">N??ng c???p t??i kho???n</li> <!-- Ti??u ????? c???n thay ?????i t??? ?????ng-->
            </ol>
    </nav>

    <div class="developer-body">
        <h3 class="text-center font-weight-bolder">N??ng c???p l??n t??i kho???n Developer</h3>

        <div class="form-group row css-div-check-money m-4">
                <label for="money" class="col-md-6 font-weight-bold" >
                    S??? ti???n hi???n c??: 
                    <span class="balance_user"><?=$balance?></span>
                </label>
                <label class="col-md-6 font-weight-bold"> 
                    S??? ti???n c???n thanh to??n: 
                    <span>500,000??</span>
                </label>
                <br>
                <?php
                    if($balance < 500000){
                ?>
                 <label class="color-red">  B???n kh??ng ????? ti???n ????? thanh to??n , vui l??ng n???p th??m v??o t??i kho???n </label>
                 <a href="../account/balance.php"><button type="button" class="btn btn-outline-info ml-5">N???p ngay</button></a>
                <?php
                    }
                ?>
            </div>

        <span style="color:red">(*)</span> Y??u c???u b???t bu???c nh???p
        <form action="" method="post" id="submitFormUprade" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="font-weight-bold">T??n nh?? ph??t tri???n <span class="color-red">(*)</span> </label>
                <input type="text" class="form-control" id="name" placeholder="Vui l??ng nh???p t??n" name="name">
            </div>
            <div class="form-group">
                <label for="address" class="font-weight-bold">?????a ch??? <span class="color-red">(*)</span> </label>
                <input type="text" class="form-control" id="address" placeholder="Vui l??ng nh???p ?????a ch???" name="address">
            </div>
            <div class="form-group">
                <label for="email" class="font-weight-bold">Email <span class="color-red">(*)</span>  </label>
                <input type="email" class="form-control" id="email" placeholder="Vui l??ng nh???p email" name="email">
            </div>
            <div class="form-group">
                <label for="phone" class="font-weight-bold">S??? ??i???n tho???i <span class="color-red">(*)</span> </label>
                <input type="number" class="form-control" id="phone" placeholder="Vui l??ng nh???p s??? ??i???n tho???i" name="phone">
            </div>
            <div class="form-group">
                <input type="hidden" id="checkImg1">
                <label for="img_cmnd_1">T???i l??n ch???ng minh nh??n d??n m???t tr?????c</label>
                <input type="file" accept="image/x-png,image/jpeg" class="form-control-file" id="img_cmnd_1" name="img_cmnd_1">
            </div>
            <div class="form-group">
                <input type="hidden" id="checkImg2">
                <label for="img_cmnd_2">T???i l??n ch???ng minh nh??n d??n m???t sau</label>
                <input type="file" accept="image/x-png,image/jpeg" class="form-control-file" id="img_cmnd_2"  name="img_cmnd_2">
            </div>
            <input type="hidden" value="uprade" name="uprade">
            <p class="font-weight-lighter">L??u ??: B???n s??? b??? tr??? 500 000?? ????? th???c hi???n n??ng c???p t??i kho???n.
            </p>
            <button type="button" class="btn btn-primary" onclick="clickUprade()">N??ng c???p</button>
        </form>
    </div>

    <div class="developer-footer">

    </div>
</body>
<script>
    var balance = <?=$balance?>;
</script>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

