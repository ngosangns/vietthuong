<?php
	require("lib.php");
	if(isset($_GET['id'])) {
		$datasp = lay_bai_viet("id", $_GET['id']);
		if(sizeof($datasp)==0) header("Location: ./");
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
                <div class="col-md-12">
                    <h2><?php echo $datasp[0]['name']; ?></h2>
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