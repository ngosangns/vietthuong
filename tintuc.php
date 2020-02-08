<?php
    require("lib.php");
?>
<!DOCTYPE html>
<html>
	<?php head("Tin tức"); ?>
	<body>
		<div id="container" class="container-fluid p-0 m-0">
         <?php nav(); ?>
         <div class="content">
         <!-- products -->
         <div id="content" class="container p-0 mt-5 mb-5">
            <div class="container">
               <div class="row">
                  <div class="col-md-8">
                     <div id="tintuc" class="row m-0">
                        <?php
                        $data_product = lay_bai_viet();
                        if(sizeof($data_product)>0) {
                            ?>
                            <h3 class="d-block w-100 mb-3">Tin tức - sự kiện: </h3>
                            <?php
                            for($i=0; $i<sizeof($data_product); $i++) {
                                if($i == 0) {
                                    ?>
                                    <!--start_product-->
                                    <div class="col-md-12 p-2">
                                        <div class="card p-0">
                                        <a href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><div style="width: 100%; height: 400px; overflow: hidden; background: url('<?php echo $data_product[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div></a>
                                        <div class="card-body">
                                            <h5 class="card-title product-title title_sanpham"><a class="title_sanpham_a" href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
                                        </div>
                                        </div>
                                    </div>
                                    <!--end_product-->
                                    <?php
                                }
                                else if($i>=1 && $i <=4) {
                                    ?>
                                    <!--start_product-->
                                    <div class="col-md-6 p-2">
                                        <div class="card p-0">
                                        <a href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><div style="width: 100%; height: 200px; overflow: hidden; background: url('<?php echo $data_product[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div></a>
                                        <div class="card-body">
                                            <h5 class="card-title product-title title_sanpham"><a class="title_sanpham_a" href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
                                        </div>
                                        </div>
                                    </div>
                                    <!--end_product-->
                                    <?php
                                }
                                else {
                                ?>
                                <!--start_product-->
                                <div class="col-sm-12 iTin mt-4" <?php echo ($i<sizeof($data_product)-1?'style="border-bottom: 1px dashed black"':'') ?>>
                                    <div class="row mb-4">
                                        <div class="col-md-4 mb-4">
                                            <a class="d-block w-100 h-100" href="#" style="background-image:url(<?php echo $data_product[$i]['image']; ?>); background-size: cover;"></a>
                                        </div>
                                        <div class="col-md-8">
                                            <h5><a href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
                                            <p class="d-block w-100">
                                                <?php echo $data_product[$i]['descr']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--end_product-->
                                <?php
                                }
                            }
                        }
                        else {
                            ?>
                            <h3>Tạm thời chưa có bài viết</h3>
                            <?php
                        }
                        ?>
                     </div>
                  </div>
                  <div class="col-md-4">
                    <div id="hot" class="row m-0">
                        <h3 class="d-block w-100 mb-3 text-danger">Đang diễn ra: </h3>
                        <?php
                        $data_product = lay_bai_viet("","",true);
                        if(sizeof($data_product)>0) {
                            for($i=0; $i<sizeof($data_product); $i++) {
                                ?>
                                <!--start_product-->
                                <div class="col-sm-12 iTin mt-4">
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-4">
                                        <a class="d-block w-100 h-100" href="#" style="background-image:url(<?php echo $data_product[$i]['image']; ?>); background-size: cover;"></a>
                                    </div>
                                    <div class="col-md-8">
                                        <h5><a href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                                <!--end_product-->
                                <?php
                            }
                        }
                        else {
                            ?>
                            <h5>Tạm thời chưa có bài viết</h5>
                            <?php
                        }
                        ?>
                    </div>
                  </div>
               </div>
            </div>
         </div>
         <script type="text/javascript">
            var title_sanpham = document.getElementsByClassName("title_sanpham_a");
            for(var i=0; i<title_sanpham.length; i++) {
                title_sanpham[i].style.cssText += "; text-decoration: none;";
                if(title_sanpham[i].innerHTML.length>60) title_sanpham[i].innerHTML = title_sanpham[i].innerHTML.slice(0, 60)+"...";
                else title_sanpham[i].innerHTML = title_sanpham[i].innerHTML+" "+"\xa0".repeat(60-title_sanpham[i].innerHTML.length);
            }
        </script>
         <!-- end products -->
			<?php foot(); ?>
		</div>
	</body>
</html>