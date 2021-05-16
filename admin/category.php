<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

AccountUtility::requireLogin();
if (!AccountUtility::isAdmin()) {
    ViewUtility::redirectUrl();
}

$pdo = Common::getPdo();
$sql = 'SELECT *  FROM categories';

$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$categories = $sth->fetchAll();

function processPost()
{
    $action = $_POST['action'];
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    // cap nhat ten the loai
    $pdo = Common::getPdo();
    if($action == 'create'){
        $data = [
            ':name' => $name
        ];
        $sql = 'INSERT INTO categories (name)';
        $sql .= ' VALUES (:name)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    } elseif ($action == 'update') {
        $data = [
            ':id' => $id,
            ':name' => $name
        ];
        $sql = 'UPDATE categories SET name = :name  where id = :id ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
    } else {
        try{
            $data = [
                ':id' => $id
            ];
            $sql = 'DELETE FROM categories  where id = :id ';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        } catch(Exception $ex){
            ViewUtility::renderJSON(['err'=>'Có lỗi xảy ra'], 400);
        }
    }
}

if (ViewUtility::isPostReq()) {
    processPost();
}

?>
<html>

<head>
    <title>Quản lý danh mục - Admin</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="kiemduyetungdung">
    <div class="shadow-sm p-2 m-2 bg-white rounded">

        <div class="row m-3">

            <div class="col-2 list-group list-group-flush">
                <a href="./" class="list-group-item list-group-item-action ">Thống kê</a>
                <a href="./app-censorship.php" class="list-group-item list-group-item-action ">Kiểm duyệt ứng dụng</a>
                <a href="./money-card.php" class="list-group-item list-group-item-action">Quản lý mã thẻ</a>
                <a href="#" class="list-group-item list-group-item-action active">Quản lý danh mục</a>
            </div>

            <div class="col">

                <h3 class="text-center font-weight-bolder">Quản lý danh mục</h3>

                <h5>Thêm mới danh mục</h5>
                <div class="input-group mb-3">
                    <input id='create-input' type="text" class="form-control" placeholder="Nhập tên danh mục">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="createBtn">Thêm</button>
                    </div>
                </div>


                <table class="table table-hover m-3">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categoryIndex = 0;
                        foreach ($categories as $category) {
                            $categoryIndex++;    ?>
                            <tr>
                                <th scope="row"><?= $categoryIndex ?></th>
                                <td>
                                    <input data-id="<?= $category['id'] ?>" value="<?= $category['name'] ?>" class="form-control" required> </input>
                                    <div class="invalid-feedback">
                                        Thể loại bị trống
                                    </div>
                                </td>
                                <td> <a href="" action="update" data-id="<?= $category['id'] ?>">Cập nhật</a> |
                                    <a href="" action="delete" data-id="<?= $category['id'] ?>">Xoá</a>
                                <td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
<?php require_once __DIR__ . '/../layout/modal.php' ?>

</html>