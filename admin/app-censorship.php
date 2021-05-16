<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

AccountUtility::requireLogin();
if (!AccountUtility::isAdmin()) {
    ViewUtility::redirectUrl();
}

// pagination 
if (preg_match('/\?/', $_SERVER['REQUEST_URI'])) {
    if (preg_match('/\?page=/', $_SERVER['REQUEST_URI']))
        $pre_href = '?';
    else if (preg_match('/page=/', $_SERVER['REQUEST_URI']))
        $pre_href = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '&page')) . '&';
    else
        $pre_href = $_SERVER['REQUEST_URI'] . '&';
} else
    $pre_href = '?';

$record_per_page = 6;
$numview = 5;  /// số lượng nút phân trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $record_per_page;
// end pagination 

// lay danh sach cho duyet
$pdo = Common::getPdo();

$sql_tmp = ' FROM apps a INNER JOIN categories c ON a.category_id = c.id ';
$sql_tmp .= ' INNER JOIN accounts d ON a.created_by = d.id';
$sql_tmp .= ' WHERE a.status = 1';
$sql = 'SELECT a.* , c.name as category , d.developer_name, d.email, d.developer_address ' . $sql_tmp;
$sql .= " order by a.created_time desc limit {$record_per_page} offset {$start_from}";
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$waitList = $sth->fetchAll();

// pagination 
$total_rows_sql = "Select count(a.id) as count " . $sql_tmp;
$pages = 1;
$total_rows = 0;
$stmt = $pdo->prepare($total_rows_sql);

$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while ($val = $stmt->fetch()) {
    $total_rows = $val['count'];
    $pages = ceil($total_rows / $record_per_page);
    if ($page > $pages) {
        $page = $pages;
    } else if ($page < 1) {
        $page = 1;
    }
}
// end pagination 


?>
<html>

<head>
    <title>Kiểm duyệt ứng dụng - Admin</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="kiemduyetungdung">
    <div class="shadow-sm p-2 m-2 bg-white rounded">

        <div class="row m-3">

            <div class="col-2 list-group list-group-flush">
                <a href="./" class="list-group-item list-group-item-action ">Thống kê</a>
                <a href="#" class="list-group-item list-group-item-action active">Kiểm duyệt ứng dụng</a>
                <a href="./money-card.php" class="list-group-item list-group-item-action">Quản lý mã thẻ</a>
                <a href="./category.php" class="list-group-item list-group-item-action ">Quản lý danh mục</a>
            </div>

            <div class="col">

                <h3 class="text-center font-weight-bolder">Danh sách ứng dụng đang chờ duyệt</h3>
                <p class="font-weight-lighter">Chỉ những ứng dụng đã được duyệt mới được hiển thị trên website và được cho phép tải về,
                    Ứng dụng bị từ chối thì bạn vui lòng nhấn gỡ bỏ.
                </p>
                <table class="table table-hover m-3">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên ứng dụng</th>
                            <th scope="col">Thể loại</th>
                            <th scope="col">Loại ứng dụng</th>
                            <th scope="col">Giá bán</th>
                            <th scope="col">Nhà phát triển</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $waitListIndex = 0;
                        foreach ($waitList as $app) {
                            $waitListIndex++; ?>
                            <tr>
                                <th scope="row"><?= $waitListIndex + $start_from ?></th>
                                <td><a href="#"> <img class="app-icon" src="<?= Config::get('publicPath') . 'public/' . $app['icon'] ?>"></img>
                                        <?= $app['name'] ?>
                                    </a> </td>
                                <td><?= $app['category'] ?></td>
                                <td> <?php
                                        if ($app['price'] == 0) {
                                            echo '<span class="badge badge-success">Miễn phí</span>';
                                        } else {
                                            echo '<span class="badge badge-primary">Có phí</span>';
                                        }
                                        ?> </td>
                                <td> <?= number_format($app['price'], 0, '', ',') ?> đ </td>
                                <td> <a href="../account?"><?= $app['developer_name'] ?></a> </td>
                                <td> <a href="./app-detail-censorship.php?id=<?= $app['id'] ?>">Xem chi tiết</a>
                                <td>
                            </tr>
                        <?php } ?>
                        <!-- <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-info"> Có phí </span> </td>
                    <td> 12 440đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                    <td> <a href="./app-detail-censorship.php?app-id=''">Xem chi tiết</a>  <td>
                </tr> -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="div-pagination">
                                    <ul class="pagination" id="pager">
                                        <p>
                                            <?php
                                            if ($pre_href != '?') {
                                                echo Common::getPagination($pre_href, $page, ceil($total_rows / $record_per_page), $numview);
                                            } else {
                                                echo Common::getPagination('?', $page, ceil($total_rows / $record_per_page), $numview);
                                            }
                                            ?>
                                        </p>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>


                <!-- <h3 class="text-center font-weight-bolder mt-5">Danh sách ứng dụng đã từ chối</h3>
        <p class="font-weight-lighter">Dưới đây là danh sách ứng dụng đã được bạn từ chối, nhưng chưa được gỡ bỏ từ nhà phát triển.<br>
            Ứng dụng đã từ chối sẽ không hiển thị lên trên trang web.
        </p>
        <table class="table table-hover table-secondary m-3">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên ứng dụng</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Loại ứng dụng</th>
                <th scope="col">Giá bán</th>
                <th scope="col">Nhà phát triển</th>   
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-success"> Miễn phí </span> </td>
                    <td> 0đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td><a href="../app/detail.php?"> <img class="app-icon" src="https://image.shutterstock.com/image-vector/conversation-talking-black-icon-50x50-260nw-1037215327.jpg"></img>
                        Facebook 
                        </a> </td>
                    <td>Mạng xã hội</td>
                    <td> <span class="badge badge-success"> Miễn phí </span> </td>
                    <td> 0đ </td>
                    <td> <a href="../account?"> Phạm Kiên </a> </td>
                </tr>
            </tbody>
        </table> -->
            </div>

        </div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>

</html>