<?php
    require("lib.php");
?>
<!DOCTYPE html>
<html>
	<?php head("Tìm sản phẩm"); ?>
	<body>
		<div id="container" class="container-fluid p-0 m-0">
         <?php nav(); ?>
         <div class="content">
         <!-- products -->
         <div id="content" class="container p-0 mt-5 mb-5">
            <div class="container">
               <div class="row">
                  <div class="col-md-9">
                     <div id="products" class="row m-0">
                        <?php
                        if(isset($_GET['search'])) {
                           $data_product_search = search($_GET['search']);
                           if(sizeof($data_product_search)>0) {
                              for($i=0; $i<sizeof($data_product_search); $i++) {
                                 ?>
                                 <!--start_product-->
                                 <h3 class="d-block w-100 mb-2">TÌM KIẾM CHO TỪ KHÓA: <?php echo strtoupper($_GET['search']); ?></h3>
                                 <div class="card col-md-3 p-0">
                                    <div style="width: 100%; height: 275.5px; overflow: hidden; background: url('<?php echo $data_product_search[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div>
                                    <div class="card-body">
                                       <h5 class="card-title product-title title_sanpham"><a href="./product.php?id=<?php echo $data_product_search[$i]['id']; ?>"><?php echo $data_product_search[$i]['name']; ?></a></h5>
                                       <a class="card-text product-price"><?php echo $data_product_search[$i]['price']; ?></a><br/>
                                    </div>
                                 </div>
                                 <!--end_product-->
                                 <?php
                              }
                           }
                           else {
                              ?>
                              <h3>KHÔNG CÓ SẢN PHẨM NÀO TRÙNG VỚI TỪ KHÓA: <?php echo strtoupper($_GET['search']); ?></h3>
                              <?php
                           }
                        }
                        else {
                           $data_product = lay_san_pham();
                           if(sizeof($data_product)>0) {
                              for($i=0; $i<sizeof($data_product); $i++) {
                                 ?>
                                 <!--start_product-->
                                 <div class="card col-md-3 p-0">
                                    <div style="width: 100%; height: 206.25px; overflow: hidden; background: url('<?php echo $data_product[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div>
                                    <div class="card-body">
                                       <h5 class="card-title product-title title_sanpham"><a href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
                                       <a class="card-text product-price"><?php echo $data_product[$i]['price']; ?></a><br/>
                                    </div>
                                 </div>
                                 <!--end_product-->
                                 <?php
                              }
                           }
                           else {
                              ?>
                              <h3>TẠM THỜI CHƯA CÓ SẢN PHẨM</h3>
                              <?php
                           }
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <script type="text/javascript">
            var title_sanpham = document.getElementsByClassName("title_sanpham");
            for(var i=0; i<title_sanpham.length; i++) {
               if(title_sanpham[i].innerHTML.length>60) title_sanpham[i].innerHTML = title_sanpham[i].innerHTML.slice(0, 60)+"...";
               else title_sanpham[i].innerHTML = title_sanpham[i].innerHTML+"\xa0".repeat(60-title_sanpham[i].innerHTML.length);
            }
         </script>
         <!-- end products -->
			<?php foot(); ?>
		</div>
	</body>
</html>
