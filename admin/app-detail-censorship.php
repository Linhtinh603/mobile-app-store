<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '__' . DIRECTORY_SEPARATOR . 'bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

AccountUtility::requireLogin();
if (!AccountUtility::isAdmin()) {
    ViewUtility::redirectUrl();
}

if (ViewUtility::isPostReq()) {
    $id = $_POST['id'] ?? null;
    $id = intval($id);
    if ($id == 0) {
        ViewUtility::redirectUrl("admin/app-censorship.php");
    }
    $pdo = Common::getPdo();
    $action = $_POST['action'];
    $data = [
        ':id' => $id,
        ':status' => $action == 'accept' ? 2 : 4
    ];
    $sql = 'UPDATE apps SET status = :status where id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    ViewUtility::redirectUrl("admin/app-censorship.php");
}

$id = $_GET['id'] ?? null;
$id = intval($id);
if ($id == 0) {
    ViewUtility::redirectUrl("admin/app-censorship.php");
}

$pdo = Common::getPdo();

// kiem tra ung dung co ton tai khong
$sql = 'SELECT a.* , c.name as category , d.developer_name, d.email, d.developer_address  FROM apps a INNER JOIN categories c ON a.category_id = c.id ';
$sql .= ' INNER JOIN accounts d ON a.created_by = d.id';
$sql .= ' WHERE a.id= :id AND a.status = 1';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':id' => $id));
$red = $sth->fetchAll();
if (count($red) == 0) {
    ViewUtility::redirectUrl("admin/app-censorship.php");
}
$app = $red[0];
$app['images'] =  json_decode($app['images'], true) ?? [];

?>
<html>

<head>
    <title>Duyệt ứng dụng</title>
    <?php require_once '../layout/head.php'; ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="chitietkiemduyetungdung">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item"><a href="./app-censorship.php">Trang kiểm duyệt ứng dụng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem xét duyệt ứng dụng</li>
        </ol>
    </nav>

    <div class="shadow-sm p-3 m-4 bg-white rounded">
        <h3 class="text-center font-weight-bolder">Thông tin ứng dụng cần duyệt</h3>
        <table class="table">
            <tr>
                <img class="app-icon" src="<?= Config::get('publicPath') . 'public/' . $app['icon'] ?>"></img>
            </tr>
            <tr>
                <th scope="row"> <label for="name" class="font-weight-bold">Tên ứng dụng: </label> </th>
                <td><?= $app['name'] ?></td>
            </tr>
            <tr>
                <th scope="row"> <label for="descript" class="font-weight-bold">Mô tả ngắn</label> </th>
                <td><?= $app['short_description'] ?></td>
            </tr>
            <tr>
                <th scope="row"> <label for="descript_detail" class="font-weight-bold">Mô tả chi tiết</label> </th>
                <td><?= $app['detail_description'] ?></td>
            </tr>
            <tr>
                <th scope="row"> <label for="category" class="font-weight-bold">Thể loại </label> </th>
                <td><?= $app['category'] ?></td>
            </tr>
            <tr>
                <th scope="row"> <label for="img_list" class="font-weight-bold">Danh sách ảnh giới thiệu </label> </th>
                <td>
                    <?php foreach ($app['images'] as $index => $image) { ?>
                        <img class="mx-auto d-block" src="<?= Config::get('publicPath') . "public/upload_app_images/$id/"  . $image . '.jpg' ?>" class="d-block">
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th scope="row"> <label for="app_type" class="font-weight-bold">Loại ứng dụng </label> </th>
                <td>
                    <?php
                    if ($app['price'] == 0) {
                        echo '<span class="badge badge-success">Miễn phí</span>';
                    } else {
                        echo '<span class="badge badge-primary">Có phí</span>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row"> <label for="price" class="font-weight-bold">Giá bán: </label> </th>
                <td> <?= number_format($app['price'], 0, '', ',') ?> đ </td>
            </tr>
            <tr>
                <th scope="row"> <label for="file_setting" class="font-weight-bold">Upload file cài đặt: </label> </th>
                <td>
                    <form action="<?= Config::get('publicPath') . "app/download.php" ?>" method="GET">
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <button class="btn btn-info" type="submit">Tải xem trước</button>
                    </form>
                </td> <!-- Chèn link download vào đây-->
            </tr>
        </table>

        <p class="font-weight-lighter">Sau khi bạn nhấn đồng ý, ứng dụng sẽ được hiển thị ở trang web.
            <br> Nếu bạn nhấn từ chối, thì sẽ loại bỏ khỏi danh sách chờ duyêt, và chờ nhà phát triển gỡ bỏ app.
        </p>

        <div class="d-flex">
            <form action="" method="post">
                <input type="hidden" name="action" value="accept" />
                <input type="hidden" name="id" value="<?= $id ?>" />
                <button type="submit" class="btn btn-success">Đồng ý duyệt</button>
            </form>
            <form action="" method="post" class="ml-2">
                <input type="hidden" name="action" value="decline" />
                <input type="hidden" name="id" value="<?= $id ?>" />
                <button type="submit" class="btn btn-secondary">Từ chối duyệt</button>
            </form>
        </div>

        </form>
    </div>
    <div class="developer-footer">

    </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>

</html>