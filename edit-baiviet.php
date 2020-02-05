<?php
	require("lib.php");
	if(isset($_GET['id'])) {
		$datasp = lay_bai_viet("id", $_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<?php head("Sửa: ".$datasp[0]['name']); ?>
</head>
<body>
	<?php nav(false); ?>
	<div class="content">
		<div id="content" class="container p-0 mt-5 mb-5">
			<div class="row">
                <div class="col-md-12">
                    <h5><?php echo $datasp[0]['name']; ?></h5>
                    <hr>
                    <?php echo $datasp[0]['comment']; ?>
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