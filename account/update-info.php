<?php
require_once __DIR__ . '/../__/bootstrap.php';
?>
<html>

<head>
    <title>Cập nhật thông tin cá nhân</title>
    <?php require_once __DIR__ . '/../layout/head.php' ?>
    <?php require_once __DIR__ . '/../layout/header.php' ?>
</head>

<body class="capnhatthongtin">
    
<div class="container-fluid">
	<section class="shadow-sm p-3 m-3 bg-white rounded">

        <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../">Home</a></li>
                    <li class="breadcrumb-item"><a href="./">Thông tin cá nhân</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cập nhật thông tin</li>
                </ol>
        </nav>


			<div class="col">
                <h3 class="text-center font-weight-bolder">Thay đổi thông tin cá nhân</h3>
                <img>
   
            <form action="" method="post">
                <div>
                    <table class="table">                
                        <tr>
                            <th scope="row">Họ tên</th>
                            <td> <input type="text" class="form-control" id="name" value="Họ và tên" name="name"></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td class="text-muted">emak@fmafa.nv</td>
                        </tr>
                        <tr>
                            <th scope="row">Loại tài khoản</th>
                            <td class="text-muted">Developer</td>
                        </tr>
                    </table>
                </div>

                <div>
                    <!-- Phần chỉ hiện tại khi tài khoản là Developer-->
                    <h4 class="text-center font-weight mt-5">Thông tin tài khoản Developer của bạn</h4>
                             <table class="table">                
                                <tr>
                                    <th scope="row">Tên nhà phát triển</th>
                                    <td> <input type="text" class="form-control" id="dev-name" value="Tên cũ" name="dev-name"> </td>
                                </tr>
                                <tr>
                                    <th scope="row">Email nhà phát triển</th>
                                    <td><input type="email" class="form-control" id="dev-email" value="email cũ" name="dev-email"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Số điện thoại nhà phát triển</th>
                                    <td><input type="phone" class="form-control" id="dev-phone" value="sdt cũ" name="dev-phone"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Địa chỉ nhà phát triển</th>
                                    <td><input type="text" class="form-control" id="dev-phone" value="địa chỉ cũ" name="dev-address"></td>
                                </tr>
                            </table>
                </div>



            </form>


                <p class="font-weight-lighter mt-5">Bạn muốn cập nhật lại những thông tin ở trên? </p>
				<button type="button" class="btn btn-success" onclick="action()">Thực hiện cập nhật</button>

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