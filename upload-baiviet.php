<?php
    require("lib.php");
    checkDangNhap();
    if(isset($_POST['submit'])) addContent("post", "add");
?>
<!DOCTYPE html>
<html>
<?php contentTop("Upload bài viết"); ?>
<link rel="stylesheet" href="/lib/sceditor-2.1.3/minified/themes/default.min.css" id="theme-style" />
<script src="/lib/sceditor-2.1.3/minified/sceditor.min.js"></script>
<script src="/lib/sceditor-2.1.3/minified/icons/monocons.js"></script>
<script src="/lib/sceditor-2.1.3/minified/formats/bbcode.js"></script>
<div class="row container mx-auto">
    <div class="col-md-12">
        <h2>UPLOAD BÀI VIẾT</h2><br/>
        <form method="POST" action="" role="form" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-form-label col-md-3">Tiêu đề*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="category" class="col-form-label col-md-3">Chuyên mục*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="category">
                </div>
            </div>
            <div class="form-group row">
                <label for="descr" class="col-form-label col-md-3">Giới thiệu ngắn</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="descr">
                </div>
            </div>
            <div class="form-group row">
                <label for="comment" class="col-form-label col-md-3">Nội dung</label>
                <div class="col-md-9">
                    <textarea rows=10 type="text" class="form-control" name="comment"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-form-label col-md-3">Hình ảnh</label>
                <div class="col-md-9">
                    <input type="file" class="form-control-file" name="image">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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