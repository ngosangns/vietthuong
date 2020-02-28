<?php
    require("./lib.php");
?>
<?php contentTop("Quản lí bài viết"); ?>
<h3>QUẢN LÍ SẢN PHẨM<small><a class='text-muted ml-2 text-decoration-none' style='font-size: 14px' href='./upload-sanpham.php'>Thêm sản phẩm</a></small></h3>
<table class="table">
    <tbody>
        <?php
        $data_product = lay_san_pham();
        if(sizeof($data_product)>0) {
            for($i=0; $i<sizeof($data_product); $i++) {
                ?>
                    <tr>
                        <td><a href="./product.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></td>
                        <td class="text-right"><a class="btn btn-success text-white" href="./edit-sanpham.php?id=<?php echo $data_product[$i]['id']; ?>">Sửa</a> <button class="btn btn-danger" type="button" onclick="confirmDelete(this)" href="./delete.php?productid=<?php echo $data_product[$i]['id']; ?>">Xóa</button></td>
                    <tr>
            </div>
                <!--end_product-->
                <?php
            }
        }
        else {
            ?>
            <td colspan=2>TẠM THỜI CHƯA CÓ SẢN PHẨM</td>
            <?php
        }
        ?>
    </tbody>
</table>
<?php contentBottom(false); ?>