<?php
	require("lib.php");
	if(isset($_GET['id'])) {
		$datasp = lay_bai_viet("id", $_GET['id']);
		if(sizeof($datasp)==0) header("Location: ./");
?>
	<?php contentTop($datasp[0]['name']); ?>
			<div class="row">
                <div class="col-md-12">
                    <h2><?php echo $datasp[0]['name']; if(displayforLogged()) echo "<small><a class='text-muted text-decoration-none ml-2' style='font-size: 14px' href='./edit-baiviet.php?id=".$_GET['id']."'>Sửa bài viết</a></small>"; ?></h2>
                    <hr>
                    <?php echo $datasp[0]['comment']; ?>
                </div>
			</div>
	<?php contentBottom(); ?>
<?php
	}
	else {
		header("Location: ./");
	}
?>