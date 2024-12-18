<input type="hidden" name="exam_result_id" value="<?= $get_degree_type['id']; ?>" />

<tr class="purble-bg">
    <th>#</th>

    <th><?php echo lang('emp'); ?></th>

    <th><?php echo lang('br_page_add'); ?></th>

    <th><?php echo lang('use'); ?></th>

    <th><?php echo lang('br_delete'); ?></th>

</tr>

<?php


foreach ($getEmp['data'] as $Key => $row) {

    $Num                = $Key + 1;

    $empID              = $row['Contact_ID'];

    if ($Lang == "arabic") {

        $empName            = $row['user']['Name'];
    } else {

        $empName            = $row['user']['Name_en'];
    }

    $student_Name_en    = $row->student_Name_en;
?>

    <tr>

        <td align="center"><?php echo $Num; ?></td>

        <td align="center"><?php echo $empName; ?></td>

        <td align="center">
            <input type="checkbox" name="IsActive" id="IsActive" value="1" <?php if ($IsActive == 1) {
                                                                                echo 'checked';
                                                                            } ?>>
        </td>
        <td align="center">
            <input type="checkbox" name="IsActive" id="IsActive" value="1" <?php if ($IsActive == 1) {
                                                                                echo 'checked';
                                                                            } ?>>
        </td>

        <td align="center">
            <input type="checkbox" name="IsActive" id="IsActive" value="1" <?php if ($IsActive == 1) {
                                                                                echo 'checked';
                                                                            } ?>>
        </td>

    </tr>
<?php

}

?>
<input type="hidden" name="KeyCount" value="<?= $Key ?>" />
<?php if ($get_student) { ?>



    <?php if ($type == 'U' || ($type == 'E' && $get_per_type['Type'] != 0)) { ?>
        <input type="submit" onclick="return showDiv();" class="btn btn-success" value="<?php echo lang('am_add'); ?>" />

        <a style="left: 150px;position: absolute;height: 33px;width: 70px;" href="<?php echo site_url("admin/exam_result/delete_student_degree_per_class/" . $exam_ID . "/" . $classid . "/" . $Subjectid . "/" . $row_level_id); ?>" class="btn btn-danger btn-rounded" onclick="return confirm('Are you sure to delete?')"> <?php echo lang('br_delete'); ?></a>

    <?php } else { ?>


        <div class="col-auto mxw-120 ms-auto" style="margin-left: auto;">


            <input type="submit" class="btn blue-bg block-lvl" value="<?php echo lang('am_add'); ?>" />

        </div>

    <?php } ?>

<?php } ?>