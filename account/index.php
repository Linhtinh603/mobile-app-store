<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\AccountUtility;
use App\Utility\ViewUtility;

AccountUtility::requireLogin();

$pdo = Common::getPdo();
$sql = 'SELECT * FROM accounts WHERE id = :id';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':id' => AccountUtility::getId()));
$red = $sth->fetchAll();
$account = $red[0];
AccountUtility::setLogin($account);

$validate = [];
$data = [];

function processPost()
{
    global $validate;
    global $data;

    $oldPassword = $_POST['oldPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $reNewPassword = $_POST['reNewPassword'] ?? '';
    $data['oldPassword'] = $oldPassword;
    $data['newPassword'] = $newPassword;
    $data['reNewPassword'] = $reNewPassword;

    if (!ViewUtility::notBlank($oldPassword)) {
        $validate['oldPassword'] = 'Mật khẩu cũ bị trống';
    }

    if (!ViewUtility::notBlank($newPassword)) {
        $validate['newPassword'] = 'Mật khẩu mới bị trống';
    } elseif(!ViewUtility::vaildMinLength($newPassword,5)){
        $validate['newPassword'] = 'Mật khẩu mới ít nhất phải có 5 ký tự';
    }

    if (!ViewUtility::notBlank($reNewPassword)) {
        $validate['reNewPassword'] = 'Mật khẩu mới nhập lại bị trống';
    }

    if (count($validate) > 0) {
        return;
    }

    if ($newPassword != $reNewPassword) {
        $validate['reNewPassword'] = 'Mật khẩu nhập lại không khớp';
        return;
    }

    $password = md5($newPassword);
    $oldPassword = md5($oldPassword);
    $pdo = Common::getPdo();

    // validate old password
    $sql = 'SELECT * FROM accounts WHERE email= :email AND password = :password LIMIT 1';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $params = array(':email' => AccountUtility::getEmail(), ':password' => $oldPassword);
    $sth->execute($params);
    $red = $sth->fetchAll();
    if (count($red) == 1) {
        $data = [
            'email' => AccountUtility::getEmail(),
            'password' => $password
        ];
        $sql = 'UPDATE accounts SET password = :password  where email = :email ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $data = [];
        $data['change-passord-success'] = 'Đổi mật khẩu thành công';
    } else {
        $validate['change-passord'] = 'Mật khẩu cũ không chính xác';
    }
}
if (ViewUtility::isPostReq()) {
    processPost();
}

?>
<html>

<head>
    <title>Thông tin cá nhân</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="thongtincanhan">

    <div>
        <section class="container-fluid">
            <div class="row m-3">
                <div class="col-2 list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action active">Thông tin cá nhân</a>
                    <a href="./my-app.php" class="list-group-item list-group-item-action">Ứng dụng của tôi</a>
                    <a href="./balance.php" class="list-group-item list-group-item-action">Nạp tiền / Lịch sử nạp</a>
                    <a href="../developer/upgrade.php" class="list-group-item list-group-item-action">Nâng cấp tài khoản</a>
                    <?php if(AccountUtility::isDev()) { ?>
                        <a href="../developer/my-dev-app.php" class="list-group-item list-group-item-action">Developer - Quản lý ứng dụng</a>
                        <a href="../developer/my-order-list.php" class="list-group-item list-group-item-action">Developer - Xem đơn hàng</a>
                    <?php }?>
                </div>


                <div class="col">
                    <h3 class="text-center font-weight-bolder">Thông tin cá nhân</h3>
                    <div class="d-flex">
                    <img class="avatar" src="<?=  Config::get('publicPath') . 'public/' . AccountUtility::get('avatar') ?>"></img>
                    </div>

                    <table class="table">
                        <tr>
                            <th scope="row">Họ tên</th>
                            <td><?= $account['full_name'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?= $account['email'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Loại tài khoản</th>
                            <td><?php
                                if (AccountUtility::isAdmin()) {
                                    echo 'Admin';
                                } elseif (AccountUtility::isDev()) {
                                    echo 'Developer';
                                } else {
                                    echo 'User';
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Số dư trong tài khoản</th>
                            <td><?= number_format($account['balance'], 0, '', ',') ?> đ</td>
                        </tr>
                    </table>

                    <?php if (AccountUtility::isDev()) { ?>
                        <div>
                            <!-- Phần chỉ hiện tại khi tài khoản là Developer-->
                            <h4 class="text-center font-weight">Thông tin tài khoản Developer của bạn</h4>
                            <table class="table">
                                <tr>
                                    <th scope="row">Tên nhà phát triển</th>
                                    <td><?= $account['developer_name'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email nhà phát triển</th>
                                    <td><?= $account['developer_email'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Số điện thoại nhà phát triển</th>
                                    <td><?= $account['developer_phone_number'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Địa chỉ nhà phát triển</th>
                                    <td><?= $account['developer_address'] ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php } ?>


                    <p class="font-weight-lighter mt-5">Bạn muốn cập nhật lại những thông tin ở trên? </p>
                    <a href="./update-info.php?"><button type="button" class="btn btn-info">Cập nhật thông tin</button></a>

                    <form action="" method="POST"  autocomplete="off" role="presentation">
                        <p class="font-weight-lighter mt-5">Bạn muốn đổi mật khẩu? </p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nhập mật khẩu cũ &nbsp;</span>
                            </div>
                            <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
                            <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
                            <input  autocomplete="new-password" value="<?= isset($data['oldPassword']) ? $data['oldPassword'] : ''  ?>" type="password" placeholder="Nhập mật khẩu cũ" name="oldPassword" class="form-control <?= isset($validate['reNewPassword']) ? 'is-invalid' : '' ?>" >
                        </div>
                        <?php if (isset($validate['oldPassword'])) { ?>
                            <div class="text-danger">
                                <?= $validate['oldPassword'] ?>
                            </div>
                        <?php } ?>
                        <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nhập mật khẩu mới</span>
                            </div>
                            <input value="<?= isset($data['newPassword']) ? $data['newPassword'] : ''  ?>" type="password" placeholder="Nhập mật khẩu mới" aria-label="new-password" class="form-control <?= isset($validate['newPassword']) ? 'is-invalid' : '' ?>" name="newPassword">
                            <input value="<?= isset($data['reNewPassword']) ? $data['reNewPassword'] : ''  ?>" type="password" placeholder="Nhập lại mật khẩu mới" aria-label="new-password-again" class="form-control  <?= isset($validate['reNewPassword']) ? 'is-invalid' : '' ?>" name="reNewPassword">
                        </div>
                        <?php if (isset($validate['newPassword'])) { ?>
                            <div class="text-danger">
                                <?= $validate['newPassword'] ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($validate['reNewPassword'])) { ?>
                            <div class="text-danger">
                                <?= $validate['reNewPassword'] ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($validate['change-passord'])) { ?>
                            <div class="text-danger">
                                <?= $validate['change-passord'] ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($data['change-passord-success'])) { ?>
                            <div class="text-success">
                                <?= $data['change-passord-success'] ?>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-success mt-2">Đổi mật khẩu</button>
                    </form>
                </div>


            </div>
        </section>
    </div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>

</html>