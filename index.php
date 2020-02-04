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
                <iframe id="iframe-content" src="https://albumizr.com/a/9k88" scrolling="no" frameborder="0" allowfullscreen width="100%" height="0"></iframe>
            </section>
            </center>

            <!-- Sản phẩm -->
            <section id="sanpham" class="data-section">
                <h2><a href="#sanpham">Sản phẩm</a></h2>
                <div id="sanpham-content" class="row"></div>
            </section>

            <!-- Đào tạo -->
            <section id="daotao" class="data-section">
                <h2><a href="#daotao">Đào tạo</a></h2>
                <div id="daotao-content" class="row"></div>
            </section>

            <!-- Dịch vụ chính -->
            <section id="dichvuchinh" class="data-section">
                <h2><a href="#dichvuchinh">Dịch vụ chính</a></h2>
                <div id="dichvuchinh-content" class="row"></div>
            </section>
			<?php foot(); ?>
			<script>
				// Sản phẩm
				function appendSanPham() {
					for(var i=0; i<sanpham.length; i++) {
						document.getElementById("sanpham-content").innerHTML += `
							<div class="col-sm-4 iSanPham p-2">
								<a class="d-block w-100 h-100" href="#"  style="background-image:url(./img/sanpham/`+sanpham[i].image+`); background-size: cover;">
									<div class="trungtam">`+sanpham[i].name+`</div>
								</a>
							</div> 
						`;
					}
				}
				appendSanPham();

				// Đào tạo
				function appendDaoTao() {
					for(var i=0; i<daotao.length; i++) {
						document.getElementById("daotao-content").innerHTML += `
							<div class="col-sm-4 iDaoTao p-2">
								<a class="d-block w-100 h-100" href="#"  style="background-image:url(./img/daotao/`+daotao[i].image+`); background-size: cover;">
									<div class="trungtam">`+daotao[i].name+`</div>
								</a>
							</div> 
						`;
					}
				}
				appendDaoTao();

				// Dịch vụ chính
				function appendDichVuChinh() {
					for(var i=0; i<dichvuchinh.length; i++) {
						var iImage = `<div class="col-md-4 `+(i%2==0?`mb-4`:``)+`">
										<a class="iDichVuChinh-image d-block w-100 h-100" href="#" style="background-image:url(./img/dichvuchinh/`+dichvuchinh[i].image+`); background-size: cover;"></a>
									</div>`;
						var iContent = `<div class="col-md-8">
											<h5>`+dichvuchinh[i].name+`</h5>
											<p class="d-block w-100">
												`+dichvuchinh[i].content+`
											</p>
										</div>`;
						document.getElementById("dichvuchinh-content").innerHTML += `
							<div class="col-sm-12 iDichVuChinh mt-4" `+(i<dichvuchinh.length-1?`style="border-bottom: 1px dashed black"`:``)+`>
								<div class="row mb-4">
									`+(i%2==0?(iImage+iContent):(iContent+iImage))+`
								</div>
							</div>
						`;
					}
				}
				appendDichVuChinh();

				var iframeContent = document.getElementById("iframe-content");
				var mapContent = document.getElementById("map-content");
				var iSanPham = document.querySelectorAll("#sanpham-content .iSanPham");
				var iDaoTao = document.querySelectorAll("#daotao-content .iDaoTao");
				var iDichVuChinh = document.querySelectorAll("#dichvuchinh-content .col-md-4");
				// Window onresize event
				window.addEventListener("resize", responsiveWidth);
				// Set height to responsive elements
				function responsiveWidth() {
					mapContent.height = mapContent.offsetWidth;
					iframeContent.height = iframeContent.offsetWidth*0.25;
					for(var i=0; i<iSanPham.length; i++)
						iSanPham[i].style.cssText += "; height: "+iSanPham[i].offsetWidth*0.5+"px;";
					for(var i=0; i<iDaoTao.length; i++)
						iDaoTao[i].style.cssText += "; height: "+iDaoTao[i].offsetWidth*0.5+"px;";
					for(var i=0; i<iDichVuChinh.length; i++)
						iDichVuChinh[i].style.cssText += "; height: "+iDichVuChinh[i].offsetWidth*0.5+"px;";
				}
				responsiveWidth();

				// Custom CSS
				var iTrungTam = document.getElementsByClassName("trungtam");
				for(var i=0; i<iTrungTam.length; i++) {
					iTrungTam[i].style.top = (iTrungTam[i].parentElement.offsetHeight-iTrungTam[i].offsetHeight)*0.5;
				}
			</script>
		</div>
	</body>
</html>
