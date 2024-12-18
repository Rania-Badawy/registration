<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st" style=" height: 330px;">

            <div class="sec-title">

                <h2><?php echo lang('add_question_bank'); ?> <?php echo lang('general'); ?> <?php echo $Year; ?> /
                    <?php echo $curSemName; ?></h2>

            </div>



            <?php

            if ($this->session->flashdata('Sucsess')) {

            ?>

            <div class="widget-content">

                <div class="widget-box">

                    <div class="alert alert-success fade in">

                        <button data-dismiss="alert" class="close" type="button">×</button>

                        <?php

                            echo $this->session->flashdata('Sucsess');

                            ?>

                    </div>

                </div>

            </div>

            <?php

            }



            if ($this->session->flashdata('Failuer')) {

            ?>

            <div class="widget-content">

                <div class="widget-box">

                    <div class="alert alert-danger fade in">

                        <button data-dismiss="alert" class="close" type="button">×</button>

                        <?php

                            echo $this->session->flashdata('Failuer');

                            ?>

                    </div>

                </div>

            </div>

            <?php

            }

            ?>



            <!----- Add title -------->

            <?php if ($qbID) { ?>

            <form action="<?php echo site_url('admin/question_bank/add_question_form') ?>" method="post">
            <input type="hidden" name="bank_id" id="bank_id" value="<?php echo $qbID; ?>" />

                <?php }else{ ?>

                <form action="<?php echo site_url('admin/question_bank/question_form') ?>" method="post">
                    <?php }?>

                    <input type="hidden" name="apikey" id="apikey" value="<?php echo $apikey; ?>" />
                    <input type="hidden" name="curr_school" id="curr_school" value="<?php echo $curr_school; ?>" />
                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3 "><?php echo lang('am_name'); ?></label>

                        <div class="col-lg-9">


                            <input type="text" id="name_ar" name="name_ar" class="form-control"  required
                                value="<?php echo $name_ar;?>" <?php if ($gra && $qbID =="") { ?> readonly <?php } ?> />

                        </div>

                    </div>
                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3 "><?php echo lang('name_eng'); ?></label>

                        <div class="col-lg-9">


                            <input type="text" id="name_en" name="name_en" class="form-control"  required
                                value="<?php echo $name_en; ?>" <?php if ($gra && $qbID =="") { ?> readonly
                                <?php } ?> />

                        </div>

                    </div>
                    <!-- <div class="form-group col-lg-5">
                    <label class="control-label col-lg-3"><?php echo lang('br_Branches'); ?></label>
                    <div class="col-lg-9">
                        <select class="form-control selectpicker" data-placeholder="<?php echo lang('br_Branches'); ?>" name="SchoolID[]" id="SchoolID" data-live-search="true" multiple="" tabindex="18" onchange="return get_emp();">

                            <option value="0"><?php echo lang('am_select'); ?></option>
                            <?php
                            if (!empty($schools)) {

                                $SchoolID = explode(',', $SchoolID);
                            }
                            if (is_array($schools)) {

                                foreach ($schools as $Key => $School) {

                            ?>

                                    <option value="<?= $School->ID  ?>" <?php if (in_array($School->ID, $SchoolID)) {
                                                                            echo 'selected';
                                                                        } ?>><?= $School->Name ?></option>

                            <?php

                                }
                            }

                            ?>

                        </select>

                    </div>

                </div> -->
                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3"><?php echo lang('am_row'); ?></label>

                        <div class="col-lg-9">

                            <select data-placeholder="<?php echo lang('am_row'); ?>" class=" form-control"
                                data-live-search="true" tabindex="18" name="gradeID" id="gradeID" required   <? if ($qbID) { echo 'disabled';}?>
                                <?php if ($gra && $qbID =="") { ?> disabled <?php } ?>>

                                <option value=""><?php echo lang('am_select'); ?></option>
                                <?php

                            foreach ($grades['data'] as $Key => $lev) {

                                $levelID       = $lev['level_id'];
                                $rowLevelID    = $lev['id'];

                                if ($Lang == "arabic") {

                                    $levelName    = $lev['level']['name_ar'];
                                    $gradeName    = $lev['name_ar'];
                                } else {

                                    $levelName    = $lev['level']['name_en'];
                                    $gradeName    = $lev['name_en'];
                                }
                                if (in_array($rowLevelID, $rowLevelPer))
                                {
                            ?>

                                <option value="<?php echo $rowLevelID; ?>" <?php if ($gra == $rowLevelID) {
                                                                            echo 'selected';
                                                                        } ?>>
                                    <?php echo $levelName . "-" . $gradeName; ?></option>

                                <?php

                            }}

                            ?>

                            </select>

                        </div>


                    </div>

                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3"><?php echo lang('am_subject'); ?></label>

                        <div class="col-lg-9">

                            <select data-placeholder="<?php echo lang('am_subject'); ?>" class="form-control"
                                data-live-search="true" tabindex="18" name="subjectID" id="subjectID" required <? if ($qbID) { echo 'disabled';}?>
                                <?php if ($gra && $qbID =="") { ?> disabled <?php } ?>>

                                <option value=""><?php echo lang('am_select'); ?></option>

                                <?php

                            foreach ($getSubject['data'] as $Key => $lev) {

                                $subjectID          = $lev['SubjectID'];

                                if ($Lang == "arabic") {

                                    $subjectName    = $lev['Name'];
                                } else {

                                    $subjectName    = $lev['Name_en'];
                                }
                                if (in_array($subjectID, $subjectPer)){

                            ?>
                                <option value="<?php echo $subjectID; ?>" <?php if ($subjectID == $subj) {
                                                                                echo 'selected';
                                                                            } ?>> <?php echo $subjectName; ?></option>

                                <?php

                            }}

                            ?>

                            </select>

                        </div>


                    </div>

                    <div class="clearfix"></div>

                    <!-- <div class="form-group col-lg-5">
                        <label class="control-label col-lg-3"><?php echo lang('Adoption_of_questions'); ?></label>
                        <div class="checkbox checkbox-success col-lg-9">
                            <input type="checkbox" name="Adoption_of_questions" id="Adoption_of_questions" value="1"
                                <?php if ($need_to_accredited == 1) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> <?php if ($gra && $qbID =="") { ?> onclick="return false" <?php } ?>>
                        </div>
                    </div> -->

                    <div class="form-group col-lg-5">
                        <label class="control-label col-lg-3"><?php echo lang('br_active'); ?></label>
                        <div class="checkbox checkbox-success col-lg-9">
                            <input type="checkbox" name="IsActive" value="1"  <?php if ($status == 1) {
                                                                                            echo 'checked';
                                                                                        }
                                                                                        ?>>
                        </div>
                    </div>

                    <?php if($qbID){?>

                    <div class="form-group col-lg-5">
                        <label class="control-label col-lg-3"><?php echo lang('br_permission'); ?></label>
                        <div class="checkbox checkbox-success col-lg-9">
                            <input type="checkbox" name="showEmp" id="showEmp" value="1" onChange="show_Emp();">
                        </div>
                    </div>

                    <?php } ?>

                    <?php if ($qbID) { ?>
                    <div class="form-group col-lg-2">
                        <input type="submit" class="btn btn-success" id="saveQB"
                            value="<?php echo lang('br_save'); ?>" />
                    </div>

                    <?php }elseif($gra == ""){ ?>
                    <div class="form-group col-lg-2">
                        <input type="submit" class="btn btn-success" id="saveQB"
                            value="<?php echo lang('br_save'); ?>" />
                    </div>


                    <?php }else{} ?>

        </div>
        <?php if (!$qbID) { ?>
        
        </form>
        <?php } ?>
        <?php if ($gra) { ?>
        <?php if (!$qbID) { ?>
        <form action="<?php echo site_url('admin/question_bank/add_question_form') ?>" method="post">
        
            <input type="hidden" name="name_ar" id="name_ar" value="<?php echo $name_ar; ?>" />
            <input type="hidden" name="name_en" id="name_en" value="<?php echo $name_en; ?>" />
            <input type="hidden" name="IsActive" id="IsActive" value="<?php echo $status; ?>" />
            <?php } ?>
            <input type="hidden" name="level" id="level" value="<?php echo $level; ?>" />
            <input type="hidden" name="gradeID" id="gradeID" value="<?php echo $gra; ?>" />
            <input type="hidden" name="subjectID" id="subjectID" value="<?php echo $subj; ?>" />
            <input type="hidden" name="bank_id" id="bank_id" value="<?php echo $qbID; ?>" />

            <div class="block-st" id="empTable">
                <div class="panel panel-danger">
                    <div class="panel-body no-padding">

                        <table class="table table-striped table-bordered" id="result_data">

                            <thead>

                            </thead>

                            <tbody>

                                <tr class="purble-bg">
                                    <th>#</th>

                                    <th><?php echo lang('emp'); ?></th>

                                    <!-- <th><?php echo lang('am_supervisor'); ?> -->

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
                                    // var_dump($empID);die;
                                    // print_r($bankUsers[$empID]['supervisor']);die;
                                ?>

                                <tr>

                                    <td align="center">
                                        <?php echo $Num; ?>
                                        <input type="hidden" name="empID_<?= $Key ?>" id="empID"
                                            value="<?php echo $empID; ?>" />
                                    </td>

                                    <td align="center"><?php echo $empName; ?></td>

                                    <!-- <td align="center">
                                        <input type="checkbox" name="supervisor_<?= $Key ?>" id="supervisor" value="1"
                                            <?php  if(isset($bankUsers[$empID]) && $bankUsers[$empID]['supervisor']==1) {echo "checked";} ?>>
                                    </td> -->

                                    <td align="center">
                                        <input type="checkbox" name="add_<?= $Key ?>" id="add_<?= $Key ?>" value="1" onChange="check_use('<?= $Key ?>');"
                                            <?php  if(isset($bankUsers[$empID]) && $bankUsers[$empID]['add']==1) {echo "checked";} ?>>
                                    </td>
                                    <td align="center">
                                        <input type="checkbox" name="use_<?= $Key ?>" id="use_<?= $Key ?>" value="1"
                                            <?php  if(isset($bankUsers[$empID]) && $bankUsers[$empID]['use']==1) {echo "checked";} ?>>
                                    </td>

                                    <td align="center">
                                        <input type="checkbox" name="delete_<?= $Key ?>" id="delete_<?= $Key ?>" value="1"
                                            <?php  if(isset($bankUsers[$empID]) && $bankUsers[$empID]['delete']==1) {echo "checked";} ?>>
                                    </td>

                                </tr>
                                <?php

                                }

                                ?>

                                <input type="hidden" name="KeyCount" id="KeyCount" value="<?php echo $Key; ?>" />


                            </tbody>

                        </table>

                    </div>
                </div>

                <?php } ?>

                <div class="clearfix"></div>

                <?php if ($getEmp) { ?>

                <div class="form-group col-lg-2">
                    <input type="submit" class="btn btn-success" id="saveEmp" value="<?php echo lang('br_save'); ?>" />
                </div>

                <?php } ?>

        </form>

        <div class="clearfix"></div>



        <div class="clearfix"></div>



    </div>

</div>

</div>

<script>
    $(document).ready(function () {
        var  KeyCount = $("#KeyCount").val() ;

        for (let index = 0; index <= KeyCount; index++) {

            if (document.getElementById('add_'+index).checked == false) {

                document.getElementById('delete_'+index).disabled = true;

            }
        }

    });
 function check_use(count)

 {

	if(document.getElementById('add_'+count).checked)

        {
            document.getElementById('delete_'+count).disabled = false ;

        }else{

            document.getElementById('delete_'+count).checked = false;
			document.getElementById('delete_'+count).disabled = true;
            

        }; 

 }
 </script>

<script>
  const subjectper = <?= json_encode($subjectPer) ?>;

$('select[name^="gradeID"]').on('change', function() {
    var apikey = $('#apikey').val();
    var SchoolID = $('#curr_school').val();
    var gradeID = $('#gradeID').val();
    var levelGrade = gradeID.split('|');
    var level = levelGrade[0];
    var grade = levelGrade[1];

    if (apikey) {
        $.ajax({
    url: '<?php echo site_url(); ?>/admin/question_bank/getSubjects/' + SchoolID + "/" + level + "/" + grade,
    type: "GET",
    dataType: "json",
    success: function(data) {
        console.log(data);
        if (data && data['data'] && data['data'].length > 0) {
            var element = $('#subjectID');
            element.empty();
            element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
            console.log(data['data']);
                $.each(data['data'], function(key, value) {
                var subjectIDAsString = value.SubjectID.toString();
                if ($.inArray(subjectIDAsString, subjectper) !== -1) {
                    element.append('<option value="' + value.SubjectID + '">' + value.Name + '</option>');
            }
            });
            $('.selectpicker').selectpicker('refresh');
        } else {
            // Display a SweetAlert if no data is returned.
            Swal.fire({
                icon: 'info',
                title: 'No Data Attached',
                text: 'There is no data attached to this request.',
            });
        }
    }
});


    }
});
////////////////////////////////////////////////////////
function get_emp() {
    const SchoolID = $("#SchoolID").val();
    const row_level_id = $("#row_level_id").val();
    const Subjectid = $("#subjectID").val();

    if (SchoolID != 0) {


        $.ajax({

            type: "POST",

            url: "<?php echo site_url('admin/question_bank/get_add_question_bank_emp/' . $SchoolID) ?>",

            data: {
                SchoolID: SchoolID,
                row_level_id: row_level_id,
                Subjectid: Subjectid
            },

            cache: false,

            success: function(html) {
                // debugger;
                $("#result_table").show("slow");
                $("#result_data").html(html);

                ///success end 

            }
        }); /////END AJAX


    }
}
</script>
<script>
<?php if($qbID){ ?>


    $('#empTable').hide();
    // $('#saveEmp').hide();



<?php  } ?>

function show_Emp()

{

    if (document.getElementById('showEmp').checked)

    {

        $("#empTable").show("slow");
        // $("#saveEmp").show("slow");
        $('#saveQB').hide();



    } else {

        $('#empTable').hide();
        // $('#saveEmp').hide();
        $("#saveQB").show("slow");

    };

}
</script>