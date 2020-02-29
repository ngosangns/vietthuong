<?php
	require("lib.php");
	if(isset($_GET['id'])) {
		$datasp = lay_san_pham("id", $_GET['id']);
		$data_product = search($datasp[0]['category'], "product", $_GET['id']);
	}
	else header("Location: ./");
?>
<?php contentTop($datasp[0]['name']); ?>
<div class="row">
	<div class="col-md-6">
		<img src="<?php echo $datasp[0]['image']; ?>" width=100%>
	</div>
	<div class="col-md-6">
		<h2><?php echo $datasp[0]['name']; ?><?php if(displayforLogged()) echo "<small><a class='text-muted ml-2 text-decoration-none' style='font-size: 14px' href='./edit-sanpham.php?id=".$_GET['id']."'>Sửa sản phẩm</a></small>"; ?></h2>
		<h6 class="text-danger">Giá: <?php echo $datasp[0]['price']; ?></h6>
		<h6 class="text-muted">Loại: <?php echo $datasp[0]['category']; ?></h6>
		<h6 class="text-muted">Mã sản phẩm: <?php echo $datasp[0]['code']; ?></h6>
		<span class="text-muted">MÔ TẢ SẢN PHẨM:</span><br/>
		<span><?php echo $datasp[0]['comment']; ?></span><br/><br/>
	</div>
	<div class="col-md-12">
		<h3 class="d-block w-100 mb-3 mt-5 pt-3" style="border-top: 1px solid gray">SẢN PHẨM LIÊN QUAN: </h3>
		<div id="products" class="row m-0">
			<?php
			if(sizeof($data_product)>0) {
				for($i=0; $i<sizeof($data_product); $i++) {
					?>
					<!--start_product-->
					<div class="rounded shadow">
						<div class="card border-0 p-0">
							<a href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><div class="product-image" style="width: 100%; height: 400px; overflow: hidden; background: url('<?php echo $data_product[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div></a>
							<div class="card-body">
								<h5 class="card-title product-title title_sanpham"><a class="title_sanpham_a text-break" href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></h5>
								<a class="card-text product-price"><?php echo $data_product[$i]['price']; ?></a><br/>
							</div>
						</div>
					</div>
					<!--end_product-->
					<?php
					if($i==5) break;
				}
			}
			?>
		</div>
	</div>
</div>
<?php contentBottom(); ?>