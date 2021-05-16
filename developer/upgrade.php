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

    if (AccountUtility::isDev()) {
        ViewUtility::redirectUrl('account/');
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
        $img_extension1 = strtolower(pathinfo($_FILES["img_cmnd_1"]["tmp_name"],PATHINFO_EXTENSION));
        $img_extension2 = strtolower(pathinfo($_FILES["img_cmnd_1"]["tmp_name"],PATHINFO_EXTENSION));
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

        unset($_POST);
    }

    function uploadImg($user_cd, $img_name ,$img_extension){
        $path_img = "../public/upload_cmnd/".$user_cd;
        $path_upload = "../public/upload_cmnd/".$user_cd.'/'.$img_name.$img_extension;

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
                <li class="breadcrumb-item active" aria-current="page">Nâng cấp tài khoản</li> <!-- Tiêu đề cần thay đổi tự động-->
            </ol>
    </nav>

    <div class="developer-body">
        <h3 class="text-center font-weight-bolder">Nâng cấp lên tài khoản Developer</h3>

        <div class="form-group row css-div-check-money m-4">
                <label for="money" class="col-md-6 font-weight-bold" >
                    Số tiền hiện có: 
                    <span class="balance_user"><?=$balance?></span>
                </label>
                <label class="col-md-6 font-weight-bold"> 
                    Số tiền cần thanh toán: 
                    <span>500,000đ</span>
                </label>
                <br>
                <?php
                    if($balance < 500000){
                ?>
                 <label class="color-red">  Bạn không đủ tiền để thanh toán , vui lòng nạp thêm vào tài khoản </label>
                 <a href="../account/balance.php"><button type="button" class="btn btn-outline-info ml-5">Nạp ngay</button></a>
                <?php
                    }
                ?>
            </div>

        <span style="color:red">(*)</span> Yêu cầu bắt buộc nhập
        <form action="" method="post" id="submitFormUprade" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name" class="font-weight-bold">Tên nhà phát triển <span class="color-red">(*)</span> </label>
                <input type="text" class="form-control" id="name" placeholder="Vui lòng nhập tên" name="name">
            </div>
            <div class="form-group">
                <label for="address" class="font-weight-bold">Địa chỉ <span class="color-red">(*)</span> </label>
                <input type="text" class="form-control" id="address" placeholder="Vui lòng nhập địa chỉ" name="address">
            </div>
            <div class="form-group">
                <label for="email" class="font-weight-bold">Email <span class="color-red">(*)</span>  </label>
                <input type="email" class="form-control" id="email" placeholder="Vui lòng nhập email" name="email">
            </div>
            <div class="form-group">
                <label for="phone" class="font-weight-bold">Số điện thoại <span class="color-red">(*)</span> </label>
                <input type="number" class="form-control" id="phone" placeholder="Vui lòng nhập số điện thoại" name="phone">
            </div>
            <div class="form-group">
                <input type="hidden" id="checkImg1">
                <label for="img_cmnd_1">Tải lên chứng minh nhân dân mặt trước</label>
                <input type="file" accept="image/x-png,image/jpeg" class="form-control-file" id="img_cmnd_1" name="img_cmnd_1">
            </div>
            <div class="form-group">
                <input type="hidden" id="checkImg2">
                <label for="img_cmnd_2">Tải lên chứng minh nhân dân mặt sau</label>
                <input type="file" accept="image/x-png,image/jpeg" class="form-control-file" id="img_cmnd_2"  name="img_cmnd_2">
            </div>
            <div class="form-group row css-div-check-money">
                <label for="money" class="col-md-6">
                    Số tiền hiện có: 
                    <span class="balance_user"><?=$balance?></span>
                </label>
                <label class="col-md-6"> 
                    Số tiền cần thanh toán: 
                    <span>500,000</span>
                </label>
                <br>
                <?php
                    if($balance < 500000){
                ?>
                 <label class="color-red">  Bạn không đủ tiền để thanh toán , vui lòng nạp thêm vào tài khoản </label>
                <?php
                    }
                ?>
            </div>
            <input type="hidden" value="uprade" name="uprade">
            <p class="font-weight-lighter">Lưu ý: Bạn sẽ bị trừ 500 000đ để thực hiện nâng cấp tài khoản.
            </p>
            <button type="button" class="btn btn-primary" onclick="clickUprade()">Nâng cấp</button>
        </form>
    </div>

    <div class="developer-footer">

    </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

<script>

    $("#img_cmnd_1" ).change(function() {
        if (this.files[0].size > 0) {
            $('#checkImg1').val('1');
        }else{
            $('#checkImg1').val('');
        }
    });

    $("#img_cmnd_2" ).change(function() {
        if (this.files[0].size > 0) {
            $('#checkImg2').val('1');
        }else{
            $('#checkImg2').val('');
        }
    });

    function clickUprade(){
         var name = $('#name').val(),
            address = $('#address').val(),
            email = $('#email').val(),
            phone = $('#phone').val(),
            checkImg1 = $('#checkImg1').val(),
            checkImg2 = $('#checkImg2').val(),
            balance = <?=$balance?>;
        
        if(!name || !address || !email || !phone || !checkImg1 || !checkImg2){
            alert('Vui lòng nhập đầy đủ thông tin');
            return;
        }

        if(balance < 500000){
            alert('Bạn không đủ tiền để thanh toán');
            return;
        }

        $('#submitFormUprade').submit();

    }



</script>