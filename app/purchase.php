<?php

require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\AccountUtility;
use App\Utility\ViewUtility;


function processPost()
{
    if (!AccountUtility::isLogin()) {
        ViewUtility::renderJSON(['err' => 'Phiên đăng nhập đã hết hạn'], 401);
        return;
    }

    $id = $_POST['id'] ?? null;
    $id = intval($id);
    if($id == 0){
        ViewUtility::renderJSON(['err' => 'ID không đúng'], 400);
        return;
    }
    $pdo = Common::getPdo();

    // kiem tra da mua chua
    $sql = 'SELECT COUNT(*) FROM app_purchased_history where app_id = :app_id AND account_id = :account_id';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':app_id' => $id, ':account_id' => AccountUtility::getId()));
    $red = $sth->fetchAll();
    if ($red[0]['COUNT(*)'] != 0) {
        ViewUtility::renderJSON(['err' => 'Bạn đã mua ứng dụng này rồi'], 400);
        return;
    }

    // kiem tra app co phai o trang thai cho tai khong
    $sql = 'SELECT price  FROM apps';
    $sql .= ' WHERE id= :id AND status = 2';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':id' => $id));
    $red = $sth->fetchAll();
    if (count($red) == 0) {
        ViewUtility::renderJSON(['err' => 'Ứng dụng này đã không tồn tại'], 400);
        return;
    }
    $appPrice = $red[0]['price'];

    // kiem tra tien trong tai khoan
    $sql = 'SELECT balance FROM accounts';
    $sql .= ' WHERE id = :account_id ';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':account_id'=> AccountUtility::getId()));
    $red = $sth->fetchAll();
    $balance = $red[0]['balance'];

    if($appPrice > $balance) {
        ViewUtility::renderJSON(['err' => 'Bạn không có đủ tiền trong tài khoản, hãy nạp tiền thêm'], 400);
        return;
    }

    // cap nhat tien lai trong tai khoan
    $newBalance = $balance - $appPrice;
    $data = [
        ':id' => AccountUtility::getId(),
        ':balance' => $newBalance
    ];
    $sql = 'UPDATE accounts SET balance = :balance  where id = :id ';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    // them vao bang app_purchased_history
    $data = [
        ':account_id' => AccountUtility::getId(),
        ':app_id' => $id,
        ':purchased_price' => $appPrice,
    ];
    $sql = 'INSERT INTO app_purchased_history (account_id,app_id,purchased_price )';
    $sql .= ' VALUES (:account_id,:app_id,:purchased_price)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    
    ViewUtility::renderJSON(['msg'=> 'Bạn đã mua thành công']);
}

processPost();
