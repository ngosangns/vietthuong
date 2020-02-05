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
    function edit(string $type, string $id, string $edit_action, string $edit_data) {
        if(check_special($type)||check_special($id)||check_special($edit_action)||check_special($edit_data)) return 0;
        if($edit_action=="price") $edit_data = intval($edit_data);
        $sql_query = "UPDATE `".$type."` SET `".$edit_action."`='".($edit_action=="password"?md5($edit_data):$edit_data)."' WHERE `id`='".$id."'";
        if(mysqli_query($GLOBALS['db_connect'], $sql_query)) return true;
        else return false;
    }
    function delete(string $type, string $id) {
        if(check_special($type)||check_special($id)) return 0;
        $sql_query = "DELETE FROM `".$type."` WHERE `id`='".$id."'";
        if(mysqli_query($GLOBALS['db_connect'], $sql_query)) {
            if($type=="user") {
                $sql_query = "DELETE FROM `product` WHERE `userid`=".$id."";
                mysqli_query($GLOBALS['db_connect'], $sql_query);
                if($id==$_COOKIE['userid']) delete_cookie();
            }
            return true;
        }
        else return false;
    }
    function delete_cookie() {
        setcookie('userid', "", time()-100, "/");
        setcookie('password',"", time()-100, "/");
        unset($_COOKIE['userid']);
        unset($_COOKIE['password']);
    }
    function search(string $search_query) {
        if(check_special($search_query)) die_custom("Query không được chứa kí tự đặc biệt.", "./");
        $sql_query = "SELECT * FROM `product` WHERE `name` LIKE '%".$search_query."%' OR `category` LIKE '%".$search_query."%'";
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $sql_query) or die("không thể lấy thông tin sản phẩm");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
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
            <script src="./js/daotao.js"></script>
            <script src="./js/dichvuchinh.js"></script>
        </head>
        <?php
    }
    function nav($slider = true) { // menu trang web
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
                            <a class="nav-link" href="#">TIN TỨC-SỰ KIỆN</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#daotao" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ĐÀO TẠO</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">KHÓA HỌC PIANO</a>
                                <a class="dropdown-item" href="#">KHÓA HỌC GUITAR</a>
                                <a class="dropdown-item" href="#">KHÓA HỌC UKULELE</a>
                                <a class="dropdown-item" href="#">KHÓA HỌC VIOLIN</a>
                                <a class="dropdown-item" href="#">KHÓA HỌC ORGAN</a>
                                <a class="dropdown-item" href="#">KHÓA HỌC THANH NHẠC</a>
                                <a class="dropdown-item" href="#">KHÓA HỌC ABRSM</a>
                                <a class="dropdown-item" href="#">ĐÀO TẠO NHẠC CÔNG</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#sanpham" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SẢN PHẨM</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">ĐÀN PIANO</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">- GRAND PIANO</a>
                                <a class="dropdown-item" href="#">- UPRIGHT PIANO</a>
                                <a class="dropdown-item" href="#">- DIGITAL PIANO</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">ĐÀN GUITAR</a>
                                <a class="dropdown-item" href="#">ĐÀN ORGAN</a>
                                <a class="dropdown-item" href="#">ĐÀN UKULELE</a>
                                <a class="dropdown-item" href="#">ĐÀN VIOLIN</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#dichvuchinh">DỊCH VỤ</a>
                        </li>
                        <?php
                            if(isset($_COOKIE['userid']) && isset($_COOKIE['password'])) {
                                if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) {
                                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#sanpham" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ADMIN</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./upload.php">ĐĂNG SẢN PHẨM</a>
                                <a class="dropdown-item" href="./uploadpost.php">ĐĂNG BÀI VIẾT</a>
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
		<footer class="row bg-dark text-white">
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
            window.onscroll = function() {
                fixedMenu();
            };
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
            var iSanPham = document.querySelectorAll("#sanpham-content .iSanPham");
            var iDaoTao = document.querySelectorAll("#daotao-content .iDaoTao");
            var iDichVuChinh = document.querySelectorAll("#dichvuchinh-content .col-md-4");
            var iTinTuc = document.querySelectorAll("#tintuc .col-md-4");
            // Window onresize event
            window.addEventListener("resize", responsiveWidth);
            // Set height to responsive elements
            function responsiveWidth() {
                if(mapContent!=null)
                    mapContent.height = mapContent.offsetWidth;
                if(iframeContent!=null)
                    iframeContent.height = iframeContent.offsetWidth*.25;
                for(var i=0; i<iSanPham.length; i++)
                    iSanPham[i].style.cssText += "; height: "+iSanPham[i].offsetWidth*0.5+"px;";
                for(var i=0; i<iDaoTao.length; i++)
                    iDaoTao[i].style.cssText += "; height: "+iDaoTao[i].offsetWidth*0.5+"px;";
                for(var i=0; i<iDichVuChinh.length; i++)
                    iDichVuChinh[i].style.cssText += "; height: "+iDichVuChinh[i].offsetWidth*0.5+"px;";
                for(var i=0; i<iTinTuc.length; i++)
                    iTinTuc[i].style.cssText += "; height: "+iTinTuc[i].offsetWidth*0.5+"px;";
            }
            responsiveWidth();
            
            // Custom CSS
            var iTrungTam = document.getElementsByClassName("trungtam");
            for(var i=0; i<iTrungTam.length; i++) {
                iTrungTam[i].style.top = (iTrungTam[i].parentElement.offsetHeight-iTrungTam[i].offsetHeight)*0.5;
            }
        </script>
        <?php
    }
?>