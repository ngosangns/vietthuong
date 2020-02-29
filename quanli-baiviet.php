<?php
    require("./lib.php");
?>
<?php contentTop("Quản lí bài viết"); ?>
<h3>QUẢN LÍ BÀI VIẾT<small><a class='text-muted ml-2 text-decoration-none' style='font-size: 14px' href='./upload-baiviet.php'>Thêm bài viết</a></small></h3>
<table class="table">
    <tbody>
        <?php
        $data_product = lay_bai_viet("","",false,false);
        if(sizeof($data_product)>0) {
            for($i=0; $i<sizeof($data_product); $i++) {
                ?>
                <tr>
                    <td><a href="./baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><?php echo $data_product[$i]['name']; ?></a></td>
                    <td class="text-right"><a class="btn btn-success text-white mt-1 mb-1" href="./edit-baiviet.php?id=<?php echo $data_product[$i]['id']; ?>"><i class="fa fa-edit"></i></a> <button class="btn btn-danger mt-1 mb-1" type="button" onclick="confirmDelete(this)" href="./delete.php?postid=<?php echo $data_product[$i]['id']; ?>"><i class="fa fa-trash"></i></button></td>
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
<?php contentBottom(false); ?>