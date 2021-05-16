<?php

require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\AccountUtility;
use App\Utility\ViewUtility;

AccountUtility::requireLogin();

function process()
{
    if (!isset($_GET['id'])) {
        return;
    }

    $id = $_GET['id'];
    $id = intval($id);
    if ($id == 0) {
        return;
    }

    $pdo = Common::getPdo();
    // kiem tra app co phai o trang thai cho tai khong
    $sql = 'SELECT price, download_location  FROM apps';
    $sql .= ' WHERE id= :id ';
    if(!AccountUtility::isAdmin()){
        $sql .= ' AND status = 2';
    }
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':id' => $id));
    $red = $sth->fetchAll();
    if (count($red) == 0) {
        ViewUtility::redirectUrl();
    }

    $appPrice = $red[0]['price'];
    $downloadLocation = $red[0]['download_location'];

    // kiem tra da co trong bang app_purchased_history chua
    $sql = 'SELECT COUNT(*) FROM app_purchased_history where account_id = :account_id and app_id = :app_id';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':account_id' => AccountUtility::getId(), ':app_id' => $id));
    $red = $sth->fetchAll();
    if ($red[0]['COUNT(*)'] == 0) {
        if (!AccountUtility::isAdmin() && $appPrice > 0) {
            ViewUtility::redirectUrl();
        } else {
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
        }
    }

    $d = DIRECTORY_SEPARATOR;
    $filePath = __DIR__ . $d . '..' . $d . '__' . $d . 'file_setting' . $d . $downloadLocation;
    if(!file_exists($filePath)){
        echo 'File này đã bị xóa bởi hệ thống';
        exit;
    }
    $filePath = realpath($filePath);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    flush(); // Flush system output buffer
    readfile($filePath);
}

process();
