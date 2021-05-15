<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

AccountUtility::requireLogin();

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
    <title>Thay đổi mật khẩu</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
</head>

<body class="index">
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-sm-10 col-md-8 mt-5" method="post" action="">
                <h1>Đổi mật khẩu</h1>
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
                <div class="form-group">
                    <label for="oldPassword">Mật khẩu cũ</label>
                    <input name="oldPassword" value="<?= isset($data['oldPassword']) ? $data['oldPassword'] : ''  ?>" placeholder="mật khẩu cũ" type="password" class="form-control <?= isset($validate['oldPassword']) ? 'is-invalid' : '' ?>" id="oldPassword">
                    <?php if (isset($validate['oldPassword'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['oldPassword'] ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="newPassword">Mật khẩu mới</label>
                    <input name="newPassword" value="<?= isset($data['newPassword']) ? $data['newPassword'] : ''  ?>" placeholder="mật khẩu mới" type="password" class="form-control <?= isset($validate['newPassword']) ? 'is-invalid' : '' ?>" id="newPassword">
                    <?php if (isset($validate['newPassword'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['newPassword'] ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="reNewPassword">Nhập mẫu mới</label>
                    <input name="reNewPassword" value="<?= isset($data['reNewPassword']) ? $data['reNewPassword'] : ''  ?>" placeholder="mật khẩu mới" type="password" class="form-control <?= isset($validate['reNewPassword']) ? 'is-invalid' : '' ?>" id="reNewPassword">
                    <?php if (isset($validate['reNewPassword'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['reNewPassword'] ?>
                        </div>
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Đổi</button>
            </form>
        </div>
    </div>
</body>

</html>