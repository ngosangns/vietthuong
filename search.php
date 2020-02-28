<?php
    require("lib.php");
?>
<?php contentTop("Tìm sản phẩm"); ?>
<div id="products" class="row m-0">
   <?php
   if(isset($_GET['search'])) $data_product = search($_GET['search']);
   else $data_product = lay_san_pham();
   if(sizeof($data_product)>0) {
      if(isset($_GET['search'])) {
         ?>
            <h3 class="d-block w-100 mb-3">Tìm kiếm cho từ khóa: <?php echo ($_GET['search']); ?></h3>
         <?php
      }
      for($i=0; $i<sizeof($data_product); $i++) {
         ?>
         <!--start_product-->
         <div class="p-2 shadow-sm" style="width: 33.33333333%">
            <div class="card border-0 p-0">
            <a href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><div class="product-image" style="width: 100%; height: 400px; overflow: hidden; background: url('<?php echo $data_product[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div></a>
               <div class="card-body">
                  <h5 class="card-title product-title title_sanpham"><a class="title_sanpham_a" href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
                  <a class="card-text product-price"><?php echo $data_product[$i]['price']; ?></a><br/>
               </div>
            </div>
         </div>
         <!--end_product-->
         <?php
      }
   }
   else {
      if(isset($_GET['search'])) {
         ?>
            <h3 class="d-block w-100 mb-3">Không có sản phẩm nào trùng với từ khóa: <?php echo $_GET['search']; ?></h3>
         <?php
      }
      else {
         ?>
         <h3 class="d-block w-100 mb-3">Tạm thời chưa có sản phẩm</h3>
         <?php
      }
   }
   ?>
</div>
<!-- end products -->
<?php contentBottom(); ?>