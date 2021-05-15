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

    $fullName = $_POST['full_name'] ?? '';
    $developerName = $_POST['developer_name'] ?? '';
    $developerEmail = $_POST['developer_email'] ?? '';
    $developerPhoneNumber = $_POST['developer_phone_number'] ?? '';
    $developerAddress = $_POST['developer_address'] ?? '';

    $data['full_name'] = $fullName;
    if (AccountUtility::isDev()) {
        $data['developer_name'] = $developerName;
        $data['developer_email'] = $developerEmail;
        $data['developer_phone_number'] = $developerPhoneNumber;
        $data['developer_address'] = $developerAddress;
    }

    if (!ViewUtility::notBlank($fullName)) {
        $validate['full_name'] = 'Họ và tên bị trống';
    } else if (!ViewUtility::vaildMaxLength($fullName, 30)) {
        $validate['full_name'] = 'Họ và tên tối đa 30 ký tự';
    }

    if (AccountUtility::isDev()) {
        if (!ViewUtility::notBlank($developerName)) {
            $validate['developer_name'] = 'Tên nhà phát triển bị trống';
        } else if (!ViewUtility::vaildMaxLength($developerName, 30)) {
            $validate['developer_name'] = 'Mật khẩu tối đa 30 ký tự';
        }

        if (!ViewUtility::notBlank($developerEmail)) {
            $validate['developer_email'] = 'Email nhà phát triển bị trống';
        } else if (!ViewUtility::vaildMaxLength($developerEmail, 255)) {
            $validate['developer_email'] = 'Email tối đa 255 ký tự';
        }

        if (!ViewUtility::notBlank($developerPhoneNumber)) {
            $validate['developer_phone_number'] = 'Số điện thoại nhà phát triển bị trống';
        } else if (!ViewUtility::vaildMaxLength($developerPhoneNumber, 11)) {
            $validate['developer_phone_number'] = 'Số điện thoại tối đa 11 ký tự';
        }

        if (!ViewUtility::notBlank($developerAddress)) {
            $validate['developer_address'] = 'Số điện thoại nhà phát triển bị trống';
        } else if (!ViewUtility::vaildMaxLength($developerAddress, 100)) {
            $validate['developer_address'] = 'Số điện thoại tối đa 100 ký tự';
        }
    }

    if (count($validate) > 0) {
        return;
    }

    $pdo = Common::getPdo();
    $sql = '';
    if(AccountUtility::isDev()){
        $param = [
            ':full_name' => $fullName,
            ':developer_name' => $developerName,
            ':developer_email' => $developerEmail,
            ':developer_phone_number' => $developerPhoneNumber,
            ':developer_address' => $developerAddress,
            ':id' => AccountUtility::getId()
        ];
        $sql = 'UPDATE accounts SET full_name = :full_name , developer_name = :developer_name , developer_email = :developer_email , ';
        $sql .= ' developer_phone_number = :developer_phone_number , developer_address = :developer_address where id = :id ';
    } else {
        $param = [
            ':full_name' => $fullName,
            ':id' => AccountUtility::getId()
        ];
        $sql = 'UPDATE accounts SET full_name = :full_name where id = :id ';
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($param);
}

if (ViewUtility::isPostReq()) {
    processPost();
} else {
    $data['full_name'] = $account['full_name'];
    if (AccountUtility::isDev()) {
        $data['developer_name'] = $account['developer_name'];
        $data['developer_email'] = $account['developer_email'];
        $data['developer_phone_number'] = $account['developer_phone_number'];
        $data['developer_address'] = $account['developer_address'];
    }
}
?>
<html>

<head>
    <title>Cập nhật thông tin cá nhân</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="capnhatthongtin">

    <div class="container-fluid">
        <section class="shadow-sm p-3 m-3 bg-white rounded">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../">Home</a></li>
                    <li class="breadcrumb-item"><a href="./">Thông tin cá nhân</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cập nhật thông tin</li>
                </ol>
            </nav>


            <div class="col">
                <h3 class="text-center font-weight-bolder">Thay đổi thông tin cá nhân</h3>
                <img>

                <form action="" method="post">
                    <div>
                        <table class="table">
                            <tr>
                                <th scope="row">Họ tên</th>
                                <td>
                                    <div class="form-group">
                                        <input type="text" value="<?= $data['full_name'] ?>" class="form-control <?= isset($validate['full_name']) ? 'is-invalid' : '' ?>" id="full_name" name="full_name">
                                        <?php if (isset($validate['full_name'])) { ?>
                                            <div class="invalid-feedback">
                                                <?= $validate['full_name'] ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td class="text-muted"><?= $account['email'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Loại tài khoản</th>
                                <td class="text-muted"><?php
                                if (AccountUtility::isAdmin()) {
                                    echo 'Admin';
                                } elseif (AccountUtility::isDev()) {
                                    echo 'Developer';
                                } else {
                                    echo 'User';
                                }
                                ?></td>
                            </tr>
                        </table>
                    </div>

                    <?php if (AccountUtility::isDev()) { ?>
                        <div>
                            <!-- Phần chỉ hiện tại khi tài khoản là Developer-->
                            <h4 class="text-center font-weight mt-5">Thông tin tài khoản Developer của bạn</h4>
                            <table class="table">
                                <tr>
                                    <th scope="row">Tên nhà phát triển</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control <?= isset($validate['developer_name']) ? 'is-invalid' : '' ?>" id="developer_name" value="<?= $data['full_name'] ?>" name="developer_name">
                                            <?php if (isset($validate['developer_name'])) { ?>
                                                <div class="invalid-feedback">
                                                    <?= $validate['developer_name'] ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Email nhà phát triển</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="email" class="form-control <?= isset($validate['developer_email']) ? 'is-invalid' : '' ?>" id="developer_email" value="<?= $data['developer_email'] ?>" name="developer_email">
                                            <?php if (isset($validate['developer_email'])) { ?>
                                                <div class="invalid-feedback">
                                                    <?= $validate['developer_email'] ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Số điện thoại nhà phát triển</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="phone" class="form-control <?= isset($validate['developer_phone_number']) ? 'is-invalid' : '' ?>" id="developer_phone_number" value="<?= $data['developer_phone_number'] ?>" name="developer_phone_number">
                                            <?php if (isset($validate['developer_phone_number'])) { ?>
                                                <div class="invalid-feedback">
                                                    <?= $validate['developer_phone_number'] ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Địa chỉ nhà phát triển</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control <?= isset($validate['developer_address']) ? 'is-invalid' : '' ?>" id="developer_address" value="<?= $data['developer_address'] ?>" name="developer_address">
                                            <?php if (isset($validate['developer_address'])) { ?>
                                                <div class="invalid-feedback">
                                                    <?= $validate['developer_address'] ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <?php } ?>





                    <p class="font-weight-lighter mt-5">Bạn muốn cập nhật lại những thông tin ở trên? </p>
                    <button type="submit" class="btn btn-success">Thực hiện cập nhật</button>
                </form>

                <!-- <p class="font-weight-lighter mt-5">Bạn muốn đổi mật khẩu? </p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nhập mật khẩu cũ &nbsp;</span>
                    </div>
                    <input type="text" placeholder="Nhập mật khẩu cũ" aria-label="old-password" class="form-control">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nhập mật khẩu mới</span>
                    </div>
                    <input type="text" placeholder="Nhập mật khẩu mới" aria-label="new-password" class="form-control">
                    <input type="text" placeholder="Nhập lại mật khẩu mới" aria-label="new-password-again" class="form-control">
                </div>
                <button type="button" class="btn btn-success mt-2">Đổi mật khẩu</button> -->
            </div>


    </div>
    </section>
    </div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>

</html>