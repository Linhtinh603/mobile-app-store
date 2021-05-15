<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '__' . DIRECTORY_SEPARATOR . 'bootstrap.php';
?>
<html>
<head>
<!-- Tiêu đề cần thay đổi tự động-->
<title></title>
<?php require_once __DIR__ . '/../layout/head.php' ?>
<?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<?php
    $pdo = Common::getPdo();
    $DOMAIN_IMG = "/AppStoreOffshore/src/public/";

    $sql_condition = ' 1 ';
    $title = "";
    $title_menu = '';
    $sql_orderby = ' ';
    if(isset($_GET['category']) && $_GET['category']){
        $categiry_id = $_GET['category'];
        $category_name = $_GET['category_name'];

        $title = "Danh sách ứng dụng theo thể loại : $category_name";
        $title_menu = 'Danh Sách Theo Loại';
        $sql_condition = " category_id = $categiry_id ";

        $sql_get_app = "SELECT a.*, count(app_id) as cnt_dow_app from apps a 
        left join app_purchased_history p on a.id = p.app_id 
        where $sql_condition 
        GROUP by id";

    }else if(isset($_GET['dow_app']) && $_GET['dow_app']){
        // ứng dụng được mua nhiều
        if($_GET['dow_app'] == 'buy_a_lot'){
            $sql_condition = ' 1 ';
        }
        // ứng dụng được miễn phí tải nhiều
        else if($_GET['dow_app'] == 'download_a_lot'){
            $sql_condition = ' a.price = 0 ';
        }

        $sql_get_app = "SELECT a.*, count(app_id) as cnt_dow_app from apps a 
                        inner join app_purchased_history p on a.id = p.app_id 
                        WHERE $sql_condition
                        GROUP by id order by cnt_dow_app desc";

    }else{

    }

?>

<body class="danhsachapp">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$title_menu?></li> <!-- Tiêu đề cần thay đổi tự động-->
        </ol>
    </nav>

    <h4 class="p-3 text-center"><?=$title?></h4> <!-- Tiêu đề cần thay đổi tự động-->

        <div class="row app-items shadow-sm p-2 m-3 bg-white rounded">
            <?php foreach($pdo->query($sql_get_app) as $v){ ?>
                <div class="col-sm-4 col-md-3 col-lg-2 ">
                    <div class="card shadow mt-3 bg-white rounded" style="width: 12rem;">
                        <a href="#" class="text-decoration-none">
                        <div style="width: 120px; height: 120px;" class="mx-auto">
                            <img src="<?=$DOMAIN_IMG.$v['icon']?>" class="card-img-top">
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
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>

