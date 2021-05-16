<?php
require_once __DIR__ . '/__/bootstrap.php';
?>
<html>
<head>
<title>Trang chủ</title>
<?php require_once __DIR__ . '/layout/head.php' ?>
<?php require_once __DIR__ . '/layout/header.php' ?>
</head>

<?php 
    $pdo = Common::getPdo();
    $DOMAIN_URL = Config::get('publicPath');

    $sql_get_category = "SELECT * from categories";

?>

    <body class="trangchu">
        <?php foreach($pdo->query($sql_get_category) as $v){  
            $url_more = $DOMAIN_URL."app/app-listing.php?category=".$v['id']."&category_name=".$v['name'];  
        ?>
            <div class="category shadow-sm m-3 pb-2">
                <div class="clearfix">
                    <h4 class="float-left"><?=$v['name']?></h4>
                    <a type="button" class="btn btn-success btn-sm mr-5 float-right"
                        href="<?=$url_more?>">
                        Xem thêm
                    </a>
                </div>
                <div class="row app-items m-3">
                    <?php 
                        $sql_condition = '';
                        if(isset($_GET['name_app']) && $_GET['name_app']){
                            $app_name = $_GET['name_app'];
                            $sql_condition = " and a.name like '$app_name%' ";
                        }

                        $category_id = $v['id'];
                        $sql_get_app = "SELECT a.*, count(app_id) as cnt_dow_app from apps a 
                                        left join app_purchased_history p on a.id = p.app_id 
                                        where status = 2 and a.category_id = $category_id $sql_condition 
                                        GROUP by id order by a.id desc limit 6";
                        foreach($pdo->query($sql_get_app) as $v2){
                    ?>
                        <div class="col-sm-4 col-md-3 col-lg-2 ">
                            <div class="card shadow mt-3 bg-white rounded" style="width: 12rem;">
                                <a href="<?=$DOMAIN_URL.'app/detail.php?id='.$v2['id']?>" class="text-decoration-none">
                                    <div class="app-logo mx-auto ">
                                        <img src="<?=$DOMAIN_URL.'public/'.$v2['icon']?>" class="card-img-top" >
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-text text-center text-truncate-2lines"><?=$v2['name']?></h5>
                                        <h6 class="font-weight-light text-truncate"><?=$v2['short_description']?></h6>
                                        <?php if($v2['price'] > 0){ ?>
                                            <div class="badge badge-primary">Có phí</div>
                                            <div class="badge badge-info"><?=$v2['price']?></div>
                                        <?php }else{ ?>
                                            <div class="badge badge-success">Miễn phí</div>
                                        <?php } ?>
                                        <div class="font-weight-lighter">
                                            <small>Số lượng tải: <?=$v2['cnt_dow_app']?></small></div>
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
            </div>
        <?php } ?>
    </body>
<?php require_once __DIR__ . '/layout/footer.php' ?>
</html>

