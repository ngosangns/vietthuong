<?php
    require("lib.php");
?>
<!DOCTYPE html>
<html>
	<?php head("Home"); ?>
	<body>
		<div id="container" class="container mx-auto p-0 m-0">
			<?php nav(); ?>
			<center>
            <section id="iframe">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="https://2.pik.vn/2020cbd588ec-68ce-4cb2-a015-a98a053df64b.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/2020f8494d93-88dc-4c9f-9506-a54614a3a143.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/20204c2f7933-7d33-46f1-9b04-73f55a3c4ae1.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/2020e1df8c67-39ba-43a0-a329-c1655df140cf.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/20209939ebd6-58d4-48d8-96c8-60c4a7f932fa.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/2020ba67ed9c-078e-415e-b471-c8efb61cecc4.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/20201851db85-6a84-4cf2-97ec-acf3fea29723.jpg">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://2.pik.vn/202075553f6a-5c40-4e5c-bc1f-7e90c9706732.jpg">
                    </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
            </section>
            </center>
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
				<style>
				    #youtubeVideos * {
				        color: white!important;
				    }
				</style>
				<!-- Youtube Videos -->
				<section id="youtubeVideos" style="background: #a07b40;" class="data-section">
				    <h2><a style="border-bottom: 3px solid white!important">Video</a></h2>
				    <div id="youtubeVideos-content" class="row"></div>
				</section>
			<script src="./js/youtube.js"></script>
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
		
				// Youtube Videos
                function appendYoutubeVideos() {
                    for(var i=0; i<youtubeVideos.length; i++) {
                        var iImage = `<div class="col-md-7 `+(i%2==0?`mb-4`:``)+`">
                                        <iframe class="d-block w-100" `+youtubeVideos[i].link.match(/src=".+?"/i)+` frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>`;
                        var iContent = `<div class="col-md-5">
                                            <h5>`+youtubeVideos[i].name+`</h5>
                                            <p class="d-block w-100">
                                                `+youtubeVideos[i].content+`
                                            </p>
                                        </div>`;
                        document.getElementById("youtubeVideos-content").innerHTML += `
                            <div class="col-sm-12 iYoutubeVideos mt-4" `+(i<youtubeVideos.length-1?`style="border-bottom: 1px dashed white"`:``)+`>
                                <div class="row mb-4">
                                    `+(i%2==0?(iImage+iContent):(iContent+iImage))+`
                                </div>
                            </div>
                        `;
                    }
                }
                appendYoutubeVideos();
			</script>
			<?php foot(); ?>
		</div>
	</body>
</html>