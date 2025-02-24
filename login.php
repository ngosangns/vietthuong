<?php
require("lib.php");
// kiểm tra nếu đã đăng nhập
if(isset($_COOKIE['userid']) && isset($_COOKIE['password'])) {
    // kiểm tra đăng xuất
    if(isset($_GET['logout'])) {
        setcookie('userid', "", time()-100, "/");
        setcookie('password',"", time()-100, "/");
        unset($_COOKIE['userid']);
        unset($_COOKIE['password']);
        header("Location: ./");
    }
    die_custom("Bạn đã đăng nhập.", "./quanli-sanpham.php");
}
// lấy dữ liệu ở form
if (isset($_POST['username']) && isset($_POST['password'])) {
    // kiểm tra kí tự đặc biệt
    if(check_special($_POST['username'])) die_custom("Username không được chứa kí tự đặc biệt");
    if(check_special($_POST['password'])) die_custom("Password không được chúa kí tự đặc biệt");
    $username = $_POST['username'];
    $password = $_POST['password'];
    // kiểm tra tài khoản tồn tại trong hệ thống
    $sql = "SELECT * FROM `user` WHERE `username`='".$username."' AND `password`='".$password."'";
    $query = mysqli_query($db_connect, $sql);
    $user_array = [];
    while($user = mysqli_fetch_assoc($query)) {
        $user_array[] = $user;
    }
    // nếu tài khoản không tổn tài hoặc không chính xác
    if(sizeof($user_array)==0) die_custom("Tài khoản hoặc mật khẩu không chính xác.");
    // tạo cookie nếu đã kiểm tra xong
    setcookie('userid', $user_array[0]['id'], time() + 60*60*24*30, "/");
    setcookie('password',$user_array[0]['password'], time() + 60*60*24*30, "/");
    header("Location: ./upload-sanpham.php");
}
mysqli_close($db_connect);
?>
<?php contentTop("Đăng nhập"); ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <h2>ĐĂNG NHẬP</h2><br/>
        <form method="POST" action="login.php" role="form" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="username" class="col-form-label col-md-3">Username</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="username" name="username">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-form-label col-md-3">Password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="password">
                </div>
            </div><br/>
            <button type="submit" class="btn btn-success" name="submit">Đăng nhập</button>
        </form>
    </div>
</div>
<?php contentBottom(false); ?>