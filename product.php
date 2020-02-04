<?php
	require("lib.php");
	if(isset($_GET['id'])) {
		$datasp = lay_san_pham("id", $_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<?php head($datasp[0]['name']); ?>
</head>
<body>
	<?php nav(false); ?>
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
			</div>
		</div>
	</div>

	<?php foot(); ?>
</body>
</html>
<?php
	}
	else {
		header("Location: ./");
	}
?>