<?php
    require("lib.php");
    checkDangNhap();
    if(isset($_POST['submit'])) addContent("product", "add");
?>
<?php contentTop("Upload sản phẩm"); ?>
<?php
    if(isset($_GET['id'])) {
        $san_pham = lay_san_pham("id", $_GET['id']);
    }
?>
<link rel="stylesheet" href="/lib/sceditor-2.1.3/minified/themes/default.min.css" id="theme-style" />
<script src="/lib/sceditor-2.1.3/minified/sceditor.min.js"></script>
<script src="/lib/sceditor-2.1.3/minified/icons/monocons.js"></script>
<script src="/lib/sceditor-2.1.3/minified/formats/bbcode.js"></script>
<div class="row container mx-auto">
    <div class="col-md-12">
        <h2>UPLOAD SẢN PHẨM</h2><br/>
        <form method="POST" action="" role="form" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-form-label col-md-3">Tên sản phẩm*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-form-label col-md-3">Giá sản phẩm</label>
                <div class="col-md-9">
                    <input type="number" class="form-control" name="price">
                </div>
            </div>
            <div class="form-group row">
                <label for="category" class="col-form-label col-md-3">Loại sản phẩm*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="category">
                </div>
            </div>
            <div class="form-group row">
                <label for="code" class="col-form-label col-md-3">Mã sản phẩm*</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="code">
                </div>
            </div>
            <div class="form-group row">
                <label for="comment" class="col-form-label col-md-3">Mô tả sản phẩm</label>
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