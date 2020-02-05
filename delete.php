<?php
    require("./lib.php");
    if(isset($_GET['productid'])) {
        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) {
            $sql_query = "DELETE FROM `product` WHERE `id` = '".$_GET['productid']."'";
            mysqli_query($db_connect, $sql_query) or die_custom("Lỗi khi xóa sản phẩm");
            die_custom("Đã xóa sản phẩm", "./quanli-sanpham.php");
        }
    }
    if(isset($_GET['postid'])) {
        if(kt_level($_COOKIE['userid'], $_COOKIE['password'])>0) {
            $sql_query = "DELETE FROM `post` WHERE `id` = '".$_GET['postid']."'";
            mysqli_query($db_connect, $sql_query) or die_custom("Lỗi khi xóa bài viết");
            die_custom("Đã xóa bài viết", "./quanli-baiviet.php");
        }
    }
?>