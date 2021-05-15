<?php
require_once __DIR__ . '/__/bootstrap.php';
?>
<html>
<head>
<title>Trang chủ</title>
<?php require_once __DIR__ . '/layout/head.php' ?>
<?php require_once __DIR__ . '/layout/header.php' ?>
</head>
<body class="trangchu">
        <div class="category shadow-sm m-3 pb-2">
            <div class="clearfix">
                <h4 class="float-left">Danh mục Camera</h4>
                <button type="button" class="btn btn-success btn-sm mr-5 float-right">Xem thêm</button>
            </div>
            <div class="row app-items m-3">
                <div class="col-sm-4 col-md-3 col-lg-2 ">
                    <div class="card shadow mt-3 bg-white rounded" style="width: 12rem;">
                        <a href="#" class="text-decoration-none">
                            <img src="https://www.tkdtricities.com/wp-content/uploads/2018/06/facebook-icon-preview-200x200.png" class="card-img-top mx-auto" >
                            <div class="card-body">
                                <h5 class="card-text text-center text-truncate-2lines">Camera 360 Camera 360Camera 360Camera 360Camera 360</h5>
                                <h6 class="font-weight-light text-truncate">Facebook Inc Company</h6>
                                <div class="badge badge-primary">Có phí</div>
                                <div class="badge badge-info">20 000</div>
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
    
                
            </div>
        </div>

        <div class="category shadow-sm m-3 pb-2">
            <div class="clearfix">
                <h4 class="float-left">Danh mục Công cụ</h4>
                <button type="button" class="btn btn-success btn-sm mr-5 float-right">Xem thêm</button>
            </div>
            <div class="row app-items m-3">
                <div class="col-sm-4 col-md-3 col-lg-2 ">
                    <div class="card shadow mt-3 bg-white rounded" style="width: 12rem;">
                        <a href="#" class="text-decoration-none">
                            <img src="https://www.tkdtricities.com/wp-content/uploads/2018/06/facebook-icon-preview-200x200.png" class="card-img-top mx-auto" >
                            <div class="card-body">
                                <h5 class="card-text text-center text-truncate-2lines">Youtube</h5>
                                <h6 class="font-weight-light text-truncate">Google</h6>
                                <div class="badge badge-success">Miễn phí</div>
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
            </div>
        </div>
    </body>
<?php require_once __DIR__ . '/layout/footer.php' ?>
</html>

