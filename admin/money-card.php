<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\ViewUtility;
use App\Utility\AccountUtility;

AccountUtility::requireLogin();
if (!AccountUtility::isAdmin()) {
    ViewUtility::redirectUrl();
}

// kiem tra tong gia tri chua nap
$pdo = Common::getPdo();
$sql = 'SELECT sum(denomination) as sum  FROM cards WHERE used = 0';

$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$red = $sth->fetchAll();

$remainDenomination = $red[0]['sum'];

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

$sql_tmp = ' FROM cards ';
$sql = "SELECT * " . $sql_tmp;
$sql .= " order by created_time desc limit {$record_per_page} offset {$start_from}";
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute();
$cardList = $sth->fetchAll();

// pagination 
$total_rows_sql = "Select count(*) as count " . $sql_tmp;
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

function generateUUID($length)
{
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
    }
    return $random;
}

$newCards = [];

function processPost()
{
    $menhGia = $_POST['menhgia'];
    $cardCount = $_POST['cardCount'];

    global $newCards;
    $newCardsInsert = [];
    for ($i = 0; $i < $cardCount; ++$i) {
        $newCard = uniqid() . generateUUID(3);
        $newCards[] = $newCard;
        $newCardsInsert[] = "('$newCard', $menhGia, 0)";
    }

    $pdo = Common::getPdo();

    $sql = 'INSERT INTO cards (seri_number,denomination,used )';
    $sql .= ' VALUES ';
    $sql .= implode(" , ", $newCardsInsert);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
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
                <a href="./" class="list-group-item list-group-item-action ">Thống kê</a>
                <a href="./app-censorship.php" class="list-group-item list-group-item-action ">Kiểm duyệt ứng dụng</a>
                <a href="#" class="list-group-item list-group-item-action active">Quản lý mã thẻ</a>
                <a href="./category" class="list-group-item list-group-item-action ">Quản lý danh mục</a>
            </div>

            <div class="col">
                <h3 class="text-center font-weight-bolder">Quản lý mã thẻ</h3>
                <div class="font-weight-bolder">
                    Tổng giá trị tiền thẻ chưa nạp: <span class="badge badge-info"><?= number_format($remainDenomination, 0, '', ',') ?> <span>đ
                </div>

                <div class="mt-3">
                    <form action="" method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="menhgia">Mệnh giá</label>
                            </div>
                            <select class="custom-select" name="menhgia" id="menhgia">
                                <option value="50000" selected>50 000 VNĐ</option>
                                <option value="100000">100 000 VNĐ</option>
                                <option value="200000">200 000 VNĐ</option>
                                <option value="500000">500 000 VNĐ</option>
                            </select>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Số lượng</span>
                            <input type="number" class="form-control" placeholder="Số lượng thẻ" name="cardCount" aria-label="card-count">
                        </div>

                        <button class="btn btn-success mt-3" type="submit">Tạo mã thẻ</button>
                    </form>
                </div>

                <?php if (count($newCards) > 0) { ?>
                    <h5 class="font-weight-normal mt-5">Danh sách mã thẻ vừa được tạo thành công</h5>

                    <table class="table m-3">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã thẻ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cardIndex = 0;
                            foreach ($newCards as $card) {
                            $cardIndex++;
                            ?>
                                <tr>
                                    <th scope="row"><?= $cardIndex ?></th>
                                    <td><?= $card ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>


                <h5 class="font-weight-light mt-5">Danh sách mã thẻ đã tạo trước đây</h5>
                <table class="table table-striped m-3">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Mã thẻ</th>
                            <th scope="col">Mệnh giá</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tình trạng</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($cardList as $card) { ?>
                            <tr>
                                <th scope="row"><?= $card['id'] ?></th>
                                <td><?= $card['id'] ?></td>
                                <td><?= $card['seri_number'] ?></td>
                                <td><?= $card['denomination'] ?></td>
                                <td>
                                    <?php
                                    if (isset($hisotry['created_time'])) {
                                        $date = new DateTime($hisotry['created_time']);
                                        echo $date->format('d/m/Y h:m:s');
                                    } else {
                                        $date = new DateTime();
                                        echo $date->format('d/m/Y h:m:s');
                                    }
                                    ?></td>
                                <td><?php
                                    if ($card['used']) {
                                        echo '<span class="badge badge-secondary"> Đã dùng </span>';
                                    } else {
                                        echo '<span class="badge badge-success"> Chưa dùng </span>';
                                    }
                                    ?></td>
                            </tr>
                        <?php } ?>
                        <!-- <tr>
                    <th scope="row">2</th>
                    <td>121212312124121321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                    <td><span class="badge badge-success"> Chưa dùng </span></td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>121212312124121321</td>
                    <td>20 000</td>
                    <td>20/12/2020 02:32:22</td>
                    <td><span class="badge badge-secondary"> Đã dùng </span></td>
                </tr> -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
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

            </div>

        </div>


    </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>

</html>