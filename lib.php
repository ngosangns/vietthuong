<?php
	require("dbconnect.php"); // $db_connect $GLOBALS['db_connect']










    // Linh tinh
    // check ki tu dac biet
    function check_special(string $string_query)
    {
        return preg_match("/[!#$%^&*\=\[\]{};':\"\\<>\/?]/", $string_query);
    }
    function remove_special(string $string_query)
    {
        return preg_replace("/[!#$%^&*\=\[\]{};':\"\\<>\/?]/", "", $string_query);
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










    // API
    function lay_san_pham(string $query_key="", string $query_data="") {
        if($query_key == "") {
            $db_query = "SELECT * FROM `product`"." ORDER BY `id` DESC";
        }
        else {
            $db_query = "SELECT * FROM `product` WHERE `".$query_key."`='".addslashes($query_data)."'"." ORDER BY `id` DESC";
        }
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $db_query) or die_custom("không thể lấy thông tin sản phẩm");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
            $sanpham['price'] = intval($sanpham['price'])==0?"Liên hệ":number_format($sanpham['price'])." VND"; // xu li price
            $array_sp[] = $sanpham;
        }
        return $array_sp;
    }

    function lay_bai_viet(string $query_key="", string $query_data="", bool $onlyhot = false, $enavleDisplaytt = true) {
        if($query_key == "") {
            $db_query = "SELECT * FROM `post`"." WHERE 1=1".($enavleDisplaytt?" AND `displaytt` = 1":"").($onlyhot?" AND `dangdienra` = 1":"")." ORDER BY `id` DESC";
        }
        else {
            $db_query = "SELECT * FROM `post` WHERE `".$query_key."`='".addslashes($query_data)."'".($enavleDisplaytt?" AND `displaytt` = 1":"").($onlyhot?" AND `dangdienra` = 1":"")." ORDER BY `id` DESC";
        }
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $db_query) or die("không thể lấy thông tin bài viết");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
            $array_sp[] = $sanpham;
        }
        return $array_sp;
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
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], "SELECT `image` FROM `".$layout."` WHERE `id` = '".addslashes($id)."'") or die_custom("Có lỗi khi cập nhật sản phẩm");
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
            // Kiểm tra displaytt và dangdienra
            $dangdienra = 0; if(isset($_POST['dangdienra'])) $dangdienra = $_POST['dangdienra'];
            $displaytt = 0; if(isset($_POST['displaytt'])) $displaytt = $_POST['displaytt'];
            // Kiểm tra description
            $descr = ""; if(isset($_POST['descr'])) $descr = $_POST['descr'];
            // Nhập/Update bài viết
            if($action == "edit") $sql_query = "UPDATE `post` SET `name` = '".addslashes($_POST['name'])."', `dangdienra` = ".$dangdienra.", `displaytt` = '".$displaytt."', `category` = '".addslashes($_POST['category'])."', `image` = '".addslashes($avatar_path)."', `descr` = '".addslashes($descr)."', `comment` = '".addslashes($comment)."' WHERE `id` = ".addslashes($id);
            else $sql_query = "INSERT INTO `post`(`name`, `displaytt`, `dangdienra`, `category`, `image`, `descr`, `comment`) VALUES('".addslashes($_POST['name'])."', ".$displaytt.", ".$dangdienra.", '".addslashes($_POST['category'])."', '".addslashes($avatar_path)."', '".addslashes($descr)."', '".addslashes($comment)."')";
            mysqli_query($GLOBALS['db_connect'], $sql_query) or die_custom("Lỗi khi cập nhật bài viết");
            header("Location: ./quanli-baiviet.php");
        }
        if($layout == "product") {
            // Kiếm tra code sản phẩm
            if(!isset($_POST['code'])) return;
            if(strlen($_POST['code'])==0) die_custom("Các trường đánh dấu * là bắt buộc.");
            // Kiểm tra giá sản phẩm
            if(isset($_POST['price'])) $giasp=(int)$_POST['price'];
            // Nhập/Update sản phẩm
            if($action == "edit") $sql_query = "UPDATE `product` SET `code` = '".addslashes($_POST['code'])."', `name` = '".addslashes($_POST['name'])."', `category` = '".addslashes($_POST['category'])."', `price` = '".addslashes($giasp)."', `image` = '".addslashes($avatar_path)."', `comment` = '".addslashes($comment)."' WHERE `id` = ".addslashes($id);
            else $sql_query = "INSERT INTO `product`(`code`, `name`, `category`, `price`, `image`, `comment`) VALUES('".addslashes($_POST['code'])."', '".addslashes($_POST['name'])."', '".addslashes($_POST['category'])."', ".addslashes($giasp).", '".addslashes($avatar_path)."', '".addslashes($comment)."')";
            mysqli_query($GLOBALS['db_connect'], $sql_query) or die_custom("Lỗi khi cập nhật sản phẩm");
            header("Location: ./quanli-sanpham.php");
        }
    }










    // Authorize
    function kt_level(string $iduser, string $password="") {
        if(check_special($iduser)||check_special($password)) die_custom("Cookie không được chứa kí tự đặc biệt.", "./");
        if($password=="") $sql_query = "SELECT `username` FROM `user` WHERE `id`='".addslashes($iduser)."'";
        else $sql_query = "SELECT `username` FROM `user` WHERE `id`='".addslashes($iduser)."' AND `password`='".addslashes($password)."'";
        $result = mysqli_query($GLOBALS['db_connect'], $sql_query);
        $result = mysqli_fetch_assoc($result);
        if(isset($result['username'])) return 1;
        else return 0;
    }
    function checkDangNhap() {
        if(!isset($_COOKIE['userid']) || !isset($_COOKIE['password'])) die_custom("Bạn chưa đăng nhập", "./login.php");
        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])==0) die_custom("Tài khoản sai", "./login.php?logout");
    }
    function displayforLogged() {
        if(isset($_COOKIE['userid']) && isset($_COOKIE['password'])) if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) return true;
        return false;
    }










    // Search
    function search(string $search_query, string $layout = "product", string $excludee = "") {
        $search_query = trim($search_query);
        $excludee = trim($excludee);
        if(check_special($search_query)) die_custom("Query không được chứa kí tự đặc biệt.", "./");
        $excludee_query = "";
        if($excludee != "") $excludee_query = " AND NOT `id` = ".addslashes($excludee);
        $sql_query = "SELECT * FROM `".$layout."` WHERE (`name` LIKE '%".addslashes($search_query)."%' OR `category` LIKE '%".addslashes($search_query)."%')".addslashes($excludee_query)." ORDER BY `id` DESC";
        $db_sanpham = mysqli_query($GLOBALS['db_connect'], $sql_query) or die("không thể lấy thông tin sản phẩm");
        $array_sp = [];
        while($sanpham = mysqli_fetch_assoc($db_sanpham)) {
            if($layout == "product")
                $sanpham['price'] = intval($sanpham['price'])==0?"Liên hệ":number_format($sanpham['price'])." VND"; // xu li price
            $array_sp[] = $sanpham;
        }
        return $array_sp;
    }










    // Template
    function contentTop(string $titleHeader = "", $enableSlide = false) {
        ?>
        <!DOCTYPE html>
        <html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <!-- Required meta tags -->
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title><?php echo $titleHeader; ?> - ROSE 9</title>
                <link rel="shortcut icon" type="image/png" href="./image/logo.png">
                <link rel="stylesheet" href="./css/bootstrap.min.css" crossorigin="anonymous">

                <script src="./js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
                <script src="./js/popper.min.js" crossorigin="anonymous"></script>
                <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>

                <link rel="stylesheet" href="./css/style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <script src="./js/sanpham.js"></script>
                <script>
                    function confirmDelete(dbutton) {
                        if(confirm("Bạn có chắc chắn muốn xóa không?"))
                            try {window.location = $(dbutton).attr("href"); } catch(e) {}
                    }
                </script>
            </head>
            <body>
                <div id="container" class="w-100 mx-auto m-0">
                <header class="container bg-white shadow rounded-bottom mb-3">
                    <div id="header-banner">
                        <center>
                            <div id="main-banner">
                                <a id="main-link">
                                   <a href="/"><img id="main-image" class="img-fluid w-100" src="https://3.pik.vn/2020371cc3c7-9538-4923-8cb9-d89f075b24c8.png"/> </a>
                                </a>
                            </div>
                        </center>
                    </div>
                    <nav id="menu" class="menu bg-dark text-light">
                        <button id="toggleMenu" class="btn btn-outline-light d-none m-3"><i class="fa fa-bars"></i></button>
                        <ul>
                            <li><a href="/">HOME</a></li>
                            <li><a href="./baiviet.php?id=15">GIỚI THIỆU</a></li>
                            <li><a href="./tintuc.php">TIN TỨC-SỰ KIỆN</a></li>
                            <li><a href="./#daotao">ĐÀO TẠO</a>
                                <ul>
                                    <li><a href="./baiviet.php?id=12">KHÓA HỌC PIANO</a></li>
                                    <li><a href="./baiviet.php?id=10">KHÓA HỌC GUITAR</a></li>
                                    <li><a href="./baiviet.php?id=7">KHÓA HỌC UKULELE</a></li>
                                    <li><a href="./baiviet.php?id=11">KHÓA HỌC VIOLIN</a></li>
                                    <li><a href="./baiviet.php?id=8">KHÓA HỌC ORGAN</a></li>
                                    <li><a href="./baiviet.php?id=9">KHÓA HỌC THANH NHẠC</a></li>
                                    <li><a href="./baiviet.php?id=6">KHÓA HỌC ABRSM</a></li>
                                    <li><a href="./baiviet.php?id=5">ĐÀO TẠO NHẠC CÔNG</a></li>
                                </ul>
                            </li>
                            <li><a href="./#sanpham">SẢN PHẨM</a>
                                <ul>
                                    <li><a href="./search.php?search=Piano">ĐÀN PIANO</a>
                                        <ul>
                                            <li><a href="./search.php?search=Grand Piano">- GRAND PIANO</a></li>
                                            <li><a href="./search.php?search=Upright Piano">- UPRIGHT PIANO</a></li>
                                            <li><a href="./search.php?search=Digital Piano">- DIGITAL PIANO</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="./search.php?search=Guitar">ĐÀN GUITAR</a></li>
                                    <li><a href="./search.php?search=Organ">ĐÀN ORGAN</a></li>
                                    <li><a href="./search.php?search=Ukulele">ĐÀN UKULELE</a></li>
                                    <li><a href="./search.php?search=Violin">ĐÀN VIOLIN</a></li>
                                </ul>
                            </li>
                            <li><a href="./#dichvuchinh">DỊCH VỤ</a></li>
                    <?php
                    if(isset($_COOKIE['userid']) && isset($_COOKIE['password'])) {
                        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) { ?>
                            <li>
                                <a href="./quanli-sanpham.php">ADMIN</a>
                                <ul>
                                    <li><a href="./quanli-sanpham.php">QUẢN LÍ SẢN PHẨM</a></li>
                                    <li><a href="./quanli-baiviet.php">QUẢN LÍ BÀI VIẾT</a></li>
                                    <li><a href="./login.php?logout">ĐĂNG XUẤT</a></li>
                                </ul>
                            </li>
                        <?php }
                        else die_custom("User không đúng", "./login.php?logout");
                    }
                    else { ?>
                            <li>
                                <a href="./login.php">ĐĂNG NHẬP</a>
                            </li>
                    <?php } ?>
                            <form class="form-inline" action="./search.php" method="get">
                                <input class="form-control mr-1" type="text" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                                <button class="btn btn-outline-btn btn-outline-light my-2 my-sm-0 my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </ul>
                    </nav>
                    <?php
                    if($enableSlide) {
                        ?>
                        <section id="iframe">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                      <img class="d-block w-100" src="./img/slide/s1.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s2.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s3.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s4.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s5.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s6.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s7.jpg">
                                    </div>
                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="./img/slide/s8.jpg">
                                    </div>
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
                        </section>
                        <?php
                    }
                    ?>
                </header>
                <div id="content" class="container shadow rounded p-5">
        <?php
    }
    function contentBottom($enableFoot = true) {
        ?></div> <?php
        if($enableFoot) {
            ?>
            <footer class="bg-dark text-white mt-5">
                <div class="row container mx-auto p-0">
                    <div class="col-md-4 p-4">
                        <h5>Công ty ROSE 9</h5>
                        <p>
                            Cơ sở 1: <b> 71/25 Điện Biên Phủ, P15, q. Bình Thạnh, TP HCM.</b><br/>
                            Cơ sở 2: <b>188/1 Nguyễn Văn Hưởng, p. Thảo Điền, Q2, TP HCM.</b><br/>

                                Liên hệ: <b>0908 277 181 </b>
                            
                        </p>
                    </div>
                    <div class="col-md-4 p-4">
                        <!-- Social -->
                        <h5>Social</h5>
                        <p>
                            <a href="https://www.facebook.com/hayho.life" target="_blank"><img class="rounded-pill mr-2" src="./img/facebook.png" alt="Facebook" width="20%"></a>
                            <a href="https://www.youtube.com/channel/UCSZPhRlK5mAycThqQMYHsNw?view_as=subscriber&fbclid=IwAR25KkVIVYMXDTZJvvw1WgcLQGW0j2G21lUeduI4T51ewtvjsE35gj0DWt0" target="_blank"><img class="rounded-pill" src="./img/youtube.png" alt="Youtube" width="20%"></a>
                        </p>

                        <!-- Nhà tài trợ -->
                        <h5>Nhà tài trợ</h5>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                        <a  href="/"><div class="d-inline-block rounded-pill mr-2 mb-2" style="width: 70px; height: 70px; background-color: grey; background-image: url();"></div></a>
                    </div>
                    <div class="col-md-4 p-4">
                        <!-- Map -->
                        <h5>Map</h5>
                        <iframe id="map-content" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6735.154011947664!2d106.72591466366434!3d10.816427401342537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317526242b9ccde7%3A0x4531fcd4a75562f5!2zMTg4LzEgTmd1eeG7hW4gVsSDbiBIxrDhu59uZywgVGjhuqNvIMSQaeG7gW4sIFF14bqtbiAyLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1581011464456!5m2!1svi!2s" width="100%" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
            </footer>
            </div>
            <!-- Load Facebook SDK for JavaScript -->
            <div id="fb-root"></div>
            <script>
            window.fbAsyncInit = function() {
              FB.init({
                xfbml            : true,
                version          : 'v6.0'
              });
            };

            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            <!-- Your customer chat code -->
            <div class="fb-customerchat"
                attribution=setup_tool
                page_id="100566578194928"
                theme_color="#a695c7">
            </div>
            <?php
        }
        else {
            ?> <footer class="mt-5"></footer> <?php
        }
        ?>
                <script>
                    // Fixed menu on scroll
                    window.onscroll = function() { fixedMenu() };
                    var mainMenu = document.getElementById("menu");
                    var stickyMenu = mainMenu.offsetTop;
                    function fixedMenu() {
                        if (window.pageYOffset > stickyMenu) {
                            mainMenu.classList.add("fixed-top");
                        } else mainMenu.classList.remove("fixed-top");
                    }
                    // Slide
                    var carouselItems = document.querySelectorAll(".carousel-item img");


                    // Window onresize event
                    window.addEventListener("resize", responsiveWidth);
                    // Set height to responsive elements
                    function responsiveWidth() {
                        // Responsive menu
                        if(window.innerWidth < 1100) {
                            if(!$('#menu').hasClass('mmenu')) $('#menu').addClass('mmenu');
                            $('#menu').css('max-height', window.innerHeight);
                            if(!$('#menu>ul').hasClass('d-none')) $('#menu>ul').addClass('d-none');
                            if(!$('#menu>ul>li>ul').hasClass('d-none')) $('#menu>ul>li>ul').addClass('d-none');
                            if($('#menu>button').hasClass('d-none')) $('#menu>button').removeClass('d-none');
                            if(!$('#menu>ul>li>form').hasClass('pb-4')) $('#menu>ul>li>form').addClass('pb-4');
                            $('#menu>ul>li').each((index, item) => {
                                if($(item).children('ul').length>0) {
                                    if($(item).children('a').length==1)
                                        $(item).children('a').after(`<a class="menu-dropdown-button pr-3">▼</a>`);
                                }
                            })
                        }
                        else {
                            $('#menu').removeClass('mmenu');
                            $('#menu').css('max-height', 'auto');
                            if($('#menu>ul').hasClass('d-none')) $('#menu>ul').removeClass('d-none');
                            if($('#menu>ul>li>ul').hasClass('d-none')) $('#menu>ul>li>ul').removeClass('d-none');
                            if(!$('#menu>button').hasClass('d-none')) $('#menu>button').addClass('d-none');
                            if($('#menu>ul>li>form').hasClass('pb-4')) $('#menu>ul>li>form').removeClass('pb-4');
                            if($('.menu-dropdown-button').length>0) $('.menu-dropdown-button').remove();
                        }

                        // Responsive section and map
                        $("#map-content").css({ 'height': $("#map-content").width() });
                        $(".iGrid").each((index, item) => {
                            $(item).css({
                                'height' : $(item).width()*.5+"px"
                            })
                        });
                        $(".iTin .col-md-4").each((index, item) => {
                            $(item).css({ 'height' : $(item).width()*.5+"px" })
                        });
                        $(".iYoutubeVideos .col-md-7 iframe").each((index, item) => {
                            $(item).css({ 'height' : $(item).width()*.5+"px" })
                        });
                        $(".trungtam").each((index, item) => {
                            $(item).css({ 'top' : ($(item).parent().height()-$(item).height())*.5+"px" })
                        });
                        $(".product-image").each((index, item) => {
                            $(item).css({ 'height' : $(item).width() })
                        });
                    }
                    responsiveWidth();

                    // Menu toggle
                    $('#toggleMenu').click(() => {
                        $("#menu>ul").toggleClass('d-none');
                    });
                    $(document).on('click', '.menu-dropdown-button', function(e){
                        e.preventDefault();
                        let instance = $(this).parent().children('ul');
                        let status = !instance.hasClass('d-none');
                        $("#menu>ul>li>ul").each((index, item) => {
                            if(!$(item).hasClass('d-none')) $(item).addClass('d-none');
                        });
                        if(!status) instance.removeClass('d-none');
                    });
                </script>
            </body>
        </html>
        <?php
    }
?>