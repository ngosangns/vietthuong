<?php
    require("./lib.php");
?>
<?php contentTop("Home", true); ?>
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
				<div class="col-md-4 iGrid p-2">
					<a class="d-block w-100 h-100 rounded shadow" href="./baiviet.php?id=<?php echo $dichvuchinhPosts[$i]['id']; ?>"  style="background-image:url(<?php echo $dichvuchinhPosts[$i]['image']; ?>); background-size: cover;">
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
				$iImage = '<div class="col-md-4 '.($i%2==0?'mb-4':'').'"><a class="d-block w-100 h-100 rounded shadow" href="./baiviet.php?id='.$dichvuchinhPosts[$i]["id"].'" style="background-image:url('.$dichvuchinhPosts[$i]["image"].'); background-size: cover;"></a></div>';
				$iContent = '<div class="col-md-8"><h5><a class="text-dark text-decoration-none" href="./baiviet.php?id='.$dichvuchinhPosts[$i]["id"].'">'.preg_replace("/DỊCH VỤ CHÍNH - /", "", $dichvuchinhPosts[$i]["name"]).'</a></h5><p class="d-block w-100">'.$dichvuchinhPosts[$i]["descr"].'</p></div>';
				?>
				<div class="col-md-12 iTin mt-4" <?php echo ($i<sizeof($dichvuchinhPosts)-1?'style="border-bottom: 1px dashed black"':'') ?>>
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
<!-- Youtube Videos -->
<section id="youtubeVideos" class="data-section shadow-lg bg-secondary text-light rounded">
    <h2><a>Video</a></h2>
    <div id="youtubeVideos-content" class="row"></div>
</section>
<script src="./js/youtube.js"></script>
<script>
	// Sản phẩm
	function appendSanPham() {
		for(var i=0; i<sanpham.length; i++) {
			document.getElementById("sanpham-content").innerHTML += `
				<div class="col-md-4 iGrid p-2">
					<a class="d-block w-100 h-100 rounded shadow" href="`+sanpham[i].link+`" style="background-image:url(./img/sanpham/`+sanpham[i].image+`); background-size: cover;">
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
                            <iframe class="d-block w-100 rounded" `+youtubeVideos[i].link.match(/src=".+?"/i)+` frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>`;
            var iContent = `<div class="col-md-5">
                                <h5>`+youtubeVideos[i].name+`</h5>
                                <p class="d-block w-100">
                                    `+youtubeVideos[i].content+`
                                </p>
                            </div>`;
            document.getElementById("youtubeVideos-content").innerHTML += `
                <div class="col-md-12 iYoutubeVideos mt-4" `+(i<youtubeVideos.length-1?`style="border-bottom: 1px dashed white"`:``)+`>
                    <div class="row mb-4">
                        `+(i%2==0?(iImage+iContent):(iContent+iImage))+`
                    </div>
                </div>
            `;
        }
    }
    appendYoutubeVideos();
</script>
<?php contentBottom(); ?>