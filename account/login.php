<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

if(AccountUtility::isLogin()){
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
    $data['email'] = $email;
    $data['password'] = $password;

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

    if (count($validate) > 0) {
        return;
    }

    $password = md5($password);
    $pdo = Common::getPdo();
    $sql = 'SELECT * FROM accounts WHERE email= :email AND password = :password LIMIT 1';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':email' => $email, ':password' => $password));
    $red = $sth->fetchAll();
    if (count($red) == 1) {
        AccountUtility::setLogin($red[0]);
        if(AccountUtility::isAdmin()) {
            ViewUtility::redirectUrl('admin');
        } elseif (isset($_GET['redirect'])) {
            ViewUtility::redirectUrl($_GET['redirect'],true);
        } else {
            ViewUtility::redirectUrl();
        }
    } else {
        $validate['login'] = 'Email hoặc mật khẩu không chính xác';
    }
}
if (ViewUtility::isPostReq()) {
    processPost();
}

?>
<html>

<head>
    <title>Đăng nhập</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
</head>

<body class="index">
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-sm-10 col-md-8 mt-5" method="post" action="">
                <h1>Đăng nhập</h1>
                <?php if (isset($validate['login'])) { ?>
                    <div class="text-danger">
                        <?= $validate['login'] ?>
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
                <!-- <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Tích để nhớ mật khẩu</label>
                </div> -->
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>

</html>