<div class="loading_div" id="loadingDiv"></div>
<script>
$(document).ready(function() {
    $("#loadingDiv").hide();
});
</script>
<style type="text/css">
.calendars-month table,
.calendars-month table.display thead tr th {
    line-height: normal !important;
}

/* fix rtl for demo */
.chosen-rtl .chosen-drop {
    left: -9000px;
}

.group-result {
    cursor: pointer !important;
}

.red {
    color: #F00;
}
</style>
<div class="clearfix"></div>
<style>
<?php if ($this->session->userdata('language')=='arabic') {
    ?>h4 {
        direction: rtl;
    }

    <?php
}

else {
    ?>h4 {
        direction: ltr;
    }

    <?php
}

?>
</style>
<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2><?php echo lang('br_edit'); ?></h2>
                <a href="<?php echo site_url('admin/Report_Register/index/' . $stu_data[0]->schoolID . "/" . $stu_data[0]->YearId); ?>"
                    class="btn btn-danger pull-left" role="button"> <?php echo lang('Back'); ?> </a>
            </div>
            <?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE `form_type` =1")->result(); ?>
            <?php $reg_parent_id = $stu_data[0]->reg_parent_id; ?>
            <form
                action="<?php echo site_url('admin/Report_Register/edit_student_register/' . $reg_id . "/" . $reg_parent_id); ?>"
                method="post">
                <div class="clearfix"></div>
                <h4> <?php echo lang('am_father_data'); ?> </h4>
                <div class="clearfix"></div>
                <hr>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?= lang('am_Quadrant_name'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="father_name" id="father_name" class="form-control "
                            value="<?php echo $stu_data[0]->parent_name; ?>" onkeyup="checkLnag($(this), 'ar');" required>

                    </div>

                </div>

                <?php if ($setting[1]->display == 1) { ?>
                <div class="form-group col-lg-4">
                    <?php if ($this->ApiDbname == "SchoolAccAtlas") { ?>
                    <label class="control-label col-lg-4"><?php echo lang('am_name_atlas'); ?></label>
                    <?php } else { ?>
                    <label class="control-label col-lg-3"><?php echo lang('am_father_name_en'); ?></label>
                    <?php } ?>
                    <div class="col-lg-8">

                        <input type="text" name="father_name_en" id="father_name_en" class="form-control "
                            value="<?php echo $stu_data[0]->parent_name_eng; ?>" onkeyup="checkLnag($(this), 'en');" <?php if ($setting[1]->required ==  1) {echo 'required';} ?>>

                    </div>
                </div>
                <?php } ?>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('reg_id_number'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="fa_NumberID" id="fa_NumberID" class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->ParentNumberID; ?>"   maxlength="14"  minlength="10" required>

                    </div>

                </div>

                <?php if ($setting[3]->display == 1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_Email'); ?></label>

                    <div class="col-lg-8">

                        <input type="email" name="fa_Email" id="fa_Email" class="form-control "
                            value="<?php echo $stu_data[0]->parent_email; ?>" <?php if ($setting[3]->required ==  1) { echo 'required'; } ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[97]->display == 1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_BirhtDate'); ?></label>

                    <div class="col-lg-8">

                        <input type="date" name="father_brith_date" id="father_brith_date" class="form-control "
                            value="<?php echo $stu_data[0]->father_brith_date; ?>" <?php if ($setting[97]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[4]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_EducationalQualification'); ?></label>

                    <div class="col-lg-8">


                        <select id="EducationalQualification" name="EducationalQualification" class="form-control" <?php if ($setting[4]->required ==  1) {echo 'required';} ?>>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <?php
                                $parent_educational_qualification = $stu_data[0]->parent_educational_qualification;
                                if ($get_educations) {
                                    foreach ($get_educations as $edu) {
                                        $id = $edu->Value;
                                ?>
                            <option value="<?= $id ?>"
                                <?php if ($parent_educational_qualification == $id) { ?>selected<?php } ?>>
                                <?= $edu->Text ?>
                            </option>
                            <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>

                </div>
                <?php } ?>


                <div class="clearfix"></div>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('na_mobile'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="fa_mobile" id="fa_mobile" class="form-control arabicNumbers zero"  value="<?php echo $stu_data[0]->parent_mobile; ?>" required>

                    </div>

                </div>

                <?php if ($setting[7]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php if ($this->ApiDbname == "SchoolAccDigitalCulture") {
                                                                    echo lang('br_discount_code');
                                                                } else {
                                                                    echo lang('na_mobile_2');
                                                                } ?>
                    </label>

                    <div class="col-lg-8">

                        <input type="text" name="fa_mobile2" id="fa_mobile2" class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->parent_mobile2; ?>" <?php if ($setting[7]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[8]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_phone_home'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="phone_home" id="phone_home" class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->parent_phone; ?>" <?php if ($setting[8]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[9]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_Work_Phone'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="work_phone" id="work_phone" class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->parent_phone2; ?>" <?php if ($setting[9]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[10]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_The_job'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="fa_The_job" id="fa_The_job" class="form-control"
                            value="<?php echo $stu_data[0]->parent_profession; ?>" <?php if ($setting[10]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[11]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_work_Address'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="parent_work_address" id="parent_work_address" class="form-control " <?php if ($setting[11]->required ==  1) {echo 'required';} ?>
                            value="<?= $stu_data[0]->parent_work_address?$stu_data[0]->parent_work_address:$stu_data[0]->parent_region; ?>">

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[51]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('Fathers_ID_photo'); ?></label>

                    <div class="col-lg-8">

                        <input name="father_national_id1" type="file" id="father_national_id1"
                            onchange="upload_file2($(this), 'father_national_id')" accept="image/*" class="form-control"
                            value="<?php echo $stu_data[0]->father_national_id; ?>" <?php if ($setting[51]->required ==  1 && !$stu_data[0]->father_national_id ) {echo 'required';} ?>>
                        <input type="hidden" name="father_national_id" id="father_national_id"
                            value="<?php echo $stu_data[0]->father_national_id; ?>" >

                    </div>
                    <?php if ($stu_data[0]->father_national_id) { ?>
                    <a class="imgLink" href="<?= base_url('upload/' . $stu_data[0]->father_national_id) ?>"
                        target="_blank" style="color:#03a9f4"> <?= lang("CLICK_TO_WATCH") ?> </a>
                    <?php } ?>

                </div>
                <?php } ?>

                <div class="clearfix"></div>
                <h4> <?php echo lang('am_mother_data'); ?> </h4>
                <div class="clearfix"></div>
                <hr>

                <?php if ($setting[12]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?= lang('am_name') ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="mother_name" id="mother_name" class="form-control" onkeyup="checkLnag($(this), 'ar');"
                            value="<?php echo $stu_data[0]->mother_name; ?>" <?php if ($setting[12]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[47]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?= lang('am_ID_Number') ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="MotherNumberID" id="MotherNumberID" class="form-control arabicNumbers" maxlength="14"  minlength="10"
                            value="<?php echo $stu_data[0]->motherNumberID; ?>" <?php if ($setting[47]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[13]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_EducationalQualification'); ?></label>

                    <div class="col-lg-8">
                        <select id="mother_educationa" name="mother_educationa" class="form-control" <?php if ($setting[13]->required ==  1) {echo 'required';} ?>>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <?php
                                $mother_educational_qualification = $stu_data[0]->mother_educational_qualification;
                                if ($get_educations) {
                                    foreach ($get_educations as $edu) {
                                        $id = $edu->Value;
                                ?>
                            <option value="<?= $id ?>"
                                <?php if ($mother_educational_qualification == $id) { ?>selected<?php } ?>>
                                <?= $edu->Text ?>
                            </option>
                            <?php
                                    }
                                }
                                ?>
                        </select>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[14]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_The_job'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="ma_The_job" id="ma_The_job" class="form-control "
                            value="<?php echo $stu_data[0]->parent_profession_mather; ?>" <?php if ($setting[14]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <!--<div class="clearfix"></div>-->

                <?php if ($setting[15]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?= lang('am_mother_work') ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="mother_work" id="mother_work" class="form-control "
                            value="<?php echo $stu_data[0]->mother_work; ?>" <?php if ($setting[15]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[16]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_mother_mobile'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="mother_mobile" id="mother_mobile"  class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->mother_mobile; ?>" <?php if ($setting[16]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[17]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_mother_work_phone'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="mother_work_phone" id="mother_work_phone" class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->mother_work_phone; ?>" <?php if ($setting[17]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[18]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_Email'); ?></label>

                    <div class="col-lg-8">

                        <input type="email" name="mother_email" id="mother_email" class="form-control "
                            value="<?php echo $stu_data[0]->mother_email; ?>" <?php if ($setting[18]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>


                <div class="clearfix"></div>

                <h4> <?php echo lang('am_student_data'); ?> </h4>
                <div class="clearfix"></div>
                <hr>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php if ($this->ApiDbname == "SchoolAccElinjaz") {
                                                                echo lang('student_name');
                                                            } else {
                                                                echo lang('am_frist_name');
                                                            } ?>
                    </label>

                    <div class="col-lg-8">

                        <input type="text" name="student_name" id="student_name" class="form-control" onkeyup="checkLnag($(this), 'ar');" 
                            value="<?php echo $stu_data[0]->student_name; ?>" required>

                    </div>

                </div>

                <?php if ($setting[21]->display ==  1) { ?>
                <div class="form-group col-lg-4">
                    <?php if ($this->ApiDbname == "SchoolAccAtlas") { ?>
                    <label class="control-label col-lg-4"><?php echo lang('am_firstName_atlas'); ?></label>
                    <?php } else { ?>
                    <label class="control-label col-lg-3"><?php echo lang('am_frist_name_eng'); ?></label>
                    <?php } ?>

                    <div class="col-lg-8">

                        <input type="text" name="student_name_en" id="student_name_en" class="form-control "
                            value="<?php echo $stu_data[0]->name_eng; ?>" onkeyup="checkLnag($(this), 'en');">

                    </div>

                </div>
                <?php } ?>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php if ($this->ApiDbname == "SchoolAccElinjaz") {
                                                                echo lang('br_st_numberid');
                                                            } else {
                                                                echo lang('reg_id_number');
                                                            } ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="st_NumberID" id="st_NumberID" class="form-control arabicNumbers"
                            value="<?php echo $stu_data[0]->student_NumberID; ?>" maxlength="14"  minlength="10">

                    </div>

                </div>

                <?php if ($setting[23]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_Address'); ?></label>

                    <div class="col-lg-8">


                        <?php if ($this->ApiDbname != "SchoolAccQurtubahJeddah") { ?>

                        <input type="text" name="student_region" id="student_region" class="form-control "
                            value="<?php echo $stu_data[0]->student_region; ?>" <?php if ($setting[23]->required ==  1) {echo 'required';} ?>>
                        <?php } else { ?>
                        <input name="student_region1" type="file" id="student_region1"
                            onchange="upload_file2($(this), 'student_region')" accept="image/*" class="form-control"
                            value="<?php echo $stu_data[0]->student_region; ?>" <?php if ($setting[23]->required ==  1 && !$stu_data[0]->student_region) {echo 'required';} ?>>
                        <input type="hidden" name="student_region" id="student_region"
                            value="<?php echo $stu_data[0]->student_region; ?>" >
                        <?php } ?>

                    </div>

                </div>
                <?php } ?>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_type'); ?></label>

                    <div class="col-lg-8">

                        <select id="st_gender" name="st_gender" class="form-control" required>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <option value="1"
                                <?php echo set_select('st_gender', '1', ($stu_data[0]->gender == '1')); ?>> بنين
                            </option>
                            <option value="2"
                                <?php echo set_select('st_gender', '2', ($stu_data[0]->gender == '2')); ?>>بنات
                            </option>

                        </select>

                    </div>
                </div>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_BirhtDate'); ?></label>

                    <!--<div class="col-lg-8">-->

                    <!--     <input type="date" name="st_BirhtDate" id="st_BirhtDate" class="form-control "  value="<?php echo $stu_data[0]->birthdate; ?>" >-->

                    <!--</div>-->
                    <?php if ($setting[59]->display == 1) { ?>
                    <div class="input-group" style="direction: ltr;">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success p-9" data-toggle="modal" data-target="#myModal"
                                onclick="set_item('age');"> <i class="fa fa-calendar"></i> </button>
                        </div>
                        <input data-validation="required" style="width:50%" type="date" name="st_BirhtDatehij"
                            class="form-control" maxlength="100" id="age_hij"
                            value="<?php echo $stu_data[0]->birthdate_hij; ?>" style="text-align: right"
                            <?php if ($setting[26]->required == 1) {
                                                                                                                                                                                                                                                        echo 'required';
                                                                                                                                                                                                                                                    } ?> />
                        <input data-validation="required" style="width:50%" type="date" name="st_BirhtDate"
                            class="form-control" maxlength="100" id="age" value="<?php echo $stu_data[0]->birthdate; ?>"
                            style="text-align: right"
                            <?php if ($setting[26]->required == 1) {
                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                        } ?> />
                    </div>
                    <? } else { ?>

                    <div class="col-lg-8">

                        <input type="date" name="st_BirhtDate" id="st_BirhtDate" class="form-control "
                            value="<?php echo $stu_data[0]->birthdate; ?>">

                    </div>
                    <?php } ?>

                </div>

                <?php if ($setting[27]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_place_birth'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="st_place_birth" id="st_place_birth" class="form-control "
                            value="<?php echo $stu_data[0]->birthplace; ?>" <?php if ($setting[27]->required ==  1) {echo 'required';} ?>>

                    </div>

                </div>
                <?php } ?>

                <?php if ($setting[34]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('second_lang'); ?></label>

                    <div class="col-lg-8">

                        <select id="second_lang" name="second_lang" class="form-control" <?php if ($setting[34]->required ==  1) {echo 'required';} ?>>
                            <?php $lang = $stu_data[0]->sec_language; ?>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <option value="1"
                                <?php echo set_select('second_lang', '1', ($stu_data[0]->sec_language == '1')); ?>>اللغه
                                الفرنسيه</option>
                            <option value="2"
                                <?php echo set_select('second_lang', '2', ($stu_data[0]->sec_language == '2')); ?>>اللغه
                                الالمانيه</option>

                        </select>

                    </div>
                </div>
                <?php } ?>

                
                <div class="form-group col-lg-4">
                    <label class="control-label col-lg-3"> <?php echo lang('class_type'); ?> </label>
                    <div class="col-lg-8">
                        <select id="ClassTypeId" name="ClassTypeId" class="form-control" class="form-control " required>

                            <?php
                            foreach ($get_ClassTypeName as $val) {
                            ?>

                            <option value="<?= $val->ClassTypeId ?>" <?php if ($val->ClassTypeId == $stu_data[0]->ClassTypeId) {
                                                                                echo 'selected';
                                                                            } ?>>
                                <?= $val->ClassTypeName ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <label class="control-label col-lg-3"> <?php echo lang('am_studeType'); ?></label>
                    <div class="col-lg-8">
                        <select id="study_type" name="study_type" class="form-control" class="form-control" required>
                            <option value=""><?php echo lang('am_select'); ?></option>
                            <?php
                            foreach ($study_types as $val) {
                            ?>

                            <option value="<?= $val->StudyTypeId ?>" <?php if ($val->StudyTypeId == $stu_data[0]->studyType) {
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
                    <label class="control-label col-lg-3"> <?php echo lang('school'); ?> </label>
                    <div class="col-lg-8">
                        <select id="school" name="school" class="form-control" required>
                            <option value="0"><?php echo lang('am_select'); ?></option>
                            <?php foreach ($get_schools as $school) {

                            ?>

                            <option value="<?= $school->SchoolId ?>" <?php if ($school->SchoolId == $stu_data[0]->schoolID) {
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
                    <label class="control-label col-lg-3"> <?php echo lang('am_level'); ?> <span
                            class="danger">*</span></label>
                    <div class="col-lg-8">
                        <select id="level" name="level" class="form-control" required>
                            <option value="0"><?php echo lang('am_select'); ?></option>
                            <?php
                            foreach ($getLevel as $val) {
                            ?>

                            <option value="<?= $val->LevelId ?>" <?php if ($val->LevelId == $stu_data[0]->LevelID) {
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
                <div class="form-group col-lg-4">
                    <label class="control-label col-lg-3"> <?php echo lang('am_row'); ?> <span
                            class="danger">*</span></label>
                    <div class="col-lg-8">
                        <select id="row" name="row" class="form-control" required>
                            <option value="0"><?php echo lang('am_select'); ?></option>
                            <?php
                            foreach ($getRow as $val) {
                            ?>
                            <option value="<?= $val->RowId ?>" <?php if ($val->RowId == $stu_data[0]->rowID) {
                                                                        echo 'selected';
                                                                    } ?>><?= $val->RowName ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="FeeStatus" id="FeeStatus" value="">
                <?php if ($setting[96]->display ==  1) { ?>

                <div id="show_status" <?php if (!$stu_data[0]->status) { ?> style="display:none" <?php } ?>>
                    <div class="form-group col-lg-4">
                        <label class="control-label col-lg-3"> <?php echo lang('status'); ?>
                            <span class="danger">*</span></label>
                        <div class="col-lg-8">
                            <select id="status" name="status" class="form-control" <?php if ($stu_data[0]->status) { ?> required <?php } ?>>
                                <option value=""><?php echo lang('am_select'); ?></option>
                                <?php
                                    foreach ($getStatus as $val) {
                                    ?>
                                <option value="<?= $val->StatusId ?>" <?php if ($val->StatusId == $stu_data[0]->status) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                    <?= $val->StatusName ?>
                                </option>
                                <?php
                                        // }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('br_year'); ?></label>

                    <div class="col-lg-8">

                        <select name="GetYear" id="GetYear" class="form-control" required>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <?php if($reg_year) {

                                foreach ($GetYear as $year) {

                                    $ID         = $year->YearId;

                                    $YearName   = $year->YearName;

                                    $year_array = explode(",",$reg_year);

                                    if(in_array($YearName,$year_array)){

                            ?>

                            <option value="<?php echo $ID; ?>" <?php if ($ID == $Get_Year) { echo "selected"; } ?>><?php echo $YearName; ?></option>

                            <?php }}}else{
                               

                            foreach ($GetYear as $year) {

                                $ID         = $year->YearId;

                                $YearName   = $year->YearName;

                            ?>

                            <?php }?>
                            <option value="<?php echo $ID; ?>" <?php if ($ID == $Get_Year) { echo "selected"; } ?>><?php echo $YearName; ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <?php if ($setting[38]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('birth_certificate'); ?></label>

                    <div class="col-lg-8">

                        <input name="st_birth_certificate" type="file" id="st_birth_certificate"
                            onchange="upload_file2($(this), 'birth_certificate')" accept="image/*" class="form-control"
                            value="<?php echo $stu_data[0]->birth_certificate; ?>" <?php if ($setting[38]->required ==  1 && !$stu_data[0]->birth_certificate) {echo 'required';} ?>>
                        <input type="hidden" name="birth_certificate" id="birth_certificate"
                            value="<?php echo $stu_data[0]->birth_certificate; ?>" >

                    </div>
                    <?php if ($stu_data[0]->birth_certificate) { ?>
                    <a class="imgLink" href="<?= base_url('upload/' . $stu_data[0]->birth_certificate) ?>"
                        target="_blank" style="color:#03a9f4"> <?= lang("CLICK_TO_WATCH") ?> </a>
                    <?php } ?>

                </div>
                <?php } ?>


                <?php if ($setting[61]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('vaccination_certificate'); ?></label>

                    <div class="col-lg-8">

                        <input name="st_vaccination_certificate" type="file" id="st_vaccination_certificate"
                            onchange="upload_file2($(this), 'vaccination_certificate')" accept="image/*"
                            class="form-control" value="<?php echo $stu_data[0]->vaccination_certificate; ?>" <?php if ($setting[61]->required ==  1 && !$stu_data[0]->vaccination_certificate) {echo 'required';} ?>>
                        <input type="hidden" name="vaccination_certificate" id="vaccination_certificate"
                            value="<?php echo $stu_data[0]->vaccination_certificate; ?>" >

                    </div>
                    <?php if ($stu_data[0]->vaccination_certificate) { ?>
                    <a class="imgLink" href="<?= base_url('upload/' . $stu_data[0]->vaccination_certificate) ?>"
                        target="_blank" style="color:#03a9f4"> <?= lang("CLICK_TO_WATCH") ?> </a>
                    <?php } ?>

                </div>
                <?php } ?>

                <?php if ($setting[62]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('family_card1'); ?></label>

                    <div class="col-lg-8">

                        <input name="st_family_card1" type="file" id="st_family_card1"
                            onchange="upload_file2($(this), 'family_card1')" accept="image/*" class="form-control"
                            value="<?php echo $stu_data[0]->family_card1; ?>" <?php if ($setting[62]->required ==  1 && !$stu_data[0]->family_card1) {echo 'required';} ?>>
                        <input type="hidden" name="family_card1" id="family_card1"
                            value="<?php echo $stu_data[0]->family_card1; ?>" >

                    </div>
                    <?php if ($stu_data[0]->family_card1) { ?>
                    <a class="imgLink" href="<?= base_url('upload/' . $stu_data[0]->family_card1) ?>" target="_blank"
                        style="color:#03a9f4"> <?= lang("CLICK_TO_WATCH") ?> </a>
                    <?php } ?>

                </div>
                <?php } ?>

                <?php if ($setting[63]->display ==  1) { ?>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('family_card2'); ?></label>

                    <div class="col-lg-8">

                        <input name="st_family_card1" type="file" id="st_family_card2"
                            onchange="upload_file2($(this), 'family_card2')" accept="image/*" class="form-control"
                            value="<?php echo $stu_data[0]->family_card2; ?>" <?php if ($setting[63]->required ==  1 && !$stu_data[0]->family_card2) {echo 'required';} ?>>
                        <input type="hidden" name="family_card2" id="family_card2"
                            value="<?php echo $stu_data[0]->family_card2; ?>" >

                    </div>

                    <?php if ($stu_data[0]->family_card2) { ?>
                    <a class="imgLink" href="<?= base_url('upload/' . $stu_data[0]->family_card2) ?>" target="_blank"
                        style="color:#03a9f4"> <?= lang("CLICK_TO_WATCH") ?> </a>
                    <?php } ?>

                </div>
                <?php } ?>




                <?php if ($setting[39]->display == 1) { ?>
                <?php $query = $this->db->query(" select reg_brothers.*,row_level.*,row_level.ID AS row_level,reg_brothers.ID AS bro_id from reg_brothers left join row_level on row_level.ID = reg_brothers.Row_Level_Id where reg_id=$reg_id ORDER BY `reg_brothers`.`ID` ASC")->result();  ?>
                <?php foreach ($query as $Key => $row) {
                        $id             = $row->bro_id;
                        $Bro_Name        = $row->Bro_Name;
                        $row_level      = $row->row_level;
                        $Level_Name        = $row->Level_Name;
                        $Row_Name        = $row->Row_Name;
                        $School_Name    = $row->School_Name;
                        $School_Type    = $row->School_Type;
                    ?>


                <input type="hidden" name="bro_id[<?= $Key ?>]" id="bro_id[<?= $Key ?>]" class="form-control "
                    value="<?php echo $id; ?>">
                <div class="clearfix"></div>

                <h4> <?php echo lang('bro_data'); ?> </h4>
                <div class="clearfix"></div>
                <hr>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('na_bro_name'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="bro_name[<?= $Key ?>]" id="bro_name[<?= $Key ?>]" class="form-control "
                            value="<?php echo $Bro_Name; ?>">

                    </div>

                </div>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('am_level'); ?></label>

                    <div class="col-lg-8">

                        <select id="BR0_RowLevelId[<?= $Key ?>]" name="BR0_RowLevelId[<?= $Key ?>]"
                            class="form-control">
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <?php
                                    if ($get_row_level) {
                                        foreach ($get_row_level as $RowLevel) {
                                            $id = $RowLevel->row_level_ID;
                                    ?>
                            <option value="<?= $id ?>" <?php if ($row_level == $id) { ?>selected<?php } ?>>
                                <?= $RowLevel->rowName . "-" . $RowLevel->levelName ?></option>
                            <?php
                                        }
                                    }
                                    ?>
                        </select>

                    </div>

                </div>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('school_Name'); ?></label>

                    <div class="col-lg-8">

                        <input type="text" name="bro_school_Name[<?= $Key ?>]" id="bro_school_Name[<?= $Key ?>]"
                            class="form-control " value="<?php echo $School_Name; ?>">

                    </div>

                </div>
                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-3"><?php echo lang('na_school_type'); ?></label>

                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                        <select id="bro_school_type[<?= $Key ?>]" name="bro_school_type[<?= $Key ?>]"
                            class="form-control">
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <option value="1" <?php if ($School_Type == 1) { ?>selected<?php } ?>> خاص </option>
                            <option value="2" <?php if ($School_Type == 2) { ?>selected<?php } ?>> حكومي </option>
                        </select>
                    </div>
                </div>

                <?php } ?>
                <div class="clearfix"></div>
                <div class="col-lg-2">
                    <button type="button" class="allowedAddedButton btn btn-success" data-toggle="modal"
                        data-target="#view-rating-<?= $Num ?>"><?php echo lang('na_add_bro') ?></button>
                </div>
                <?php } ?>



                <div class="col-lg-2">

                    <input type="submit" class="btn btn-success" onclick="return check_sub();"
                        value="<?php echo lang('br_save') ?>">
                    <!--<input type="submit" class="btn btn-success" onclick="return check_sub();" value="<?php echo lang('cancel')  ?>" >-->
                </div>

            </form>

            <form action="<?php echo site_url('admin/Report_Register/add_student_brother/' . $reg_id); ?>"
                method="post">
                <div id="view-rating-<?= $Num ?>" class="modal fade in" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">
                                    <?php echo lang('na_add_bro') ?>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        rtl>×</button>
                                </h4>
                            </div>

                            <div class="modal-body">

                                <div class="form-group col-lg-4">

                                    <label class="control-label col-lg-3"><?php echo lang('na_bro_name'); ?></label>

                                    <div class="col-lg-8">

                                        <input type="text" name="broName" id="broName" class="form-control" value="">

                                    </div>

                                </div>

                                <div class="form-group col-lg-4">

                                    <label class="control-label col-lg-3"><?php echo lang('am_level'); ?></label>

                                    <div class="col-lg-8">

                                        <select id="bro_rowlevel" name="bro_rowlevel" class="form-control">
                                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                                            <?php
                                            if ($get_row_level) {
                                                foreach ($get_row_level as $RowLevel) {
                                                    $id = $RowLevel->row_level_ID;
                                            ?>
                                            <option value="<?= $id ?>">
                                                <?= $RowLevel->levelName . "-" . $RowLevel->rowName ?>
                                            </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group col-lg-4">

                                    <label class="control-label col-lg-3"><?php echo lang('school_Name'); ?></label>

                                    <div class="col-lg-8">

                                        <input type="text" name="bro_schoolName" id="bro_schoolName"
                                            class="form-control " value="">

                                    </div>

                                </div>
                                <div class="form-group col-lg-4">

                                    <label class="control-label col-lg-3"><?php echo lang('na_school_type'); ?></label>

                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="bro_schooltype" name="bro_schooltype" class="form-control">
                                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                                            <option value="1"> خاص </option>
                                            <option value="2"> حكومي </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="modal-footer noborder">
                                    <input type="submit" class="btn btn-success text-right"
                                        onclick="return check_sub();" value="<?php echo lang('br_save') ?>">
                                    <button type="button" class="btn btn-danger text-right"
                                        data-dismiss="modal"><?php echo lang('cancel')  ?></button>
                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <?php if ($setting[59]->display == 1) { ?>
            <style>
            input::-webkit-calendar-picker-indicator {
                display: none;
            }

            input[type="date"]::-webkit-input-placeholder {
                visibility: hidden !important;
            }

            .p-9 {
                padding: 9px 12px;
            }
            </style>
            <? } ?>
            <!-- Modal -->
            <input type="hidden" id="itemTxt" />

            <div class="modal modal_ds modal_st fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-right">
                            <h4 class="modal-title" id="myModalLabel">اختيار التاريخ</h4>
                        </div>
                        <div class="modal-body">
                            <div class="clearfix"></div>
                            <div id="calendar-converter" class="text-center"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"
                                onclick="set_item_btn();">حفظ </button>
                        </div>
                    </div>
                </div>
            </div>


            <link rel="stylesheet" href="<?php echo site_url(); ?>hijri-date/calendar.css">
            <script type="text/javascript" src="<?php echo site_url(); ?>hijri-date/hijri-date.js"></script>
            <script type="text/javascript" src="<?php echo site_url(); ?>hijri-date/calendar.js"></script>
            <script type="text/javascript">
            var cal1 = new Calendar(false, 1, false, false, 2020, 00, 01),
                cal2 = new Calendar(true, 0, false, false, 1441, 05, 05),
                cal1Mode = cal1.isHijriMode(),
                cal2Mode = cal2.isHijriMode();
            document.getElementById('calendar-converter').appendChild(cal1.getElement());
            document.getElementById('calendar-converter').appendChild(cal2.getElement());
            cal1.setDisplayStyle('inline-block');
            cal2.setDisplayStyle('inline-block');
            cal2.getElement().style.marginLeft = '20px';
            cal1.show();
            cal2.show();

            cal1.callback = function() {
                if (cal1Mode !== cal1.isHijriMode()) {
                    cal2.disableCallback(true);
                    cal2.changeDateMode();
                    cal2.disableCallback(false);
                    cal1Mode = cal1.isHijriMode();
                    cal2Mode = cal2.isHijriMode();
                } else
                    cal2.setTime(cal1.getTime());
            };

            cal2.callback = function() {
                if (cal2Mode !== cal2.isHijriMode()) {
                    cal1.disableCallback(true);
                    cal1.changeDateMode();
                    cal1.disableCallback(false);
                    cal1Mode = cal1.isHijriMode();
                    cal2Mode = cal2.isHijriMode();
                } else
                    cal1.setTime(cal2.getTime());
            };

            cal1.onHide = function() {
                cal1.show();
            };

            cal2.onHide = function() {
                cal2.show();
            };


            function date_show(id) {
                $("#div_" + id).show();

            }

            function set_item(id) {
                $("#itemTxt").val(id);

            }

            function Experience_Certificate_select(id, num) {
                if (id == '2') {
                    $('.CertificateDateForm_div_' + num).hide();
                } else {
                    $('.CertificateDateForm_div_' + num).show();
                }
            }

            function set_item_btn() {
                itemTxt = $("#itemTxt").val();
                year = ($("#calendar-converter .calendar:first-child .year-field").val());
                month = (parseInt($("#calendar-converter .calendar:first-child .month-field").val()));
                day = ($("#calendar-converter .calendar:first-child .selected-date").html());
                var now = new Date();
                var day = ("0" + day).slice(-2);
                var month = ("0" + (month + 1)).slice(-2);
                var today = year + "-" + (month) + "-" + (day);
                $('#item_date').val(today);
                $("#" + itemTxt).val(today);


                year = ($("#calendar-converter .calendar:last-child .year-field").val());
                month = (parseInt($("#calendar-converter .calendar:last-child .month-field").val()));
                day = ($("#calendar-converter .calendar:last-child .selected-date").html());
                var now = new Date();
                var day = ("0" + day).slice(-2);
                var month = ("0" + (month + 1)).slice(-2);
                var today = year + "-" + (month) + "-" + (day);
                $('#item_date_hij').val(today);
                $("#" + itemTxt + "_hij").val(today);

            }
            $(document).ready(function() {

                $(".normal-date").click(function() {
                    itemTxt = $("#itemTxt").val();
                    year = ($("#calendar-converter .calendar:first-child .year-field").val());
                    month = (parseInt($("#calendar-converter .calendar:first-child .month-field")
                        .val()));
                    day = ($("#calendar-converter .calendar:first-child .selected-date").html());
                    var now = new Date();
                    var day = ("0" + day).slice(-2);
                    var month = ("0" + (month + 1)).slice(-2);
                    var today = year + "-" + (month) + "-" + (day);
                    //  $('#item_date').val(today);
                    $("#" + itemTxt).val(today);


                    year = ($("#calendar-converter .calendar:last-child .year-field").val());
                    month = (parseInt($("#calendar-converter .calendar:last-child .month-field")
                        .val()));
                    day = ($("#calendar-converter .calendar:last-child .selected-date").html());
                    var now = new Date();
                    var day = ("0" + day).slice(-2);
                    var month = ("0" + (month + 1)).slice(-2);
                    var today = year + "-" + (month) + "-" + (day);
                    // $('#item_date_hij').val(today);
                    $("#" + itemTxt + "_hij").val(today);



                });
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            });
            </script>
            <script>
            $('select[name^="ClassTypeId"]').on('change', function() {
                var ClassTypeId = $(this).val();
                var index = $(this).attr('data-value');
                var DbName = $('#DbName').val();

                $.ajax({
                    url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName +
                        '/GetAllStudyTypes',
                    type: "GET",
                    data: {},
                    dataType: "json",
                    success: function(data) {
                        var element = $('#study_type');
                        $('#study_type').empty();
                        $('#school').empty();
                        $('#level').empty();
                        $('#row').empty();
                        element.append(
                            '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                        );
                        $.each(data, function(key, value) {
                            element.append('<option value="' + value.StudyTypeId + '">' +
                                value.StudyTypeName + '</option>');
                        });


                    }
                });

            });
            </script>

            <script>
            $('select[name^="study_type"]').on('change', function() {
                document.getElementById("show_status").style.display = "none";
                document.getElementById("status").required = false;
                var studeType = $(this).val();
                var DbName = $('#DbName').val();
                var base_url ='<?php echo base_url();?>';
                if (studeType) {
                    $.ajax({
                        url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' + DbName +
                            '/GetSchoolsByStudyType',
                        type: "GET",
                        data: {
                            studyTypeId: studeType
                        },
                        dataType: "json",
                        success: function(data) {
                            $('select[name="school"]').empty();
                            $('select[name="school"]').append(
                                '<option value=""><?php echo lang('am_choose_select'); ?></option>'
                            );

                            $.each(data, function(key, value) {
                                if ((base_url == "https://almashreqia.com/" && value.SchoolId == 4) || (base_url == "https://medad.esol.com.sa/" && value.SchoolId == 1) || DbName !="SchoolAccMedad") {
                                $('select[name="school"]').append('<option value="' + value
                                    .SchoolId + '">' + value.SchoolName + '</option>');
                                }
                            });
                            // if ((DbName == "SchoolAccTanmia" && studeType == 1820) || (DbName ==
                            //         "SchoolAccDigitalCulture" && (studeType == 1321 || studeType ==
                            //             1331))) {
                            //     document.getElementById("show_status").style.display = "block";
                            // }
                        }
                    });
                } else {
                    $('select[name="school"]').empty();
                    $('select[name="school"]').append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                }
                $('#school').trigger('change');
                $('#level').trigger('change');
            });
            </script>



            <script type="text/javascript">
            $('select[name^="school"]').on('change', function() {
                var studeType     = $('#study_type').val();
                var school        = $(this).val();
                var ClassTypeName = $('#ClassTypeId').val();
                var DbName        = $('#DbName').val();
                var year_array    = $('#reg_year').val();
                var reg_year      = $('#reg_year').val().split(',');
                $('select[name="GetYear"]').empty();
                if (school && studeType != "") {
                    $.ajax({
                        url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName +
                            '/GetLevelsBySchool',
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
                                '<option value=""><?php echo lang('am_choose_select'); ?></option>'
                            );
                            $.each(data, function(key, value) {
                                // if(value.LevelId!=2 ||value.LevelId!=11){
                                $('select[name="level"]').append('<option value="' + value
                                    .LevelId + '">' + value.LevelName + '</option>');
                                // }
                            });
                        }
                    });
                    $.ajax({
                        url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName +
                            '/GetClassesBySchool',
                        type: "GET",
                        data: {
                            schoolId: school
                        },
                        dataType: 'json',
                        success: function(data) {
                            var element = $('#classID');
                            element.empty();
                            element.append(
                                '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                            );
                            $.each(data, function(key, value) {
                                element.append('<option value="' + value.ClassId + '">' +
                                    value.ClassName + '</option>');
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
                    $('select[name="level"]').append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                    $('select[name="GetYear"]').empty();
                    $('select[name="GetYear"]').append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                }
                $('#level').trigger('change');
                $('#GetYear').trigger('change');
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
                        url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName +
                            '/GetRowsByLevel',
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
                                '<option value=""><?php echo lang('am_choose_select'); ?></option>'
                            );
                            $.each(data, function(key, value) {
                                $('select[name="row"]').append('<option value="' + value
                                    .RowId + '">' + value.RowName + '</option>');
                                    $('#FeeStatus').val(value.IsSpecialEdu);
                            if (value.IsSpecialEdu==1) {
                                document.getElementById("show_status").style.display = "block";
                                document.getElementById("status").required = true;
                            } else {
                                document.getElementById("show_status").style.display = "none";
                                document.getElementById("status").required = false;
                            }
                            });
                        }
                    });
                } else {
                    $('select[name="row"]').empty();
                    $('select[name="row"]').append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                }
            });
            </script>
            <script type="text/javascript">
            $('select[name^="row"]').on('change', function() {
                var rowId = $(this).val();
                var levelID = $('#level').val();
                var school = $('select[name="school"]').val();
                var studeType = $('#study_type').val();
                var ClassTypeName = $('#ClassTypeId').val();
                var DbName = $('#DbName').val();
                if (school && levelID && rowId) {
                    $.ajax({
                        url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName +
                            '/GetFeeStatus',
                        type: "GET",
                        data: {
                            schoolId: school,
                            levelId: levelID,
                            rowId: rowId,
                            studyTypeId: studeType,
                            genderId: ClassTypeName
                        },
                        dataType: "json",
                        success: function(data) {
                            $('select[name="status"]').empty();
                            $('select[name="status"]').append(
                                '<option value=""><?php echo lang('am_choose_select'); ?></option>'
                            );
                            $.each(data, function(key, value) {
                                $('select[name="status"]').append('<option value="' + value
                                    .StatusId + '">' + value.StatusName + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="status"]').empty();
                    $('select[name="status"]').append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                }
            });
            </script>
            <script type="text/javascript">
            var img = null;

            function upload_file2(fileInput, name) {
                $("#loadingDiv").show();
                var fd = new FormData();
                var files = fileInput[0].files[0];
                fd.append('userfile', files);
                $.ajax({
                    url: '<?= site_url('home/student_register/do_upload') ?>',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success == 1) {
                            $("#loadingDiv").hide();
                            img = response.img;
                            $('#' + name).val(img);
                        } else {
                            alert(response.msg);
                        }
                    }
                });
            }
            </script>
            <script type="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js">
            </script>
            <link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
            <script type="text/javascript">
            $(document).ready(function() {
                $(".datepicker").click(function() {
                    $('.datepicker').hide();
                });
                $('#father_brith_date').datepicker({
                    format: "yyyy-mm-dd"
                });


            });
            // birth.max = new Date().toISOString().split("T")[0];
            </script>
            <script>
                function checkLnag(input, lang) {
                    var userInput = input.val();

                    if (lang == 'ar') {
                        let regex = /^[؀-ۿ ]+$/;
                        let regex1 = /[{٠-٩}]/;
                        if (userInput.match(regex1) || !userInput.match(regex)) {
                            // alert("Only use Arabic characters!");
                            input.val('');
                        }
                    } else {
                        let regex = /[\u0600-\u06FF\u0750-\u077F^0-9{٠-٩}]/;
                        if (userInput.match(regex)) {
                            //  alert("Only use English characters!");
                            input.val('');
                        }
                    }
                }
            </script>
             <script>
                $(".zero").on("input", function() {
                    if (/^0/.test(this.value)) {
                        this.value = this.value.replace(/^0/, "")
                    }
                })
            </script>


            <script>
                function toEnglishNumber(strNum) {
                    var ar = '٠١٢٣٤٥٦٧٨٩'.split('');
                    var en = '0123456789'.split('');
                    strNum = strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => en[ar.indexOf(x)]);
                    strNum = strNum.replace(/[^\d]/g, '');
                    return strNum;
                }

                $(document).on('keyup', '.arabicNumbers', function(e) {
                    var val = toEnglishNumber($(this).val())
                    $(this).val(val)
                });
                document.addEventListener('DOMContentLoaded', function() {
                var inputs = document.querySelectorAll('input[minlength]');
                inputs.forEach(function(input) {
                    input.addEventListener('input', function() {
                        var minLength = input.getAttribute('minlength');
                        var valueLength = input.value.length;
                        if (valueLength > 0 && valueLength < minLength) {
                            input.setCustomValidity('Input must be at least ' + minLength + ' characters long.');
                        } else {
                            input.setCustomValidity(''); 
                        }
                    });
                });
            });
            </script>