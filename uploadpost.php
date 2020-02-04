<?php
    require("lib.php");
    if (!isset($_COOKIE['userid']) && !isset($_COOKIE['password'])) die("Bạn chưa đăng nhập. <a href='login.php'>Đăng nhập</a>");
    if(isset($_POST['submit'])) {
        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) {
            // kiểm tra tên bài viết, loại bài viết, nhà sản xuất
            if(isset($_POST['name']) && isset($_POST['category'])) {
                // Kiểm tra avatar bài viết
                if(isset($_FILES['image'])) {
                    if($_FILES['image']['error']>0) die_custom("Lỗi upload file");
                    if(check_special($_FILES['image']['name'])) die_custom("Tên avatar không được chứa kí tự đặc biệt");
                    $avatar_path = "./image/".(string)md5($_FILES['image']['tmp_name']).(string)time();
                    move_uploaded_file($_FILES['image']['tmp_name'], $avatar_path) or die_custom("Lỗi chuyển file server");
                }
                else $avatar_path = "image/notfound.jpg";
                // Kiểm tra kí tự đặc biệt
                if(check_special($_POST['name'])) die_custom("Tên bài viết không được chứa kí tự đặc biệt");
                if(check_special($_POST['category'])) die_custom("Loại bài viết không được chứa kí tự đặc biệt");
                // Kiểm tra trống
                if(strlen($_POST['name'])==0) die_custom("Các trường đánh dấu * là bắt buộc.");
                // Tiến hành nhập bài viết
                $sql_query = "INSERT INTO `post`(`name`, `category`, `image`, `comment`) VALUES('".$_POST['name']."', '".$_POST['category']."', '".$avatar_path."', '".$_POST['comment']."')";
                mysqli_query($db_connect, $sql_query) or die_custom("Lỗi khi cập nhật bài viết");
                die_custom("Cập nhật bài viết thành công", "reload");
            }
        }
        else die("tài khoản không đúng");
    }
?>
<!DOCTYPE html>
<html>
    <?php head("Upload bài viết"); ?>
    <body>
		<div id="container" class="container-fluid p-0 m-0">
			<?php nav(); ?>
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <h2>UPLOAD BÀI VIẾT</h2><br/>
                        <form method="POST" action="uploadpost.php" role="form" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="name" class="col-form-label col-md-3">Tiêu đề*</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category" class="col-form-label col-md-3">Chuyên mục*</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="category">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comment" class="col-form-label col-md-3">Nội dung</label>
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