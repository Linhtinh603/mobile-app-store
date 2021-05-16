<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\AccountUtility;
use App\Utility\ViewUtility;

AccountUtility::requireLogin();

// lay so tien hien tai
$pdo = Common::getPdo();
$sql = 'SELECT balance FROM accounts WHERE id = :id';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':id' => AccountUtility::getId()));
$red = $sth->fetchAll();
$balance = $red[0]['balance'];

// lay lich su nap
$sql = 'SELECT h.*,c.seri_number, c.denomination FROM deposit_history h INNER JOIN cards c ON h.card_id = c.id WHERE h.account_id = :account_id';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':account_id' => AccountUtility::getId()));
$histories = $sth->fetchAll();

$validate = [];
$data = [];

function processPost()
{
    global $validate;
    global $data;

    $seriNumber = $_POST['seriNumber'] ?? '';
    $data['seriNumber'] = $seriNumber;

    if (!ViewUtility::notBlank($seriNumber)) {
        $validate['seriNumber'] = 'Mã thẻ bị trống';
    } else if (!ViewUtility::vaildLength($seriNumber, 16)) {
        $validate['seriNumber'] = 'Mã thẻ phải có 16 ký tự';
    }

    if (count($validate) > 0) {
        return;
    }

    $pdo = Common::getPdo();
    $sql = 'SELECT * FROM cards WHERE seri_number= :seri_number';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':seri_number' => $seriNumber));
    $cards = $sth->fetchAll();

    if (count($cards) == 0) {
        $validate['seriNumber'] = 'Mã này không tồn tại';
    } else if ($cards[0]['used'] == 1) {
        $validate['seriNumber'] = 'Mã này đã được sử dụng';
    } else {
        // update ma the
        $sql = 'UPDATE cards SET used = 1  where id = :id ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $cards[0]['id']]);

        // update tai khoan
        $sql = 'UPDATE accounts SET balance = balance + :balance  where id = :id ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => AccountUtility::getId(), ':balance' => $cards[0]['denomination']]);
        global $balance;
        $balance += $cards[0]['denomination'];

        // insert vao bang history
        $sql = 'INSERT INTO deposit_history (card_id,account_id )';
        $sql .= ' VALUES (:card_id,:account_id)';
        $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute([
            ':card_id' => $cards[0]['id'],
            ':account_id' => AccountUtility::getId()
        ]);

        global $histories;
        $histories[] = ['seri_number'=> $seriNumber , 'denomination'=> $cards[0]['denomination']];
        $data = [];
        $validate['recharge-success'] = 'Nạp tiền thành công';
    }
}

if (ViewUtility::isPostReq()) {
    processPost();
}

?>
<html>

<head>
    <title>Nạp tiền / Lịch sử nạp tiền</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="naptien">
    <div class="shadow-sm p-2 m-2 bg-white rounded">
        <div class="row m-3">

            <div class="col-2 list-group list-group-flush">
                <a href="./" class="list-group-item list-group-item-action ">Thông tin cá nhân</a>
                <a href="./" class="list-group-item list-group-item-action ">Ứng dụng của tôi</a>
                <a href="#" class="list-group-item list-group-item-action active">Nạp tiền / Lịch sử nạp</a>
                <a href="../developer/upgrade.php" class="list-group-item list-group-item-action">Nâng cấp tài khoản</a>
                <a href="../developer/my-dev-app.php" class="list-group-item list-group-item-action">Developer - Quản lý ứng dụng</a>
                <a href="../developer/my-order-list.php" class="list-group-item list-group-item-action">Developer - Xem đơn hàng</a>
            </div>

            <div class="col">
                <h3 class="text-center font-weight-bolder">Thông tin tài khoản</h3>
                <div class="font-weight-bolder">
                    Số dư hiện tại: <span class="badge badge-info"><?= number_format($balance, 0, '', ',') ?> <span>đ
                </div>

                <div>
                    <form action="" method="post" autocomplete="off">
                        <h5 class="font-weight-normal mt-3"> Nạp tiền </h5>
                        <div class="input-group m-3">
                            <input value="<?= isset($data['seriNumber']) ? $data['seriNumber'] : ''  ?>" type="text" name="seriNumber" class="form-control <?= isset($validate['seriNumber']) ? 'is-invalid' : '' ?>" placeholder="Nhập mã số Seri">
                            <div class="input-group-append">
                                <button class="btn btn-outline-info" type="submit" id="button-addon2">Nạp</button>
                            </div>
                        </div>
                        <?php if (isset($validate['seriNumber'])) { ?>
                            <div class="text-danger">
                                <?= $validate['seriNumber'] ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($validate['recharge-success'])) { ?>
                            <div class="text-success">
                                <?= $validate['recharge-success'] ?>
                            </div>
                        <?php } ?>
                    </form>
                </div>


                <h5 class="font-weight-normal">Lịch sử nạp tiền</h5>
                <table class="table table-striped m-3">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Mã thẻ</th>
                            <th scope="col">Mệnh giá</th>
                            <th scope="col">Ngày nạp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $historyIndex = 0;
                        foreach ($histories as $hisotry) { 
                            $historyIndex++;
                        ?>
                            <tr>
                                <th scope="row"><?= $historyIndex ?></th>
                                <td><?= $hisotry['seri_number'] ?></td>
                                <td><?= number_format($hisotry['denomination'], 0, '', ',')  ?> đ</td>
                                <td><?php
                                if(isset($hisotry['created_time'])){
                                    $date = new DateTime($hisotry['created_time']);
                                    echo $date->format('d/m/Y h:m:s');
                                } else {
                                    $date = new DateTime();
                                    echo $date->format('d/m/Y h:m:s');
                                }
                                ?></td>
                            </tr>
                        <?php } ?>
                        <!-- <tr>
                            <th scope="row">2</th>
                            <td>1212*********21321</td>
                            <td>20 000</td>
                            <td>20/12/2020 02:32:22</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>1212*********21321</td>
                            <td>20 000</td>
                            <td>20/12/2020 02:32:22</td>
                        </tr> -->
                    </tbody>
                </table>

            </div>

        </div>


    </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>

</html>