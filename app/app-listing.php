<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '__' . DIRECTORY_SEPARATOR . 'bootstrap.php';
?>
<html>


<?php
    $pdo = Common::getPdo();
    $DOMAIN_URL = Config::get('publicPath');

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

    $sql_condition = ' ';
    $title = 'Danh Sách Tất Cả Ứng Dụng';
    $tab_title = 'Xem danh sách ứng dụng';
    $sql_join = ' left join ';
    if(isset($_GET['category']) && $_GET['category']){
        $categiry_id = $_GET['category'];
        $category_name = $_GET['category_name'];

        $title = "Danh sách ứng dụng theo thể loại : $category_name";
        $tab_title = 'Xem ứng dụng theo thể loại';

        $sql_condition = " and category_id = $categiry_id ";
    }else if(isset($_GET['dow_app']) && $_GET['dow_app']){    
        // ứng dụng được mua nhiều
        if($_GET['dow_app'] == 'buy_a_lot'){
            $title = "Danh sách ứng dụng được mua nhiều";
            $tab_title = 'Top ứng dụng miễn phí';
            $sql_condition = ' and a.price > 0 ';
        }
        // ứng dụng được miễn phí tải nhiều
        else if($_GET['dow_app'] == 'download_a_lot'){
            $title = "Danh sách ứng dụng được miễn phí tải nhiều";
            $tab_title = 'Top ứng dụng có phí';
            $sql_condition = ' and a.price = 0 ';
        }
        $sql_join = ' inner join ';
    }else if(isset($_GET['user_app']) && $_GET['user_app']){
        $title = "Danh sách ứng dụng theo nhà phát triển";
        $tab_title = 'Xem ứng dụng theo nhà phát triển';
        $user_cd = $_GET['user_app'];

        $sql_condition = " and a.created_by = $user_cd ";
    }

    $sql_tmp = " from apps a  $sql_join app_purchased_history p on a.id = p.app_id 
                where status = 2 $sql_condition ";
    $sql_get_app = "SELECT a.*, count(app_id) as cnt_dow_app " . $sql_tmp . 
                    " GROUP by id order by cnt_dow_app desc limit {$record_per_page} offset {$start_from}";

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

<head>
<!-- Tiêu đề cần thay đổi tự động-->
<title><?=$tab_title?></title>
<?php require_once __DIR__ . '/../layout/head.php' ?>
<?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="danhsachapp">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$tab_title?></li> <!-- Tiêu đề cần thay đổi tự động-->
        </ol>
    </nav>

        <h4 class="p-3 text-center"><?=$title?></h4> <!-- Tiêu đề cần thay đổi tự động-->
        <div class="row app-items shadow-sm p-2 m-3 bg-white rounded">
            <?php foreach($pdo->query($sql_get_app) as $v){ ?>
                <div class="col-sm-4 col-md-3 col-lg-2 ">
                    <div class="card shadow mt-3 bg-white rounded" style="width: 12rem;">
                        <a href="#" class="text-decoration-none">
                            <div class="app-logo mx-auto ">
                                <img src="<?=$DOMAIN_URL.'public/'.$v['icon']?>" class="card-img-top" >
                             </div>
                            <div class="card-body">
                                <h5 class="card-text text-center text-truncate-2lines"><?=$v['name']?></h5>
                                <h6 class="font-weight-light text-truncate"><?=$v['short_description']?></h6>
                                <?php if($v['price'] > 0){ ?>
                                    <div class="badge badge-primary">Có phí</div>
                                    <div class="badge badge-info"><?=$v['price']?></div>
                                <?php }else{ ?>
                                    <div class="badge badge-success">Miễn phí</div>
                                <?php } ?>
                                <div class="font-weight-lighter">
                                    <small>Số lượng tải: <?=$v['cnt_dow_app']?></small></div>
                                <div class="rate-font">
                                    <span class="fa fa-star star-checked"></span>
                                    <span class="fa fa-star star-checked"></span>
                                    <span class="fa fa-star star-checked"></span>
                                    <span class="fa fa-star star-checked"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
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

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

