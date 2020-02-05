<?php
	require("lib.php");
	if(isset($_GET['id'])) {
		$datasp = lay_san_pham("id", $_GET['id']);
		$data_product = search($datasp[0]['category'], "product", $_GET['id']);
	}
	else header("Location: ./");
?>
<?php contentTop($datasp[0]['name']); ?>
<div class="content">
	<div id="content" class="container p-0 mt-5 mb-5">
		<div class="row">
			<div class="col-md-6">
				<img src="<?php echo $datasp[0]['image']; ?>" width=100%>
			</div>
			<div class="col-md-6">
				<h2><?php echo $datasp[0]['name']; ?></h2>
				<h6 class="text-muted">Giá: <?php echo $datasp[0]['price']; ?></h6>
				<h6 class="text-muted">Loại: <?php echo $datasp[0]['category']; ?></h6>
				<h6 class="text-muted">Mã sản phẩm: <?php echo $datasp[0]['code']; ?></h6>
				<span class="text-muted">MÔ TẢ SẢN PHẨM:</span><br/>
				<span><?php echo $datasp[0]['comment']; ?></span><br/><br/>
			</div>
			<div class="col-md-12">
				<h3 class="d-block w-100 mb-3 mt-5 pt-3" style="border-top: 1px solid gray">Sản phẩm liên quan: </h3>
				<div id="products" class="row m-0">
					<?php
					if(sizeof($data_product)>0) {
						for($i=0; $i<sizeof($data_product); $i++) {
							?>
							<!--start_product-->
							<div class="col-md-4 p-2">
								<div class="card p-0">
								<a href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><div style="width: 100%; height: 400px; overflow: hidden; background: url('<?php echo $data_product[$i]['image']; ?>') no-repeat center center; background-size: cover;"></div></a>
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
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php contentBottom(); ?>