<?php
    require("lib.php");
    checkDangNhap();
    if(isset($_POST['submit'])) addContent("post", "edit");
?>
<?php contentTop("Sửa bài viết"); ?>
<?php
    if(isset($_GET['id'])) {
        $san_pham = lay_bai_viet("id", $_GET['id']);
        if(sizeof($san_pham)==0) {
            die_custom("Bài viết sai", "./quanli-baiviet.php");
        }
    }
    else {
        die_custom("Không có bài viết", "./quanli-baiviet.php");
    }
?>
<link rel="stylesheet" href="/lib/sceditor-2.1.3/minified/themes/default.min.css" id="theme-style" />
<script src="/lib/sceditor-2.1.3/minified/sceditor.min.js"></script>
<script src="/lib/sceditor-2.1.3/minified/icons/monocons.js"></script>
<script src="/lib/sceditor-2.1.3/minified/formats/bbcode.js"></script>
<div class="row container mx-auto">
    <div class="col-md-12">
        <h2>SỬA SẢN PHẨM</h2><br/>
        <form method="POST" action="" role="form" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-form-label col-md-3">Tiêu đề*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" value="<?php echo $san_pham[0]['name']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="category" class="col-form-label col-md-3">Chuyên mục*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="category" value="<?php echo $san_pham[0]['category']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="descr" class="col-form-label col-md-3">Giới thiệu ngắn</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="descr" value="<?php echo $san_pham[0]['descr']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="comment" class="col-form-label col-md-3">Nội dung</label>
                <div class="col-md-9">
                    <textarea rows=10 type="text" class="form-control" name="comment"><?php echo $san_pham[0]['comment']; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="dangdienra" class="col-form-label col-md-3">Sự kiện đang diễn ra</label>
                <div class="col-md-9">
                    <input type="checkbox" class="form-control" value="1" name="dangdienra" <?php if((int)$san_pham[0]['dangdienra']) echo "checked"; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="displaytt" class="col-form-label col-md-3">Hiện trên trang tin tức</label>
                <div class="col-md-9">
                    <input type="checkbox" class="form-control" value="1" name="displaytt" <?php if((int)$san_pham[0]['displaytt']) echo "checked"; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-form-label col-md-3">Hình ảnh</label>
                <div class="col-md-9">
                    <input type="file" class="form-control-file" name="image">
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button class="btn btn-danger" type="button" onclick="confirmDelete(this)" href="./delete.php?postid=<?php echo $_GET['id']; ?>">Xóa</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    var textarea = document.getElementsByName('comment')[0];
    sceditor.create(textarea, {
        format: 'xhtml',
        icons: 'monocons',
        style: '/lib/sceditor-2.1.3/minified/themes/content/default.min.css',
        height: "500px",
        width: "100%",
        autofocus: "true",
        autoUpdate: "true",
        emoticonsCompat: "true",
        emoticonsRoot: "/lib/sceditor-2.1.3/"
    });
</script>
<?php contentBottom(false); ?>