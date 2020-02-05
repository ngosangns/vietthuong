<?php
    require("lib.php");
?>
<!DOCTYPE html>
<html>
	<?php head("Home"); ?>
	<body>
		<div id="container" class="container-fluid p-0 m-0">
			<?php nav(); ?>
			<center>
            <section id="iframe">
                <iframe src="https://albumizr.com/a/QWYm" scrolling="no" frameborder="0" allowfullscreen width="100%" height="400"></iframe>
            </section>
            </center>
			<div class="container mx-auto">
					<!-- Sản phẩm -->
					<section id="sanpham" class="data-section">
						<h2><a>Sản phẩm</a></h2>
						<div id="sanpham-content" class="row"></div>
					</section>
					<!-- Đào tạo -->
					<section id="daotao" class="data-section">
						<h2><a>Đào tạo</a></h2>
						<div class="row">
							<?php
							$dichvuchinhPosts = search("ĐÀO TẠO - ", "post");
							if(sizeof($dichvuchinhPosts)>0) {
								for($i=0; $i<sizeof($dichvuchinhPosts); $i++) {
									?>
									<div class="col-sm-4 iGrid p-2">
										<a class="d-block w-100 h-100" href="./baiviet.php?id=<?php echo $dichvuchinhPosts[$i]['id']; ?>"  style="background-image:url(<?php echo $dichvuchinhPosts[$i]['image']; ?>); background-size: cover;">
											<div class="trungtam"><?php echo preg_replace("/ĐÀO TẠO - /", "", $dichvuchinhPosts[$i]['name']); ?></div>
										</a>
									</div>
									<?php
								}
							}
							?>
						</div>
					</section>

					<!-- Dịch vụ chính -->
					<section id="dichvuchinh" class="data-section">
						<h2><a>Dịch vụ chính</a></h2>
						<div id="dichvuchinh-content" class="row">
							<?php
							$dichvuchinhPosts = search("Dịch vụ chính -", "post");
							if(sizeof($dichvuchinhPosts)>0) {
								for($i=0; $i<sizeof($dichvuchinhPosts); $i++) {
									$iImage = '<div class="col-md-4 '.($i%2==0?'mb-4':'').'"><a class="d-block w-100 h-100" href="./baiviet.php?id='.$dichvuchinhPosts[$i]["id"].'" style="background-image:url('.$dichvuchinhPosts[$i]["image"].'); background-size: cover;"></a></div>';
									$iContent = '<div class="col-md-8"><h5><a class="text-dark text-decoration-none" href="./baiviet.php?id='.$dichvuchinhPosts[$i]["id"].'">'.preg_replace("/DỊCH VỤ CHÍNH - /", "", $dichvuchinhPosts[$i]["name"]).'</a></h5><p class="d-block w-100">'.$dichvuchinhPosts[$i]["descr"].'</p></div>';
									?>
									<div class="col-sm-12 iTin mt-4" <?php echo ($i<sizeof($dichvuchinhPosts)-1?'style="border-bottom: 1px dashed black"':'') ?>>
										<div class="row mb-4">
											<?php echo ($i%2==0?($iImage.$iContent):($iContent.$iImage)); ?>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</section>
			</div>
			<script>
				// Sản phẩm
				function appendSanPham() {
					for(var i=0; i<sanpham.length; i++) {
						document.getElementById("sanpham-content").innerHTML += `
							<div class="col-sm-4 iGrid p-2">
								<a class="d-block w-100 h-100" href="`+sanpham[i].link+`" style="background-image:url(./img/sanpham/`+sanpham[i].image+`); background-size: cover;">
									<div class="trungtam">`+sanpham[i].name+`</div>
								</a>
							</div> 
						`;
					}
				}
				appendSanPham();
			</script>
			<?php foot(); ?>
		</div>
	</body>
</html>