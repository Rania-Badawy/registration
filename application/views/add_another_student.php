<div id="append_student">
     <div class="col-md-12 p-0 studentData1">
         <?php if ($val == true) { ?>
         <hr>
         <div class="col-md-12"><button style=" width: 135px;margin-bottom: 10px;"
                 onclick="$(this).closest('.studentData1').remove();$('#num_student'+'<?=$num_student?>').remove();"
                 type="button" class="btn btn-danger deleteStudent"> <?=lang('am_delete_student')?></button></div>
         <?php }
     ?>

         <input type="hidden" name="num_student" id="num_student" value="<?=$num_student?>">
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"> <?php echo lang('am_frist_name')?><span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <input data-value="<?php echo $num_student;?>" type="text" id="stu_name<?php echo $num_student;?>"
                     name="stu_name<?php echo $num_student;?>" maxlength="50" class="form-control" required>
             </div>
         </div>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"> <?php echo lang('br_st_numberid')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <input data-value="<?php echo $num_student;?>" type="text"
                     id="student_NumberID<?php echo $num_student;?>" name="student_NumberID<?php echo $num_student;?>"
                     maxlength="14" minlength="10" onkeypress="return onlyNumberKey(event)" class="form-control"
                     required>
             </div>
         </div>

         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"> <?=lang('am_type')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="gender<?php echo $num_student;?>"
                     name="gender<?php echo $num_student;?>" class="form-control" required>
                     <option value=""><?php echo lang('am_choose_select'); ?></option>
                     <?php 
										       if ($get_genders) {
											     foreach ($get_genders as $gender) {
										    ?>
                     <option value="<?=$gender->GenderId?>"><?=$gender->GenderName?></option>
                     <?php
											  }	}
										    ?>
                 </select>
             </div>
         </div>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"> <?=lang('class_type')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="ClassTypeName<?php echo $num_student;?>"
                     name="ClassTypeName<?php echo $num_student;?>" class="form-control" required>
                     <?php 
										if ($get_ClassTypeName) {
											foreach ($get_ClassTypeName as $TypeName) {
											   
										?>
                     <option value="<?=$TypeName->ClassTypeId?>"><?=$TypeName->ClassTypeName?></option>
                     <?php
											}
										}
										?>
                 </select>
             </div>
         </div>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"><?=lang('am_studeType')?><span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="studeType<?php echo $num_student;?>"
                     name="studeType<?php echo $num_student;?>" class="form-control" required>
                     <option value=""><?php echo lang('am_choose_select'); ?></option>
                     <?php 
										if ($studeType) {
											foreach ($studeType as $stude) {
											    
										?>
                     <option value="<?=$stude->StudyTypeId?>"><?=$stude->StudyTypeName?></option>
                     <?php
											}
										}
										?>
                 </select>
             </div>
         </div>

         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"><?=lang('br_school_name')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="school<?php echo $num_student;?>"
                     name="school<?php echo $num_student;?>" class="form-control" required>
                     <option value=""><?php echo lang('am_choose_select'); ?></option>

                 </select>
             </div>
         </div>

         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"><?=lang('am_level')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" data-value="<?php echo $num_student;?>"
                     id="levelID<?php echo $num_student;?>" name="levelID<?php echo $num_student;?>"
                     class="form-control" required>
                     <option value="0"><?php echo lang('am_choose_select'); ?></option>
                 </select>
             </div>
         </div>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"> <?=lang('br_row_level')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="rowID<?php echo $num_student;?>"
                     name="rowID<?php echo $num_student;?>" class="form-control" required>
                     <option value="0"><?php echo lang('am_choose_select'); ?></option>
                 </select>
             </div>
         </div>
         <input type="hidden" name="FeeStatus" id="FeeStatus" value="">
            <div id="show_status<?= $num_student ?>">
                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('status') ?>
                        <span class="danger">*</span></label>
                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                        <select data-value="<?= $num_student ?>" id="status<?= $num_student ?>" name="status<?= $num_student ?>" value="<?= set_value('status[]'); ?>" class="form-control" required>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
         <!-- <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content" style="display:none;">-->
         <!--    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('br_class')?> <span class="danger">*</span></label>-->
         <!--    <div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
         <!--        <select  id="classID<?php echo $num_student;?>" name="classID<?php echo $num_student;?>" class="form-control" required>-->
         <!--<option value="0"><?php echo lang('am_choose_select'); ?></option>-->
         <!--        </select>-->
         <!--    </div>-->
         <!--</div>-->
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"> <?=lang('br_year')?> <span
                     class="danger">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="YearId<?php echo $num_student;?>"
                     name="YearId<?php echo $num_student;?>" class="form-control" required>
                     <option value=""><?php echo lang('am_choose_select'); ?></option>

                 </select>
             </div>
         </div>

          <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                    <?= lang('Semester') ?> <span class="danger">*</span></label>
                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                    <select data-value="<?php echo $num_student; ?>" id="semester<?php echo $num_student; ?>" name="semester<?php echo $num_student; ?>" class="form-control" required>
                        <option value=""><?php echo lang('ra_Choose_semester'); ?></option>
                        <option value="1,2,3"><?php echo lang('am_fullyear'); ?></option>
                        <option value="2,3"><?php echo lang('ra_First_second_semester'); ?></option>
                        <option value="3"><?php echo lang('Semester') . " " . lang('er_third'); ?></option>
                    </select>
                </div>
            </div>

         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label class="control-label col-md-6 col-sm-12 col-xs-12"
                 style="font-size: 11px"><?=lang('am_how_school')?> </label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <select data-value="<?php echo $num_student;?>" id="how_school<?php echo $num_student;?>"
                     name="how_school<?php echo $num_student;?>" class="form-control" required>
                     <option value="0"><?php echo lang('am_choose_select'); ?></option>
                     <?php foreach($get_how_school as $item_how_school ){ ?>
                     <option value="<?=$item_how_school->ID;?>"
                         <?php echo set_select('how_school',$item_how_school->Name, ( !empty($data) && $data == $item_how_school->Name ? TRUE : FALSE )); ?>>
                         <?=$item_how_school->Name;?></option>
                     <?php } ?>
                 </select>
             </div>
         </div>

         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
             <label
                 class="control-label col-md-6 col-sm-12 col-xs-12"><?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {
                                                                                                                echo lang('er_TeacherName');
                                                                                                            } else {
                                                                                                                echo lang('am_notes');
                                                                                                            } ?></label>
             <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                 <input data-value="<?php echo $num_student;?>" type="text" id="note<?php echo $num_student;?>"
                     name="note<?php echo $num_student;?>" class="form-control">
             </div>
         </div>

     </div>

 </div>
 <script>
function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}
$('document').ready(function() {
    $('.btn-lg').click(function() {
        $(window).scrollTop(0);
    });
});
 </script>



 <script>
function validation_speed() {
    ///////////////
    // if ($("#parent_mobile").val().length > 15) {
    //     alert('الرقم  لا يزيد عن 15 رقم');
    //     return false;
    // }

    if ($('select[name="levelID"]').val() == 0) {
        alert('اختر المرحله للطالب    ');
        return false;
    }
    return true;

}

function ValidateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.emailAddr.value)) {
        return (true)
    }
    alert("You have entered an invalid email address!")
    return (false)
}
 </script>


 <script>
var index = $('#num_student').val();
$('#studeType' + index).on('change', function() {
    document.getElementById("show_status"+ index).style.display = "none";

    var studeType = $(this).val();
    var DbName = $('#DbName').val();

    if (studeType) {
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' + DbName + '/GetSchoolsByStudyType',
            type: "GET",
            data: {
                studyTypeId: studeType
            },
            dataType: "json",
            success: function(data) {
                $('#school' + index).empty();
                $('#school' + index).append(
                    '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                $.each(data, function(key, value) {
                    $('#school' + index).append('<option value="' + value.SchoolId + '">' +
                        value.SchoolName + '</option>');
                });
            }
        });
    } else {
        $('#school' + index).empty();
        $('#school' + index).append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
    }
    $('#school' + index).trigger('change');
    $('#levelID' + index).trigger('change');
});
 </script>



 <script type="text/javascript">
var index = $('#num_student').val();
$('#school' + index).on('change', function() {

    var studeType = $('#studeType' + index).val();
    var school = $(this).val();
    var ClassTypeName = $('#ClassTypeName' + index).val();
    var DbName = $('#DbName').val();
    if (school && studeType != "") {
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetLevelsBySchool',
            type: "GET",
            data: {
                schoolId: school,
                studyTypeId: studeType,
                genderId: ClassTypeName
            },
            dataType: "json",
            success: function(data) {

                $('#levelID' + index).empty();
                $('#levelID' + index).append(
                    '<option value="0"><?php echo lang('am_choose_select'); ?></option>');
                $.each(data, function(key, value) {
                    $('#levelID' + index).append('<option value="' + value.LevelId + '">' +
                        value.LevelName + '</option>');

                });
            }
        });
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetClassesBySchool',
            type: "GET",
            data: {
                schoolId: school
            },
            dataType: 'json',
            success: function(data) {
                var element = $('#classID');
                element.empty();
                $.each(data, function(key, value) {
                    element.append('<option value="' + value.ClassId + '">' + value
                        .ClassName + '</option>');
                });
            }
        });
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/Years/' + DbName + '/GetOpenedYearsBySchoolId',
            type: "GET",
            data: {
                schoolId: school
            },
            dataType: 'json',
            success: function(data) {
                var element = $('#YearId' + index);
                element.empty();
                element.append(
                '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                var year_array = $('#reg_year').val();
                    var reg_year   = $('#reg_year').val().split(',');
                    if(year_array ==0){
                    var lastElement = null;
                    $.each(data, function(key, value) {
                        lastElement = value;
                    });
                    element.append('<option value="' + lastElement.YearId + '">' + lastElement
                        .YearName + '</option>');
                    }else{
                         $.each(data, function(key, value) {
                        if (reg_year.includes(value.YearName)) {
                        element.append('<option value="' + value.YearId + '">' + value.YearName + '</option>');
                        }
                        });

                    }
            }
        });
    } else {

        $('#levelID' + index).empty();
        $('#levelID' + index).append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
    }
    $('#levelID' + index).trigger('change');
});
 </script>

 <script type="text/javascript">
var index = $('#num_student').val();
$('#levelID' + index).on('change', function() {
    var levelID = $(this).val();
    var school = $('#school' + index).val();
    var studeType = $('#studeType' + index).val();
    var ClassTypeName = $('#ClassTypeName' + index).val();
    var DbName = $('#DbName').val();
    if (school && levelID) {
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetRowsByLevel',
            type: "GET",
            data: {
                schoolId: school,
                levelId: levelID,
                studyTypeId: studeType,
                genderId: ClassTypeName
            },
            dataType: "json",
            success: function(data) {
                $('#rowID' + index).empty();
                $('#rowID' + index).append(
                    '<option value="0"><?php echo lang('am_choose_select'); ?></option>');
                $.each(data, function(key, value) {
                    $('#rowID' + index).append('<option value="' + value.RowId + '">' +
                        value.RowName + '</option>');
                        $('#FeeStatus').val(value.IsSpecialEdu);
                          var selectElement = document.getElementById("status" + index);
                                        if (value.IsSpecialEdu == 1) {
                                            document.getElementById("show_status" + index).style.display = "block";
                                            selectElement.setAttribute("required", "required");
                                        } else {
                                            document.getElementById("show_status" + index).style.display = "none";
                                            selectElement.removeAttribute("required");
                                           
                                        }
                });
            }
        });
    } else {
        $('#rowID' + index).empty();
        $('#rowID' + index).append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
    }
});
 </script>

<script type="text/javascript">
var index = $('#num_student').val();
        $('#rowID' + index).on('change', function() {
        
        var rowId = $(this).val();
        var schoolID = $('#school' + index).val();
        var studeType = $('#studeType' + index).val();
        var ClassTypeName = $('#ClassTypeName' + index).val();
        var levelID = $('#levelID' + index).val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID && rowId) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetFeeStatus',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    levelId: levelID,
                    rowId: rowId,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#status' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.StatusId + '">' + value
                            .StatusName + '</option>');
                    });
                }
            });
        } else {
            var element = $('#status' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>