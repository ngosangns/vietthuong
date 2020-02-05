<?php
    require("./lib.php");
?>
<?php contentTop("Quản lí bài viết"); ?>
<div class="row container mx-auto mt-5">
    <h3>QUẢN LÍ BÀI VIẾT</h3>
    <table class="table col-md-12">
        <tbody>
            <?php
            $data_product = lay_bai_viet();
            if(sizeof($data_product)>0) {
                for($i=0; $i<sizeof($data_product); $i++) {
                    ?>
                    <tr>
                        <td><a href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></td>
                        <td class="text-right"><a class="btn btn-success text-white" href="./edit-baiviet.php?id=<?php echo $data_product[$i]['id']; ?>">Sửa</a> <a class="btn btn-danger text-white" href="./delete.php?postid=<?php echo $data_product[$i]['id']; ?>">Xóa</a></td>
                    </tr>
                </div>
                    <!--end_product-->
                    <?php
                }
            }
            else {
                ?>
                <td colspan=2>TẠM THỜI CHƯA CÓ BÀI VIẾT</td>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php contentBottom(false); ?>