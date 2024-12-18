<script type="text/javascript" language="javascript" class="init">
    $(function () {
        
        $('#Bank').dataTable({ pageLength: <?= count($queBank['data']) ?> });

    });
</script>

<style>
    i.fa {
    line-height: 40px;
    
}
.fa-trash-alt:before, .fa-trash-can:before {
    content: "\f2ed";
    color: #1f1c1c !important;
}

</style>
<?
$query1 = $this->db->query("SELECT jobTitleID , emp_supervisor  FROM employee	WHERE Contact_ID = '" . $this->session->userdata('id') . "' ");
$query = $query1->row_array();
$GroupID = $this->session->userdata('GroupID');
?>
<div class="block-st">
    <?php
    // print_r($get_employee);die;
    if (!empty($queBank['data'])) { ?>

        <div class="clearfix"></div>
        <div class="panel panel-danger">
            <div class="panel-body no-padding">

                <table id="Bank" class="table table-striped table-bordered">
                    <thead>
                        <h3 class="text-white p-3 rounded">
                            <?= lang('question_bank'); ?>
                        </h3>
                        <tr>
                            <th>
                                <?php echo lang('br_n') ?>
                            </th>
                            <th>
                                <?php echo lang('question_bank_name') ?>
                            </th>
                            <th>
                                <?php echo lang('am_row') ?>
                            </th>
                            <th>
                                <?php echo lang('am_subject') ?>
                            </th>
                            <th>
                                <?php echo lang('br_Branche') ?>
                            </th>
                            <th>
                                <?php echo lang('br_year') ?>
                            </th>
                            
                            <th>
                                <?php echo lang('status') ?>
                            </th>
                            <th>
                                <?php echo lang('am_view') ?>
                            </th>
                            <?php if ($this->session->userdata('type') == "U" or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')) {
                                echo '<th>' . lang('am_edit') . '</th>';
                            } ?>
                            <th>
                                <?php echo lang('add_questions') ?>
                            </th>
                            <?php if ($this->session->userdata('type') == "U" or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')) {
                                echo '<th>' . lang('br_delete') . '</th>';
                            } ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($queBank['data'] as $Key => $quba) {
                            $KeyVal       = $Key + 1;
                            $ID           = $quba['id'];
                            $RowLevelID   = $quba['gradedata']['id'];
                            $level_id     = $quba['gradedata']['level_id'];
                            $subject_ID   = $quba['subject'];
                            $school_id    = $quba['school_id'];
                            $SemesterID   = $quba['semesterdata']['id'];
                            $yearID       = $quba['yere']['id'];
                            $yearName     = $quba['yere']['Year_name'];
                            $status       = $quba['status'];
                            if ($Lang == "arabic") {

                                $bankName = $quba['name_ar'];
                                $subjectName = $quba['subjectdata']['Name'];
                                $RowLevelName = $quba['gradedata']['Row_Name_en'] . "-" . $quba['gradedata']['Level_Name'];
                                $schoolName = $quba['school']['SchoolName'];
                                $semesterName = $quba['semesterdata']['Name'];
                            } else {

                                $bankName = $quba['name_en'];
                                $subjectName = $quba['subjectdata']['Name_en'];
                                $RowLevelName = $quba['gradedata']['Row_Name_en'] . "-" . $quba['gradedata']['Level_Name'];
                                $schoolName = $quba['school']['SchoolName'];
                                $semesterName = $quba['semesterdata']['Name_en'];
                            }
                            ?>
                            <tr id="bank-<?= $ID ?>">
                                <td>
                                    <?php echo $KeyVal; ?>
                                </td>
                                <td>
                                    <?php echo $bankName; ?>
                                </td>
                                <td>
                                    <?php echo $RowLevelName; ?>
                                </td>
                                <td>
                                    <?php echo $subjectName; ?>
                                </td>
                                <td>
                                    <?php echo $schoolName; ?>
                                </td>
                                <td>
                                    <?php echo $yearName; ?>
                                </td>
                              
                                <td>
                                    <?php if ($status == '1') {
                                        echo lang('br_active');
                                    } else {
                                        echo lang('br_not_active');
                                    } ?>
                                </td>

                                <td>
                                        <button class="btn blue-bg rounded open-modal" data-id="<? echo $ID ?>" id="open-modal"
                                            role="button" aria-pressed="false" data-modal="question-bank">
                                            <?=lang('view_banks_question'); ?> </button>
                                    
                                </td>

                                <?php if ($this->session->userdata('type') == U or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')) { ?>
                                    <td>


                                        <a href="<?php echo site_url('admin/question_bank/question_form/' . $ID . "/" . $year_id . "/" . $Semesterid . "/" . $level_id . "/" . $gradeID . "/" . $subjectID); ?>"
                                            class="btn pink-bg rounded">

                                            <i class="fa fa-edit "></i>

                                        </a>

                                    </td>
                                <? } ?>
                                <td>
                                <? if ($quba['users'][0]['add'] == 1 or $this->session->userdata('type') == "U" or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')) { ?>

                                        <a href="<?php echo site_url('emp/exam_new/bank_question?bankId=' . $ID); ?>"
                                            target="_blank" class="addBtn btn green-bg rounded">

                                            <i class="fa fa-plus "></i>

                                        </a>
                                    <? } else {
                                        echo '<div class="text-center">
                                                <i class="fas fa-ban fa-1x" style="color: red;"></i>
                                                <p class="mt-2">Unauthorized</p>
                                            </div>';
                                    } ?>
                                </td>
                                <?php if ($this->session->userdata('type') == U or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')) { ?>

                                    <td>
                                        <!-- <a href="#" class="btn red-bg rounded delete-button"
                                            onclick="return delete_data(<?php echo $ID; ?>);">
                                            <i class="fa fa-trash-o"></i>
                                        </a> -->
                                        <button class="btn btn-danger delete-btn" style="color:black" data-id="<?php echo $ID; ?>"><i class="fas fa-trash-alt close-btn"></i><?=lang('delete_bank'); ?></button>
                                        <!-- <button class="btn red-bg rounded delete-button"
                                            onclick=" delete_data();">
                                            <i class="fa fa-trash-o"></i>
                                        </button> -->
                                    </td>
                                <? } ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>


        </div>

        <?php
    } elseif ($year_id == "" && ($this->session->userdata('type') == 'U' || $GroupID != 0)) {

    } else {
        echo '<div class="alert alert-error">' . lang('br_check_add') . '</div>';
    }
    ?>
    <div class="clearfix"></div>
</div>

<script>

    $(document).ready(function () {
        $(".delete-btn").click(function () {
            var bankId = $(this).data("id");

            Swal.fire({
                title: '<?=lang('AreYouSure');?>',
                text: "<?=lang('AlertUCantBack'); ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: "<?=lang('YesDelete');?>",
                cancelButtonText: "<?=lang('cancel');?>",
                reverseButtons: true, // هنا تقوم بتفعيل الخاصية

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/question_bank/delete_question_bank/' + bankId,
                        type: "POST",
                        cache: false,
                        data: {
                            apikey: "chat.<?=$_SERVER['SERVER_NAME'];?>",
                            id: bankId,
                        },
                        success: function (response) {
                            var parsedResponse = JSON.parse(response);
                            if (parsedResponse.delete) {
                                $('#bank-' + bankId).remove();
                                Swal.fire('تم!', parsedResponse.message, 'success');
                            } else {
                                Swal.fire('خطأ!', parsedResponse.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('خطأ!', 'حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.', 'error');
                        }
                    });
                }
            });
        });
    });

    // function delete_data(bankId) {

    //     Swal.fire({
    //         title: 'هل أنت متأكد؟',
    //         text: "لن يمكنك التراجع عن هذا الإجراء!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         cancelButtonColor: '#3085d6',
    //         confirmButtonText: 'نعم، احذفه!',
    //         cancelButtonText: 'إلغاء'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: 'https://chat.lms.esol.com.sa/apikey/bank/destroy?apikey=chat.lmsdevelopment.esol.com.sa',  // تأكد من تحديد الرابط الصحيح هنا
    //                 type: "POST",
    //                 data: {
    //                     id: bankId,
    //                     _token: '{{ csrf_token() }}' // لضمان الأمان في Laravel
    //                 },
    //                 success: function (response) {
    //                     if (response.status) {
    //                         Swal.fire('تم!', response.message, 'success');
    //                     } else {
    //                         Swal.fire('خطأ!', response.error, 'error');
    //                     }
    //                 },
    //                 error: function (xhr) {
    //                     Swal.fire('خطأ!', 'حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.', 'error');
    //                 }
    //             });
    //         }
    //     });

    // }
</script>