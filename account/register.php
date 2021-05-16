<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

if (AccountUtility::isLogin()) {
    ViewUtility::redirectUrl();
}

$validate = [];
$data = [];

function processPost()
{
    global $validate;
    global $data;

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $fullName = $_POST['fullName'] ?? '';

    $data['email'] = $email;
    $data['password'] = $password;
    $data['fullName'] = $fullName;

    if (!ViewUtility::notBlank($email)) {
        $validate['email'] = 'Email bị trống';
    } else if (!ViewUtility::vaildBetween($email, 5, 255)) {
        $validate['email'] = 'Email phải có ít nhất 5 ký tự và tối đa 255 ký tự';
    }

    if (!ViewUtility::notBlank($password)) {
        $validate['password'] = 'Mật khẩu bị trống';
    } else if (!ViewUtility::vaildMinLength($password, 5)) {
        $validate['password'] = 'Mật khẩu phải có ít nhất 5 ký tự';
    }

    if (!ViewUtility::notBlank($fullName)) {
        $validate['fullName'] = 'Họ và tên bị trống';
    }

    if (!isset($_FILES['avatar']) || $_FILES['avatar']['size'] == 0) {
        $validate['avatar'] = 'Vui lòng chọn ảnh đại diện';
    }

    if (count($validate) > 0) {
        return;
    }

    $pdo = Common::getPdo();
    $sql = 'SELECT * FROM accounts WHERE email= :email LIMIT 1';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':email' => $email));

    $red = $sth->fetchAll();
    if (count($red) == 1) {
        $validate['email'] = 'Email này đã được sử dụng';
        return;
    }

    

    $password = md5($password);

    $sql = 'INSERT INTO accounts (email,password,account_type, full_name,balance )';
    $sql .= ' VALUES (:email,:password,:account_type,:full_name,:balance)';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute([
        ':email' => $email,
        ':password' => $password,
        ':account_type' => 1,
        ':full_name' => $fullName,
        ':balance' => 0
    ]);

    $sql = 'SELECT * FROM accounts WHERE email= :email AND password = :password LIMIT 1';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $params = array(':email' => $email, ':password' => $password);
    $sth->execute($params);
    $red = $sth->fetchAll();
    AccountUtility::setLogin($red[0]);

    $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));
    $publicPathAvatar = 'upload_avatar/'. AccountUtility::getId() . '.' . $imageFileType;
    $target_file = __DIR__ . '/../public/' . $publicPathAvatar;
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);

    $sql = 'UPDATE accounts SET avatar = :avatar where id = :id';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute([
        ':id' => AccountUtility::getId(),
        ':avatar' => $publicPathAvatar,
    ]);
    ViewUtility::redirectUrl();
}
if (ViewUtility::isPostReq()) {
    processPost();
}

?>
<html>

<head>
    <title>Đăng ký</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
</head>

<body class="index">
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-sm-10 col-md-8 mt-5" method="post" enctype="multipart/form-data" action="">
                <h2>Đăng ký</h2>
                <?php if (isset($validate['register'])) { ?>
                    <div class="text-danger">
                        <?= $validate['register'] ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" value="<?= isset($data['email']) ? $data['email'] : ''  ?>" placeholder="email" type="email" class="form-control <?= isset($validate['email']) ? 'is-invalid' : '' ?>" id="email" aria-describedby="emailHelp">
                    <?php if (isset($validate['email'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['email'] ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input name="password" value="<?= isset($data['password']) ? $data['password'] : ''  ?>" placeholder="mật khẩu" type="password" class="form-control <?= isset($validate['password']) ? 'is-invalid' : '' ?>" id="password">
                    <?php if (isset($validate['password'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['password'] ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="fullName">Họ và tên</label>
                    <input name="fullName" value="<?= isset($data['fullName']) ? $data['fullName'] : ''  ?>" placeholder="Họ và tên" class="form-control <?= isset($validate['fullName']) ? 'is-invalid' : '' ?>" id="fullName">
                    <?php if (isset($validate['fullName'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['fullName'] ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="avatar" class="">Chọn ảnh đại diện</label>
                    <input name="avatar" type="file" accept="image/x-png,image/jpeg" class="form-control-file <?= isset($validate['avatar']) ? 'is-invalid' : '' ?>" id="avatar">
                    <?php if (isset($validate['avatar'])) { ?>
                        <div class="invalid-feedback">
                            <?= $validate['avatar'] ?>
                        </div>
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Đăng ký</button>
            </form>
        </div>
    </div>
</body>

</html>