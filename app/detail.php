<?php
require_once __DIR__ . '/../__/bootstrap.php';

use App\Utility\AccountUtility;
use App\Utility\ViewUtility;

if (!isset($_GET['id'])) {
  ViewUtility::redirectUrl();
}

$id = intval($_GET['id']);
$pdo = Common::getPdo();
$sql = 'SELECT a.* , c.name as category , d.developer_name, d.email, d.developer_address  FROM apps a INNER JOIN categories c ON a.category_id = c.id ';
$sql .= ' INNER JOIN accounts d ON a.created_by = d.id';
$sql .= ' WHERE a.id= :id AND a.status = 2';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':id' => $id));
$red = $sth->fetchAll();
if (count($red) == 0) {
  ViewUtility::redirectUrl();
}
$app = $red[0];
$app['images'] =  json_decode($app['images'], true);

// xu ly lượt tải
$sql = 'SELECT COUNT(*) FROM app_purchased_history where app_id = :app_id';
$sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':app_id' => $id));
$red = $sth->fetchAll();
$app['downloadCount'] = $red[0]['COUNT(*)'];

// xu ly nut tai ,mua

if ($app['price'] > 0) {
  if (AccountUtility::isLogin()) {
    $sql = 'SELECT COUNT(*) FROM app_purchased_history where account_id = :account_id and app_id = :app_id';
    $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':account_id' => AccountUtility::getId(), ':app_id' => $id));
    $red = $sth->fetchAll();
    if ($red[0]['COUNT(*)'] == 0) {
      $app['requiredBuy'] = true;
    } else {
      $app['requiredBuy'] = false;
    }
  } else {
    $app['requiredBuy'] = true;
  }
} else {
  $app['requiredBuy'] = false;
}




?>
<html>

<head>
  <title>Xem chi tiết ứng dụng</title>
  <?php require_once __DIR__ . '/../layout/head.php' ?>
  <?php require_once __DIR__ . '/../layout/header.php' ?>
  <script>
    var id = <?= $id ?>;
    var isLogin = <?= AccountUtility::isLogin() ? 'true' : 'false' ?>;
  </script>
</head>

<body class="xemchitiet">
  <div class="app-detai shadow p-3 m-5 bg-white rounded">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item"><a href="./app-listing?category=">Danh mục <?= $app['category'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Ứng dụng <?= $app['name'] ?></li>
            
    </nav>

    <div class="row mx-auto">
      <div class="col-2">
        <div class="">
          <img src="<?= Config::get('publicPath') . 'public/' . $app['icon'] ?>">
        </div>
      </div>
      <div class="col">
        <div class="">
          <h3 class="text-info"><?= $app['name'] ?></h3>
          <a href="<?= Config::get('publicPath') . '/app/app-listing.php?user_app=' .  $app['created_by'] ?>" class="font-weight-bold"><?= $app['developer_name'] ?></a>
          <a href="<?= Config::get('publicPath') . 'app/app-listing.php?category=' . $app['category_id'] . '&category_name=' . $app['category'] ?>" class="p-3 font-weight-bold"><?= $app['category'] ?></a>
          <p><em><?= $app['short_description'] ?></em></p>
          <?php if ($app['price'] == 0) { ?>
            <div class="badge badge-primary text-wrap">
              Ứng dụng miễn phí
            </div>
          <?php } else { ?>
            <div class="badge badge-primary text-wrap">
              Ứng dụng trả phí
            </div>
            <div class="badge badge-success ">
              <?= number_format($app['price'], 0, '', ',') ?> VNĐ
            </div>
          <?php } ?>
          <?php if ($app['requiredBuy']) { ?>
            <button id="buyNowBtn" class="btn btn-primary float-right" type="button">Mua ngay</button>
          <?php  } else { ?>
            <form action="<?= Config::get('publicPath') . "app/download.php" ?>" method="GET">
              <input type="hidden" name="id" value="<?= $id ?>" />
              <button class="btn btn-primary float-right" type="submit">Tải xuống</button>
            </form>
          <?php } ?>

        </div>
      </div>
    </div>
    <div class="clearfix">
      <div id="carouselExampleControls" class="carousel slide bg-light" data-ride="carousel">
        <div class="carousel-inner">
          <!--   <div class="carousel-item active">
            <img class="mx-auto d-block" src="https://i.pinimg.com/originals/3c/42/2d/3c422d086129f454c6cf1a87c2b20742.jpg" class="d-block">
          </div>
          <div class="carousel-item">
            <img class="mx-auto d-block" src="https://cdn0.tnwcdn.com/wp-content/blogs.dir/1/files/2015/08/Screen-Shot-2015-08-25-at-11.48.29.png" class="d-block">
          </div>
          <div class="carousel-item">
            <img class="mx-auto d-block" src="https://www.slashgear.com/wp-content/uploads/2017/05/Facebook_messenger-980x420.jpg" class="d-block">
          </div> -->
          <?php foreach ($app['images'] as $index => $image) { ?>
            <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
              <img class="mx-auto d-block" src="<?= Config::get('publicPath') . "public/upload_app_images/$id/"  . $image . '.jpg' ?>" class="d-block">
            </div>
          <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="clearfix m-3 font-weight-light">
      <p><?= $app['detail_description'] ?></p>
    </div>
    <h3>Đánh giá</h3>
    <div>
      Trung bình:
      <span class="fa fa-star star-checked"></span>
      <span class="fa fa-star star-checked"></span>
      <span class="fa fa-star star-checked"></span>
      <span class="fa fa-star star-checked"></span>
      <span class="fa fa-star"></span>
    </div>
    <div class="m-3">
      <h5>Hữu Võ</h5>
      <div>
        Đánh giá:
        <span class="fa fa-star star-checked"></span>
        <span class="fa fa-star star-checked"></span>
        <span class="fa fa-star star-checked"></span>
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
      </div>
      <div>
        <p class="text-muted">Ưng dụng ngon</p>
      </div>
    </div>
    <div class="m-3">
      <h5>Linh văn linh</h5>
      <div>
        Đánh giá:
        <span class="fa fa-star star-checked"></span>
        <span class="fa fa-star star-checked"></span>
        <span class="fa fa-star star-checked"></span>
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
      </div>
      <div>
        <p class="text-muted">Ưng dụng ngon</p>
      </div>
    </div>


    <h3>Thông tin bổ sung</h3>
    <table class="table">
      <td>
      <th>Ngày đăng tải</th>
      <th>Dung lượng</th>
      <th>Số lượt tải</th>
      </td>
      <tbody>
        <td>
        <td><?php
            $date = new DateTime($app['created_time']);
            echo $date->format('d/m/Y');
            ?></td>
        <td><?= $app['size'] ?> mb</td>
        <td><?= $app['downloadCount'] ?> lượt</td>
        </td>
      </tbody>
    </table>
    <h3>Thông tin nhà phát triển</h3>
    <p>Email: <?= $app['email'] ?> </p>
    <p>Địa chỉ: <?= $app['developer_address'] ?></p>
  </div>
</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
<?php require_once __DIR__ . '/../layout/modal.php' ?>

</html>