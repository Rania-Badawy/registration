<style>
    .form-control {
        width: 70%;
        font-size: large;
        border-radius: 15px;
    }

    .control-label {
        font-size: 17px !important;
        width: auto;
    }
</style>
<div class="col-lg-12">
    <div class="block-st">
        <div class="sec-title">
            <h2><?php echo lang('am_student_information') ?> </h2>
        </div>

        <div class="row form-group">

            <form action="<?php echo site_url('admin/Report_Register/edit_register/' . $ID) ?>" method="post">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?php echo lang('student_id') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="check_code" value="<?= $getStudentR['check_code']; ?>" class="form-control " readonly>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?php echo lang('am_father_name') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="parent_name" value="<?= $getStudentR['parent_name']; ?>" class="form-control " readonly>
                                </div>
                            </div>


                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?php echo lang('am_Mobile') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a style="color:red;font-weight: bold;" name="parent_mobile" value="<?= $getStudentR['parent_mobile']; ?>" class="form-control " href="<?php echo site_url('admin/Report_Register/register_status/' . $getStudentR['reg_id']) ?>"><?= "-----" . substr($getStudentR['parent_mobile'], 0, 3); ?></a>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('br_father_NumID') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="ParentNumberID" value="<?= $getStudentR['ParentNumberID']; ?>" class="form-control ">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('am_mail') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="parent_email" value="<?= $getStudentR['parent_email']; ?>" class="form-control ">
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('am_region') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="parent_region" value="<?= $getStudentR['parent_region']; ?>" class="form-control" required>
                                </div>
                            </div>


                            <br><br>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('br_reg_date') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="" value="<?= $getStudentR['Reg_Date']; ?>" class="form-control " readonly>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?php echo lang('student_name') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="student_name" value="<?= $getStudentR['name']; ?>" class="form-control ">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?php echo lang('br_st_numberid') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="student_NumberID" value="<?= $getStudentR['student_NumberID']; ?>" class="form-control ">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('class_type') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="ClassTypeId" name="ClassTypeId" class="form-control" class="form-control " required>

                                        <?php
                                        foreach ($get_ClassTypeName as $val) {

                                        ?>
                                            <option value="<?= $val->ClassTypeId ?>" <?php if ($val->ClassTypeId == $getStudentR['ClassTypeId']) {
                                                                                        echo 'selected';
                                                                                    } ?>>
                                                <?= $val->ClassTypeName ?></option>
                                        <?php

                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('am_studeType') ?></label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="study_type" name="study_type" class="form-control" required>
                                        <option value="0"><?php echo lang('am_choose_select'); ?></option>
                                        <?php foreach ($study_types as $val) { ?>
                                            <option value="<?= $val->StudyTypeId ?>" <?php if ($val->StudyTypeId == $getStudentR['studyType']) {
                                                                                        echo 'selected';
                                                                                    } ?>>
                                                <?= $val->StudyTypeName ?></option>
                                        <?php

                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <br><br>
                            <div class="form-group col-lg-4 ">
                                <label class="control-label col-lg-3"> <?= lang('br_school_name') ?> </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="school" name="school" class="form-control" required>
                                        <option value="0"><?php echo lang('am_choose_select'); ?></option>
                                        <?php foreach ($get_schools as $school) { ?>
                                            <option value="<?= $school->SchoolId ?>" <?php if ($school->SchoolId == $getStudentR['schoolID']) {
                                                                                        echo 'selected';
                                                                                    } ?>>
                                                <?= $school->SchoolName ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('am_level') ?> <span class="danger">*</span></label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="level" name="level" class="form-control" required>
                                        <option value="0"><?php echo lang('am_choose_select'); ?></option>
                                        <?php
                                        foreach ($getLevel as $val) {
                                        ?>
                                            <option value="<?= $val->LevelId ?>" <?php if ($val->LevelId == $getStudentR['LevelID']) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                <?= $val->LevelName ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">
                            <input type="hidden" name="reg_year" id="reg_year" value="<?php echo $reg_year; ?>">
                            <input type="hidden" name="reg_parent_id" id="reg_parent_id" value="<?php echo $getStudentR['reg_parent_id']; ?>">
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('br_row_level') ?> <span class="danger">*</span></label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="row" name="row" class="form-control" required>
                                        <option value="0"><?php echo lang('am_choose_select'); ?></option>
                                        <?php
                                        foreach ($getRow as $val) {
                                        ?>
                                            <option value="<?= $val->RowId ?>" <?php if ($val->RowId == $getStudentR['rowID']) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                <?= $val->RowName ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"><?php echo lang('br_year'); ?></label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select name="GetYear" id="GetYear" class="form-control" required>
                                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                                        <?php if($reg_year) {
            
                                            foreach ($GetYear as $year) {
            
                                                $ID         = $year->YearId;
            
                                                $YearName   = $year->YearName;
            
                                                $year_array = explode(",",$reg_year);
            
                                                if(in_array($YearName,$year_array)){
            
                                        ?>
            
                                        <option value="<?php echo $ID; ?>" <?php if ($ID == $getStudentR['YearId']) { echo "selected"; } ?>><?php echo $YearName; ?></option>
            
                                        <?php }}}else{
                                           
            
                                        foreach ($GetYear as $year) {
            
                                            $ID         = $year->YearId;
            
                                            $YearName   = $year->YearName;
            
                                        ?>
            
                                        <?php }?>
                                        <option value="<?php echo $ID; ?>" <?php if ($ID == $getStudentR['YearId']) { echo "selected"; } ?>><?php echo $YearName; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4" style="display:none">
                                <label class="control-label col-lg-3"> <?= lang('br_class') ?> <span class="danger">*</span></label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="Class" name="Class" class="form-control" required>
                                        <option value="0"><?php echo lang('am_choose_select'); ?></option>
                                        <?php
                                        foreach ($getClass as $val) {
                                        ?>
                                            <option value="<?= $val->ClassId ?>" <?php if ($val->ClassId == $getStudentR['classID']) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                <?= $val->ClassName ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {
                                                                            echo lang('er_TeacherName');
                                                                        } else {
                                                                            echo lang('am_notes');
                                                                        } ?>
                                </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="note" value="<?= $getStudentR['note']; ?>" class="form-control ">
                                </div>
                            </div>

                            
                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> ممثل الخدمه</label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input name="" value="<?= $reg_employee['Name']; ?>" class="form-control " readonly>
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label col-lg-3"> <?= lang('am_how_school') ?> <span class="danger">*</span></label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select id="how_school" name="how_school" class="form-control" class="form-control" required>
                                        <option value="0"><?php echo lang('am_choose_select'); ?></option>
                                        <?php
                                        foreach ($get_how_school as $val) {
                                        ?>
                                            <option value="<?= $val->ID ?>" <?php if ($val->ID == $getStudentR['howScholl']) {
                                                                                echo 'selected';
                                                                            } ?>>
                                                <?= $val->Name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <br><br>

                            <div>

                                <input type="submit" class="btn btn-success" value="<?= lang('br_edit'); ?>" />

            </form>
            <?php $query = $this->db->query("select GroupID from contact where ID =" . $this->session->userdata('id') . "")->row_array();
            if ($query['GroupID'] != 18) {
            ?>
                <!--<a role="button"   href="<?= site_url('admin/Report_Register/delete_register/' . $ID) ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" >-->
                <!--     <?php echo lang('am_delete') ?> -->
                <!--                      </a>-->
            <?php
            }
            ?>
        </div>
    </div>


</div>

</div>
</div>
<!--<script type="text/javascript">-->
<!--    $('select[name^="level"]').on('change', function() {-->
<!--        var levelID = $(this).val();-->
<!--        var school = $('select[name="school"]').val();-->
<!--        var studeType =$('#study_type').val();-->
<!--        var ClassTypeName = $('#ClassTypeId').val();-->
<!--        var DbName = $('#DbName').val();-->
<!--        if (school && levelID) {-->
<!--            $.ajax({-->
<!--                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/'+DbName+'/GetRowsByLevel',-->
<!--                type: "GET",-->
<!--                 data: {schoolId:school ,levelId:levelID,studyTypeId:studeType,genderId:ClassTypeName},-->
<!--                dataType: "json",-->
<!--                success: function(data) {-->
<!--                    $('select[name="row"]').empty();-->
<!--                    $('select[name="row"]').append('<option value="0"><?php echo lang('am_choose_select'); ?></option>');-->
<!--                    $.each(data, function(key, value) {-->
<!--                        $('select[name="row"]').append('<option value="' + value.RowId + '">' + value.RowName+ '</option>');-->
<!--                    });-->
<!--                }-->
<!--            });-->
<!--        }-->
<!--        else {-->
<!--            $('select[name="row"]').empty();-->
<!--            $('select[name="row"]').append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');-->
<!--        }-->
<!--    });-->
<!--</script>-->
<script>
    $('select[name^="ClassTypeId"]').on('change', function() {
       var ClassTypeId = $(this).val();
        var DbName = $('#DbName').val();
        if (DbName == "SchoolAccAdvanced") {
            var newLine = "\r\n"

            var
                message = "تنبيه !! ";
            message += newLine;
            message += "- جميع الطلبة في مرحلة التمهيدي وال KG في جميع المسارات تابعين لقسم البنات.";
            message += newLine;
            message += "- جميع الطلبة في صف (GR1-GR2-GR3) في المسار العالمي تابعين لقسم البنات .";

            alert(message);
        }
        if (ClassTypeId) {
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetAllStudyTypes',
            type: "GET",
            data: {},
            dataType: "json",
            success: function(data) {
                var element = $('#study_type');
                $('#study_type').empty();
                $('#school').empty();
                $('#level').empty();
                $('#row').empty();
                element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                $.each(data, function(key, value) {
                    if ((DbName == "SchoolAccAdvanced" && (value.StudyTypeId != 76 && value
                            .StudyTypeId != 229)) || DbName != "SchoolAccAdvanced") {
                        element.append('<option value="' + value.StudyTypeId + '">' + value
                            .StudyTypeName + '</option>');
                    }
                });
            }
        });
        } else {
            var element = $('#school');
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#school').trigger('change');
        $('#level').trigger('change');
      
    });
</script>
<script>
    $('select[name^="study_type"]').on('change', function() {
        var studeType = $(this).val();
        var DbName = $('#DbName').val();
        var base_url ='<?php echo base_url();?>';
        if (studeType) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' + DbName + '/GetSchoolsByStudyType',
                type: "GET",
                data: {
                    studyTypeId: studeType
                },
                dataType: "json",
                success: function(data) {
                    $('select[name="school"]').empty();
                    $('select[name="school"]').append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        if ((base_url == "https://almashreqia.com/" && value.SchoolId == 4) || (base_url == "https://medad.esol.com.sa/" && value.SchoolId == 1) || DbName !="SchoolAccMedad") {
                        $('select[name="school"]').append('<option value="' + value.SchoolId +
                            '">' + value.SchoolName + '</option>');
                        }
                    });
                }
            });
        } else {
            $('select[name="school"]').empty();
            $('select[name="school"]').append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#school').trigger('change');
        $('#level').trigger('change');
    });
</script>



<script type="text/javascript">
    $('select[name^="school"]').on('change', function() {
        var studeType = $('#study_type').val();
        var school = $(this).val();
        var ClassTypeName = $('#ClassTypeId').val();
        var DbName = $('#DbName').val();
         var year_array    = $('#reg_year').val();
        var reg_year      = $('#reg_year').val().split(',');
        $('select[name="GetYear"]').empty();
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
                    $('select[name="level"]').empty();
                    $('select[name="level"]').append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        // if(value.LevelId!=2 ||value.LevelId!=11){
                        $('select[name="level"]').append('<option value="' + value.LevelId +
                            '">' + value.LevelName + '</option>');
                        // }
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
                    element.append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.ClassId + '">' + value
                            .ClassName + '</option>');
                    });
                }
            });
             $.ajax({
                        url: '<?php echo lang("api_link"); ?>' + '/api/Years/' + DbName +
                            '/GetOpenedYearsBySchoolId',
                        type: "GET",
                        data: {
                            schoolId: school
                        },
                        dataType: 'json',
                        success: function(data) {
                                var element = $('#GetYear');
                                element.empty();
                                element.append(
                                    '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
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
            $('select[name="level"]').empty();
            $('select[name="level"]').append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#level').trigger('change');
    });
</script>

<script type="text/javascript">
    $('select[name^="level"]').on('change', function() {
        var levelID = $(this).val();
        var school = $('select[name="school"]').val();
        var studeType = $('#study_type').val();
        var ClassTypeName = $('#ClassTypeId').val();
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
                    $('select[name="row"]').empty();
                    $('select[name="row"]').append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        $('select[name="row"]').append('<option value="' + value.RowId + '">' +
                            value.RowName + '</option>');
                    });
                }
            });
        } else {
            $('select[name="row"]').empty();
            $('select[name="row"]').append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>