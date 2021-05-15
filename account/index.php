<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Thông tin cá nhân</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="thongtincanhan">
    
<div>
	<section class="container-fluid">
		<div class="row m-3">
			<div class="col-2 list-group list-group-flush">
				<a href="#"
					class="list-group-item list-group-item-action active">Thông tin cá nhân</a>
				<a href="./my-app.php"
					class="list-group-item list-group-item-action">Ứng dụng của tôi</a> 
                <a href="./balance.php"
					class="list-group-item list-group-item-action">Nạp tiền / Lịch sử nạp</a>
				<a href="../developer/my-dev-app.php"
					class="list-group-item list-group-item-action">Developer - Quản lý ứng dụng</a>
                <a href="../developer/my-order-list.php"
                    class="list-group-item list-group-item-action">Developer - Xem đơn hàng</a>   
			</div>


			<div class="col">
                <h3 class="text-center font-weight-bolder">Thông tin cá nhân</h3>
                <img>

                <table class="table">                
                    <tr>
                        <th scope="row">Họ tên</th>
                        <td>Linh</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>emak@fmafa.nv</td>
                    </tr>
                    <tr>
                        <th scope="row">Loại tài khoản</th>
                        <td>Developer</td>
                    </tr>
                    <tr>
                        <th scope="row">Số dư trong tài khoản</th>
                        <td>250 000đ</td>
                    </tr>
                </table>

                <div>
                    <!-- Phần chỉ hiện tại khi tài khoản là Developer-->
                    <h4 class="text-center font-weight">Thông tin tài khoản Developer của bạn</h4>
                             <table class="table">                
                                <tr>
                                    <th scope="row">Tên nhà phát triển</th>
                                    <td>Linh Dev</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email nhà phát triển</th>
                                    <td>emak@fmafa.nv</td>
                                </tr>
                                <tr>
                                    <th scope="row">Số điện thoại nhà phát triển</th>
                                    <td>091218202</td>
                                </tr>
                                <tr>
                                    <th scope="row">Địa chỉ nhà phát triển</th>
                                    <td>20 Gò Vấp, Ho CHi Mih</td>
                                </tr>
                            </table>
                </div>


                <p class="font-weight-lighter mt-5">Bạn muốn cập nhật lại những thông tin ở trên? </p>
				<a href="./update-info.php?"><button type="button" class="btn btn-info">Cập nhật thông tin</button></a>

                <p class="font-weight-lighter mt-5">Bạn muốn đổi mật khẩu? </p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nhập mật khẩu cũ &nbsp;</span>
                    </div>
                    <input type="text" placeholder="Nhập mật khẩu cũ" aria-label="old-password" class="form-control">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nhập mật khẩu mới</span>
                    </div>
                    <input type="text" placeholder="Nhập mật khẩu mới" aria-label="new-password" class="form-control">
                    <input type="text" placeholder="Nhập lại mật khẩu mới" aria-label="new-password-again" class="form-control">
                </div>
                    <button type="button" class="btn btn-success mt-2">Đổi mật khẩu</button>
			</div>


		</div>
	</section>
</div>

</body>
<?php require_once __DIR__ . '/../layout/footer.php' ?>
</html>