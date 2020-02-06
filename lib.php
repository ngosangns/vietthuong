<?php
	require("dbconnect.php"); // $db_connect $GLOBALS['db_connect']

    if(isset($_POST['lay_san_pham'])) {
        echo json_encode(lay_san_pham()); die();
    }

    // check ki tu dac biet
    function check_special(string $string_query)
    {
        return preg_match("/[!#$%^&*\=\[\]{};':\"\\<>\/?]/", $string_query);
    }
    function remove_special(string $string_query)
    {
        return preg_replace("/[!#$%^&*\=\[\]{};':\"\\<>\/?]/", "", $string_query);
    }

    // lay san pham tu mySQL
    function lay_san_pham(string $query_key="", string $query_data="") {
        if($query_key == "") {
            $db_query = "SELECT * FROM `product`";
        }
        else {
            $db_query = "SELECT * FROM `product` WHERE `".$query_key."`='".$query_data."'";
        }
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $db_query) or die("không thể lấy thông tin sản phẩm");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
            $sanpham['price'] = intval($sanpham['price'])==0?"Liên hệ":number_format($sanpham['price'])." VND"; // xu li price
            $array_sp[] = $sanpham;
        }
        return $array_sp;
    }
    function lay_bai_viet(string $query_key="", string $query_data="") {
        if($query_key == "") {
            $db_query = "SELECT * FROM `post`";
        }
        else {
            $db_query = "SELECT * FROM `post` WHERE `".$query_key."`='".$query_data."'";
        }
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $db_query) or die("không thể lấy thông tin sản phẩm");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
            $array_sp[] = $sanpham;
        }
        return $array_sp;
    }
    function kt_level(string $iduser, string $password="") {
        if(check_special($iduser)||check_special($password)) die_custom("Cookie không được chứa kí tự đặc biệt.", "./");
        if($password=="") $sql_query = "SELECT `username` FROM `user` WHERE `id`='".$iduser."'";
        else $sql_query = "SELECT `username` FROM `user` WHERE `id`='".$iduser."' AND `password`='".$password."'";
        $result = mysqli_query($GLOBALS['db_connect'], $sql_query);
        $result = mysqli_fetch_assoc($result);
        if(isset($result['username'])) return 1;
        else return 0;
    }
    function search(string $search_query, string $layout = "product", string $excludee = "") {
        if(check_special($search_query)) die_custom("Query không được chứa kí tự đặc biệt.", "./");
        $excludee_query = "";
        if($excludee != "") $excludee_query = " AND NOT `id` = ".$excludee;
        $sql_query = "SELECT * FROM `".$layout."` WHERE (`name` LIKE '%".$search_query."%' OR `category` LIKE '%".$search_query."%')".$excludee_query;
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $sql_query) or die("không thể lấy thông tin sản phẩm");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
            if($layout == "product")
                $sanpham['price'] = intval($sanpham['price'])==0?"Liên hệ":number_format($sanpham['price'])." VND"; // xu li price
            $array_sp[] = $sanpham;
        }
        return $array_sp;
    }
    function die_custom(string $string_query="", string $target_location="") {
        ?>
        <script type="text/javascript">
            alert("<?php echo $string_query; ?>");
            <?php
            if($target_location=="") {
                ?>
                window.history.back();
                <?php
            }
            else if($target_location=="reload") {
                ?>
                window.location = window.location.href;
                <?php
            }
            else {
                ?>
                window.location.replace("<?php echo $target_location; ?>");
                <?php
            }
            ?>
        </script>
        <?php
        die();
    }
    // element
    function head($string) {
        ?>
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $string; ?></title>
            <link rel="shortcut icon" type="image/png" href="./image/logo.png">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="./css/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <script src="./js/sanpham.js"></script>
        </head>
        <?php
    }
    function nav() { // menu trang web
        ?>
		<header>
            <div id="header-banner">
                <center>
                    <div id="main-banner">
                        <a id="main-link">
                            <img id="main-image" class="img-fluid" src="./img/header.png"/>
                        </a>
                    </div>
                </center>
            </div>
            <nav id="main-menu" class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">GIỚI THIỆU</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tintuc.php">TIN TỨC-SỰ KIỆN</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#daotao" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ĐÀO TẠO</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./#daotao">KHÓA HỌC:</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">- KHÓA HỌC PIANO</a>
                                <a class="dropdown-item" href="#">- KHÓA HỌC GUITAR</a>
                                <a class="dropdown-item" href="#">- KHÓA HỌC UKULELE</a>
                                <a class="dropdown-item" href="#">- KHÓA HỌC VIOLIN</a>
                                <a class="dropdown-item" href="#">- KHÓA HỌC ORGAN</a>
                                <a class="dropdown-item" href="#">- KHÓA HỌC THANH NHẠC</a>
                                <a class="dropdown-item" href="#">- KHÓA HỌC ABRSM</a>
                                <a class="dropdown-item" href="#">- ĐÀO TẠO NHẠC CÔNG</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#sanpham" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SẢN PHẨM</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./search.php?search=Piano">ĐÀN PIANO</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./search.php?search=Grand Piano">- GRAND PIANO</a>
                                <a class="dropdown-item" href="./search.php?search=Upright Piano">- UPRIGHT PIANO</a>
                                <a class="dropdown-item" href="./search.php?search=Digital Piano">- DIGITAL PIANO</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./search.php?search=Guitar">ĐÀN GUITAR</a>
                                <a class="dropdown-item" href="./search.php?search=Organ">ĐÀN ORGAN</a>
                                <a class="dropdown-item" href="./search.php?search=Ukulele">ĐÀN UKULELE</a>
                                <a class="dropdown-item" href="./search.php?search=Violin">ĐÀN VIOLIN</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./#dichvuchinh">DỊCH VỤ</a>
                        </li>
                        <?php
                            if(isset($_COOKIE['userid']) && isset($_COOKIE['password'])) {
                                if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) {
                                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#sanpham" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ADMIN</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./upload-sanpham.php">ĐĂNG SẢN PHẨM</a>
                                <a class="dropdown-item" href="./upload-baiviet.php">ĐĂNG BÀI VIẾT</a>
                                <a class="dropdown-item" href="./quanli-sanpham.php">QUẢN LÍ SẢN PHẨM</a>
                                <a class="dropdown-item" href="./quanli-baiviet.php">QUẢN LÍ BÀI VIẾT</a>
                                <a class="dropdown-item" href="./login.php?logout">ĐĂNG XUẤT</a>
                            </div>
                        </li>
                                    <?php
                                }
                                else {
                                    die_custom("User không đúng", "./login.php?logout");
                                }
                            }
                            else {
                                ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">ĐĂNG NHẬP</a>
                        </li>
                                <?php
                            }
                        ?>
                        <form class="form-inline my-2 my-lg-0" action="./search.php" method="get">
                            <input class="form-control mr-sm-2" type="text" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                            <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </ul>
                </div>
            </nav>
        </header>
        <?php
    }
    function foot() { // chan trang web
        ?>
		<footer class="row bg-dark text-white mt-5">
            <div class="col-md-4">
                <h5>Công ty ABC</h5>
                <p>
                    Số điện thoại: <b>+1234567890</b><br/>
                    Địa chỉ: <b>Bình Tân, Tp. Hồ Chí Minh</b><br/>
                </p>
            </div>
            <div class="col-md-4">
                <h5>Social</h5>
                <p>
                    <a href="https://www.facebook.com/hayho.life"><img class="rounded-pill mr-2" src="./img/facebook.png" alt="Facebook" width="20%"></a>
                    <a href="https://www.youtube.com/channel/UCSZPhRlK5mAycThqQMYHsNw?view_as=subscriber&fbclid=IwAR25KkVIVYMXDTZJvvw1WgcLQGW0j2G21lUeduI4T51ewtvjsE35gj0DWt0"><img class="rounded-pill" src="./img/youtube.png" alt="Youtube" width="20%"></a>
                </p>
            </div>
            <div class="col-md-4">
                <h5>Map</h5>
                <iframe id="map-content" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1355207326615!2d106.65516191417197!3d10.800930961695874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529373fd49db9%3A0xdb6fc80aa6c3239c!2zMTdhIEPhu5luZyBIw7JhLCBQaMaw4budbmcgNCwgVMOibiBCw6xuaCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1580820177526!5m2!1svi!2s" width="100%" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            </div>
        </footer>
        <script>
            // Fixed menu on scroll
            window.onscroll = function() { fixedMenu() };
            var mainMenu = document.getElementById("main-menu");
            var stickyMenu = mainMenu.offsetTop;
            function fixedMenu() {
                if (window.pageYOffset > stickyMenu) {
                    mainMenu.classList.add("fixed-top");
                } else {
                    mainMenu.classList.remove("fixed-top");
                }
            }

            var iframeContent = document.getElementById("iframe-content");
            var mapContent = document.getElementById("map-content");
            var iGrid = document.querySelectorAll(".iGrid");
            var iTin = document.querySelectorAll(".iTin .col-md-4");
            var iTrungTam = document.querySelectorAll(".trungtam");
            // Window onresize event
            window.addEventListener("resize", responsiveWidth);
            // Set height to responsive elements
            function responsiveWidth() {
                if(mapContent!=null)
                    mapContent.height = mapContent.offsetWidth;
                if(iframeContent!=null)
                    iframeContent.height = iframeContent.offsetWidth*.25;
                for(var i=0; i<iGrid.length; i++)
                    iGrid[i].style.cssText += "; height: "+iGrid[i].offsetWidth*0.5+"px;";
                for(var i=0; i<iTin.length; i++)
                    iTin[i].style.cssText += "; height: "+iTin[i].offsetWidth*0.5+"px;";
                for(var i=0; i<iTrungTam.length; i++)
                    iTrungTam[i].style.cssText += "; top: "+(iTrungTam[i].parentElement.offsetHeight-iTrungTam[i].offsetHeight)*0.5+"px;";
            }
            responsiveWidth();
        </script>
        <?php
    }
    function contentTop(string $titleHeader = "") {
        ?>
        <!DOCTYPE html>
        <html>
            <?php head($titleHeader); ?>
            <body>
                <div id="container" class="container-fluid p-0 m-0">
        <?php nav(); ?>
        <div class="mt-5"></div>
        <?php
    }
    function contentBottom($enableFoot = true) {
        if($enableFoot) foot();
        else {
            ?>
            <footer class="mt-5"></footer>
            <?php
        }
        ?>
                </div>
            </body>
        </html>
        <?php
    }
    function checkDangNhap() {
        if(!isset($_COOKIE['userid']) && !isset($_COOKIE['password'])) die_custom("Bạn chưa đăng nhập", "./login.php");
        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])==0) die_custom("Tài khoản sai", "./login.php?logout");
    }
    function addContent(string $layout, string $action) {
        // Kiểm tra name/category
        if(!isset($_POST['name']) || !isset($_POST['category'])) return;
        if(strlen($_POST['name'])==0 || strlen($_POST['category'])==0) die_custom("Các trường đánh dấu * là bắt buộc.");
        // Kiểm tra comment
        $comment = ""; if(isset($_POST['comment'])) $comment = $_POST['comment'];
        // Kiểm tra id
        $id = ""; if(isset($_POST['id'])) $id = $_POST['id'];
        // Kiểm tra avatar
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], "SELECT `image` FROM `".$layout."` WHERE `id` = '".$id."'") or die_custom("Có lỗi khi cập nhật sản phẩm");
        $sanpham = mysqli_fetch_assoc($db_sanpham);
        $avtNotFound = "./img/notfound.png";
        if($sanpham!=null && sizeof($sanpham)>0) {
            if($sanpham["image"]!=$avtNotFound && $sanpham["image"]!="") $avatar_path = $sanpham["image"];
            else $avatar_path=$avtNotFound;
        }
        else $avatar_path = $avtNotFound;
        if(isset($_FILES['image']) && $_FILES['image']['error']!=4) {
            if($_FILES['image']['error']>0) die_custom("Lỗi upload file");
            $avatar_path_old = $avatar_path;
            $avatar_path = "./img/data/".(string)md5($_FILES['image']['tmp_name']).(string)time();
            move_uploaded_file($_FILES['image']['tmp_name'], $avatar_path) or die_custom("Lỗi khi cập nhật sản phẩm");
            if($avatar_path_old != $avtNotFound && $avatar_path_old!="")
                try { unlink($avatar_path_old); } catch(Exception $e) {}
        }
        if($layout == "post") {
            // Kiểm tra description
            $descr = ""; if(isset($_POST['descr'])) $descr = $_POST['descr'];
            // Nhập/Update bài viết
            if($action == "edit") $sql_query = "UPDATE `post` SET `name` = '".$_POST['name']."', `category` = '".$_POST['category']."', `image` = '".$avatar_path."', `descr` = '".$descr."', `comment` = '".$comment."' WHERE `id` = ".$id."";
            else $sql_query = "INSERT INTO `post`(`name`, `category`, `image`, `descr`, `comment`) VALUES('".$_POST['name']."', '".$_POST['category']."', '".$avatar_path."', '".$descr."', '".$comment."')";
            mysqli_query($GLOBALS['db_connect'], $sql_query) or die("Lỗi khi cập nhật bài viết");
            die_custom("Cập nhật bài viết thành công", "./quanli-baiviet.php");
        }
        if($layout == "product") {
            // Kiếm tra code sản phẩm
            if(!isset($_POST['code'])) return;
            if(strlen($_POST['code'])==0) die_custom("Các trường đánh dấu * là bắt buộc.");
            // Kiểm tra giá sản phẩm
            if(isset($_POST['price'])) $giasp=(int)$_POST['price'];
            // Nhập/Update sản phẩm
            if($action == "edit") $sql_query = "UPDATE `product` SET `code` = '".$_POST['code']."', `name` = '".$_POST['name']."', `category` = '".$_POST['category']."', `price` = '".$giasp."', `image` = '".$avatar_path."', `comment` = '".$comment."' WHERE `id` = ".$id."";
            else $sql_query = "INSERT INTO `product`(`code`, `name`, `category`, `price`, `image`, `comment`) VALUES('".$_POST['code']."', '".$_POST['name']."', '".$_POST['category']."', ".$giasp.", '".$avatar_path."', '".$comment."')";
            mysqli_query($GLOBALS['db_connect'], $sql_query) or die_custom("Lỗi khi cập nhật sản phẩm");
            die_custom("Cập nhật sản phẩm thành công", "./quanli-sanpham.php");
        }
    }
?>