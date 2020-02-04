<?php
    require("lib.php");
    if (!isset($_COOKIE['userid']) && !isset($_COOKIE['password'])) die("Bạn chưa đăng nhập. <a href='login.php'>Đăng nhập</a>");
    if(isset($_POST['submit'])) {
        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) {
            // kiểm tra tên sản phẩm, loại sản phẩm, nhà sản xuất, mã sản phẩm
            if(isset($_POST['name']) && isset($_POST['category']) && isset($_POST['code'])) {
                // Kiểm tra giá sản phẩm
                if(isset($_POST['price'])) {
                    if(check_special($_POST['price'])) die_custom("Giá không được chứa kí tự đặc biệt");
                    $giasp=(int)$_POST['price'];
                }
                // Kiểm tra avatar sản phẩm
                if(isset($_FILES['image'])) {
                    if($_FILES['image']['error']>0) die_custom("Lỗi upload file");
                    if(check_special($_FILES['image']['name'])) die_custom("Tên avatar không được chứa kí tự đặc biệt");
                    $avatar_path = "./image/".(string)md5($_FILES['image']['tmp_name']).(string)time();
                    move_uploaded_file($_FILES['image']['tmp_name'], $avatar_path) or die_custom("Lỗi chuyển file server");
                }
                else $avatar_path = "image/notfound.jpg";
                // Kiểm tra kí tự đặc biệt
                if(check_special($_POST['name'])) die_custom("Tên sản phẩm không được chứa kí tự đặc biệt");
                if(check_special($_POST['category'])) die_custom("Loại sản phẩm không được chứa kí tự đặc biệt");
                if(check_special($_POST['code'])) die_custom("Mã sản phẩm không được chứa kí tự đặc biệt");
                // Kiểm tra trống
                if(strlen($_POST['name'])==0||strlen($_POST['category'])==0||strlen($_POST['code'])==0) die_custom("Các trường đánh dấu * là bắt buộc.");
                // Tiến hành nhập sản phẩm
                $sql_query = "INSERT INTO `product`(`code`, `name`, `category`, `price`, `image`, `comment`) VALUES('".$_POST['code']."', '".$_POST['name']."', '".$_POST['category']."', ".$giasp.", '".$avatar_path."', '".$_POST['comment']."')";
                mysqli_query($db_connect, $sql_query) or die_custom("Lỗi khi cập nhật sản phẩm");
                die_custom("Cập nhật sản phẩm thành công", "reload");
            }
        }
        else die("tài khoản không đúng");
    }
?>
<!DOCTYPE html>
<html>
    <?php head("Upload sản phẩm"); ?>
    <body>
		<div id="container" class="container-fluid p-0 m-0">
			<?php nav(); ?>
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <h2>UPLOAD SẢN PHẨM</h2><br/>
                        <form method="POST" action="upload.php" role="form" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="name" class="col-form-label col-md-3">Tên sản phẩm*</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-form-label col-md-3">Giá sản phẩm</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="price">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category" class="col-form-label col-md-3">Loại sản phẩm*</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="category">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="code" class="col-form-label col-md-3">Mã sản phẩm*</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comment" class="col-form-label col-md-3">Mô tả sản phẩm</label>
                                <div class="col-md-9">
                                    <textarea rows=10 type="text" class="form-control" name="comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-form-label col-md-3">Hình ảnh</label>
                                <div class="col-md-9">
                                    <input type="file" class="form-control-file" name="image">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>