<!--<script src="<?php base_url() ?>/assets_new/js/reg_validation.js"></script>-->
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

    .addbro,
    .btn.btn-success.p-9,
    .btn.btn-primary {
        background: var(--main-color);
        color: #fff;
    }
    .swal2-confirm.swal2-styled{
        padding:10px !important;
    }
</style>
<?php if ($lang == 'english') { ?>
    <style>
        .deleteStudent {
            right: 0 !important;
            left: unset !important;
        }
    </style>
<?php } ?>
<div class="col-md-12 p-0 studentData">
    <?php if (isset($val)) { ?>
        <hr><button onclick="$(this).closest('.studentData').remove();$('#addStudentValue'+'<?= $addStudentValue ?>').remove();" type="button" class="btn btn-danger btn-lg deleteStudent"> <i class="fa fa-trash" aria-hidden="true"></i>
            <?= lang('am_delete_student') ?></button>
    <?php } else {
        //$addStudentValue = 0;
    }

    ?>

    <?php
    $semesterConfig = $this->db->query("SELECT semester FROM setting");
    $semesterConfig = $semesterConfig->row();
    $setting        = $this->db->query("SELECT * FROM `form_setting` WHERE form_type = 1")->result(); 
    $today          = $this->setting_model->converToTimezone();
    $startDate      = new DateTime($today);
    $interval       = new DateInterval('P2Y'); // 2 years and 6 months
    $startDate->sub($interval); 
    $end_date       = $startDate->format('Y-m-d');
    ?>
    <div class="row">
        <div class="col-xs-12 title_register">
            <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_student_data') ?></h5>
        </div>
        <!-- <?php if ($setting[20]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_frist_name') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input type="text" id="name<?= $addStudentValue ?>" name="name[<?= $addStudentValue ?>]" <?php if ($this->ApiDbname == "SchoolAccAdvanced"||$this->ApiDbname == "SchoolAccTanmia") { ?> onblur="showAlert();" <?php } ?> onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="<?= set_value('name[]'); ?>" onkeyup="$('#std'+<?= $addStudentValue ? $addStudentValue : 0 ?>).html($(this).val()+' '+$('#parent_name').val());" class="form-control" required>
                </div>
            </div> -->
        <?php } ?>
        <?php if ($setting[21]->display == 1) { ?>
            <!-- <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <?php if ($this->ApiDbname == "SchoolAccAtlas") { ?>
                    <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 8px;"><?php echo lang('am_firstName_atlas'); ?><?php if ($setting[21]->required == 1) {
                                                                                                                                                    echo '<span class="danger">*</span>';
                                                                                                                                                } ?></label>
                <?php } else { ?>
                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?php echo lang('am_frist_name_eng'); ?><?php if ($setting[21]->required == 1) {
                                                                                                                            echo '<span class="danger">*</span>';
                                                                                                                        } ?></label>
                <?php } ?>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input type="text" id="frist_name_eng<?= $addStudentValue ?>" name="frist_name_eng[<?= $addStudentValue ?>]" maxlength="50" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('frist_name_eng[]'); ?>" class="form-control" <?php if ($setting[21]->required == 1) {
                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                        } ?>>
                </div>
            </div> -->
        <?php } ?>
        <?php if ($setting[22]->display == 1) { ?>
            <!-- <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('reg_id_number') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input type="text" id="student_NumberID" name="student_NumberID[<?= $addStudentValue ?>]" value="<?= set_value('student_NumberID[]'); ?>" <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?> maxlength="10" <?php } else { ?> maxlength="14" <?php } ?> minlength="10" class="arabicNumbers form-control" required>
                </div>
            </div> -->
        <?php } ?>

        <?php if ($setting[23]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_title') ?><?php if ($setting[23]->required == 1) {
                                                                                                        echo '<span class="danger">*</span>';
                                                                                                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <?php if ($this->ApiDbname != "SchoolAccQurtubahJeddah") { ?>
                        <input type="text" id="student_region<?= $addStudentValue ?>" name="student_region[<?= $addStudentValue ?>]" value="<?= set_value('student_region[]'); ?>" maxlength="255" class="form-control" <?php if ($setting[23]->required == 1) {
                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                        } ?>>
                    <?php } else { ?>
                        <input name="student_region1" type="file" id="student_region1" onchange="upload_file2($(this), 'student_region')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[23]->required ==  1) {
                                                                                                                                                                                                                        echo 'required';
                                                                                                                                                                                                                    } ?>>
                        <input type="hidden" name="student_region[<?= $addStudentValue ?>]" id="student_region" <?php if ($setting[23]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if ($setting[24]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('er_Gender') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select id="gender" name="gender[<?= $addStudentValue ?>]" class="form-control" required>
                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                        <?php
                        if ($get_genders) {
                            foreach ($get_genders as $gender) {
                        ?>
                                <option value="<?= $gender->GenderId ?>"><?= $gender->GenderName ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php } ?>
        <?php if ($setting[25]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('class_type') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select id="ClassTypeName" name="ClassTypeName[<?= $addStudentValue ?>]" class="form-control" required>
                        <option value=""><?= lang('am_select') ?></option>
                        <?php
                        if ($get_ClassTypeName) {
                            foreach ($get_ClassTypeName as $TypeName) {
                        ?>
                                <option value="<?= $TypeName->ClassTypeId ?>"><?= $TypeName->ClassTypeName ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php if ($this->ApiDbname == "SchoolAccAbnaAlriyada") { ?>
                    <div class="col-xs-12 p-0" style="font-size: 11px;margin-top: 6px;font-weight: bold;color:red;">
                        <span class="fa fa-file-text"></span>
                        <?= 'مع ملاحظة ان الطلاب بنين وبنات في مرحلة الروضة يسجلو علي قسم البنات'; ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <!--<?php if ($setting[26]->display == 1) { ?>-->
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('br_BirhtDate') ?> <?php if ($setting[26]->required == 1) {
                                                                                                        echo '<span class="danger">*</span>';
                                                                                                    } ?></label>
            <!--<div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
            <!--    <input type="date" id="birth" name="birthdate[<?= $addStudentValue ?>]" class="form-control" value="<?= set_value('birthdate'); ?>" style="text-align: right" <?php if ($setting[26]->required == 1) {
                                                                                                                                                                                        echo 'required';
                                                                                                                                                                                    } ?>>-->
            <!--</div>-->
            <?php if ($setting[59]->display == 1) { ?>
                <div class="input-group col-md-7" style="direction: ltr;">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-success p-9" data-toggle="modal" data-target="#myModal" onclick="set_item('age');" style="width:30px;height:34px"> <i class="fa fa-calendar"></i>
                        </button>
                    </div>
                    <div>
                        <input data-validation="required" style="width:50%" type="text" name="birthdate_hij[<?= $addStudentValue ?>]" class="form-control" maxlength="100" id="age_hij" value="<?= set_value('birthdate_hij'); ?>" readonly style="text-align: right" <?php if ($setting[26]->required == 1) {
                                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                                        } ?> />
                    </div>
                    <input data-validation="required" style="width:50%" type="text" name="birthdate[<?= $addStudentValue ?>]" class="form-control" maxlength="100" id="age" value="<?= set_value('birthdate'); ?>" readonly style="text-align: right" <?php if ($setting[26]->required == 1) {
                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                        } ?> max="<?php echo $end_date ;?>" />
                </div>
            <? } else { ?>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    
                    <input type="text" id="birth" name="birthdate[<?= $addStudentValue ?>]" class="form-control" value="<?= set_value('birthdate'); ?>" style="text-align: right" <?php if ($setting[26]->required == 1) { echo 'required';} ?> max="<?php echo $end_date ;?> ">
                </div>
            <? } ?>

        </div>
        <!--<?php } ?>-->

        <?php if ($setting[27]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_place_birth') ?>
                    <?php if ($setting[27]->required == 1) {
                        echo '<span class="danger">*</span>';
                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input type="text" id="birthplace<?= $addStudentValue ?>" name="birthplace[<?= $addStudentValue ?>]" value="<?= set_value('birthplace[]'); ?>" maxlength="50" class="form-control" <?php if ($setting[27]->required == 1) {
                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                        } ?>>
                </div>
            </div>
        <?php } ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('am_studeType') ?><span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="<?= $addStudentValue ?>" id="studeType<?= $addStudentValue ?>" name="studeType[<?= $addStudentValue ?>]" value="<?= set_value('studeType[]'); ?>" class="form-control" required>
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                    <!--          <php -->
                    <!--if ($studeType) {-->
                    <!--	foreach ($studeType as $stude) {-->
                    <!--?>-->
                    <!--                                  <option value="<?= $stude->StudyTypeId ?>"><?= $stude->StudyTypeName ?></option>-->
                    <!--                                  <php-->
                    <!--	}-->
                    <!--}-->
                    <!--?>-->
                </select>
            </div>
        </div>
        <?php if ($setting[28]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('br_school_name') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <?php $query = $this->db->query("SELECT SchoolName , ID FROM school_details ")->result(); ?>
                    <select data-value="<?= $addStudentValue ?>" id="schoolID<?= $addStudentValue ?>" name="school[<?= $addStudentValue ?>]" value="<?= set_value('school[]'); ?>" class="form-control" required>
                        <option value="" selected><?php echo lang('am_choose_select'); ?></option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <?php if ($setting[29]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"><?php if ($this->ApiDbname == "SchoolAcclittlecaterpillars") { echo lang('con_level'); }else{echo lang('am_level');}?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select data-value="<?= $addStudentValue ?>" id="levelID<?= $addStudentValue ?>" value="<?= set_value('level[]'); ?>" name="level[<?= $addStudentValue ?>]" class="form-control" required>
                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <?php if ($setting[30]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('br_row_level') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select data-value="<?= $addStudentValue ?>" id="rowID<?= $addStudentValue ?>" name="rowID[<?= $addStudentValue ?>]" value="<?= set_value('rowID[]'); ?>" class="form-control" required>
                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                    </select>
                </div>
                <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>
                    <div class="col-xs-12 p-0" style="font-size: 11px;margin-top: 6px;font-weight: bold;">
                        <?php echo "الصف الذي سيلتحق به الطالب"; ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <input type="hidden" name="FeeStatus" id="FeeStatus" value="">
        <?php if ($setting[96]->display == 1) { ?>
            <div id="show_status">
                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('status') ?>
                        <span class="danger">*</span></label>
                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                        <select data-value="<?= $addStudentValue ?>" id="status<?= $addStudentValue ?>" name="status[<?= $addStudentValue ?>]" value="<?= set_value('status[]'); ?>" class="form-control" required>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--<php if($setting[31]->display == 1){ ?>-->
        <div style="display:none;">
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('br_class') ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select data-value="<?= $addStudentValue ?>" id="classID<?= $addStudentValue ?>" name="classID[<?= $addStudentValue ?>]" value="<?= set_value('classID[]'); ?>" class="form-control">
                        <!--<option value=""><?php echo lang('am_choose_select'); ?></option>-->
                    </select>
                </div>
            </div>
        </div>
        <!--<php } ?>-->
        <?php if ($setting[32]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('br_year') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select data-value="<?= $addStudentValue ?>" id="YearId<?= $addStudentValue ?>" name="YearId[<?= $addStudentValue ?>]" class="form-control" required>
                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                    </select>
                </div>
            </div>
        <?php }
        $query_erb = $this->db->query("SELECT IN_ERP ,time_zone FROM  school_details ")->row_array(); 
        $query_sem = $this->db->query("SELECT semester,ApiDbname FROM setting  ")->row_array(); 

        if(($query_erb['IN_ERP'] ==1) && ($query_erb['time_zone'] !='Africa/Cairo')) {

        if ($semesterConfig->semester == NULL) { ?>

            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('Semester') ?> <span class="danger">*</span></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select data-value="<?= $addStudentValue ?>" id="semester<?= $addStudentValue ?>" name="semester[<?= $addStudentValue ?>]" class="form-control" required>
                        <option value=""><?php echo lang('ra_Choose_semester'); ?></option>
                        <option value="1,2,3"><?php echo lang('am_fullyear'); ?></option>
                        <option value="2,3"><?php echo lang('ra_First_second_semester'); ?></option>
                        <option value="3"><?php echo lang('Semester') . " " . lang('er_third'); ?></option>
                    </select>
                </div>
            </div>

        <?php }}
        if ($setting[33]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12">
                    <?= lang('am_student_religion') ?><?php if ($setting[33]->required == 1) {
                                                            echo '<span class="danger">*</span>';
                                                        } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select id="religion[<?= $addStudentValue ?>]" name="religion[<?= $addStudentValue ?>]" class="form-control" <?php if ($setting[33]->required == 1) {
                                                                                                                                        echo 'required';
                                                                                                                                    } ?>>
                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                        <?php
                        if ($religion) {
                            foreach ($religion as $rel) {    ?>
                                <option value="<?= $rel->Value ?>"><?= $rel->Value ?></option>
                        <?php    }
                        } ?>
                    </select>
                    <!--<input type="text" name="religion[<?= $addStudentValue ?>]" name="religion[<?= $addStudentValue ?>]" maxlength="50"  value="" class="form-control" <?php if ($setting[33]->required == 1) {
                                                                                                                                                                                echo 'required';
                                                                                                                                                                            } ?>>-->
                </div>
            </div>
        <?php } ?>

        <?php if ($setting[34]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('second_lang') ?><?php if ($setting[34]->required == 1) {
                                                                                                        echo '<span class="danger">*</span>';
                                                                                                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select id="language" name="language" class="form-control" <?php if ($setting[34]->required == 1) {
                                                                                    echo 'required';
                                                                                } ?>>

                        <?php if ($query_sem['ApiDbname'] == 'SchoolAcclittlecaterpillars') {?>
                            <option value="1">اللغة الإنجليزية</option>
                            <option value="2">اللغة الفرنسية</option>
                            <option value="3">اللغة الألمانية</option>
                            <option value="4">اخرى</option>
                            <option value="5">لايوجد</option>
                        <?php } else {?>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                            <option value="1"><?= lang('French language') ?> </option>
                            <option value="2"> <?= lang('German language') ?> </option>
                        <?php } ?>    
                    </select>
                </div>
            </div>
        <?php } ?>

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/load.css">
        <!-- <div class="loading_div" id="loadingDiv"></div> -->
        <div class="clearfix"></div>

        <?php if ($setting[35]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_last_Degree') ?>
                    <?php if ($setting[35]->required == 1) {
                        echo '<span class="danger">*</span>';
                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input data-value="<?= $addStudentValue ?>" name="uploadFile[<?= $addStudentValue ?>]" type="file" id="uploadFile<?= $addStudentValue ?>" onchange="upload_file($(this))" accept="image/*,.pdf" class="form-control" style="padding-top:5px " <?php if ($setting[35]->required == 1) {
                                                                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                                                                } ?>>
                    <input type="hidden" name="img_name[<?= $addStudentValue ?>]" id="img_name<?= $addStudentValue ?>">
                </div>
                <?php if ($this->ApiDbname != "SchoolAccElinjaz") { ?>
                    <div class="col-xs-12 p-0" style="font-size: 11px;margin-top: 6px;font-weight: bold;">
                        <span class="fa fa-file-text"></span> <?= lang('am_last_Degree_note') ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($setting[36]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_last_school') ?><?php if ($setting[36]->required == 1) {
                                                                                                            echo '<span class="danger">*</span>';
                                                                                                        } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input type="text" id="exSchool" name="exSchool[<?= $addStudentValue ?>]" value="<?= set_value('exSchool[]'); ?>" class="form-control" <?php if ($setting[36]->required == 1) {
                                                                                                                                                                echo 'required';
                                                                                                                                                            } ?>>
                </div>
            </div>
        <?php } ?>


        <?php if ($setting[37]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('na_school_type') ?>
                    <?php if ($setting[37]->required == 1) {
                        echo '<span class="danger">*</span>';
                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <select id="na_school_type" name="na_school_type" class="form-control" <?php if ($setting[34]->required == 1) {
                                                                                                echo 'required';
                                                                                            } ?>>
                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                        <option value="1"><?= lang('governmental') ?> </option>
                        <option value="2"> <?= lang('private') ?> </option>
                        <option value="3"> <?= lang('international') ?> </option>
                    </select>
                </div>
            </div>
        <?php } ?>

        <div class="clearfix"></div>
        <div id="show">
            <?php if ($setting[64]->display == 1) { ?>
                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('Financial_clearance') ?>
                        <?php if ($setting[64]->required == 1) {
                            echo '<span class="danger">*</span>';
                        } ?></label>
                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                        <input data-value="<?= $addStudentValue ?>" name="st_Financial_clearance[<?= $addStudentValue ?>]" type="file" id="st_Financial_clearance<?= $addStudentValue ?>" onchange="upload_file2($(this),'Financial_clearance<?= $addStudentValue ?>')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[64]->required == 1) {
                                                                                                                                                                                                                                                                                                                                                        echo 'required';
                                                                                                                                                                                                                                                                                                                                                    } ?> required>
                        <input type="hidden" name="Financial_clearance[<?= $addStudentValue ?>]" id="Financial_clearance<?= $addStudentValue ?>" <?php if ($setting[64]->required == 1) {
                                                                                                                                                        echo 'required';
                                                                                                                                                    } ?>>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if ($setting[38]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('birth_certificate') ?>
                    <?php if ($setting[38]->required == 1) {
                        echo '<span class="danger">*</span>';
                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input data-value="<?= $addStudentValue ?>" name="st_birth_certificate[<?= $addStudentValue ?>]" type="file" id="st_birth_certificate<?= $addStudentValue ?>" onchange="upload_file2($(this),'birth_certificate<?= $addStudentValue ?>')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[38]->required == 1) {
                                                                                                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                                                                                                        } ?>>
                    <input type="hidden" name="birth_certificate[<?= $addStudentValue ?>]" id="birth_certificate<?= $addStudentValue ?>" <?php if ($setting[38]->required == 1) {
                                                                                                                                                echo 'required';
                                                                                                                                            } ?>>
                </div>
            </div>
        <?php } ?>
        <?php if ($setting[61]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('vaccination_certificate') ?>
                    <?php if ($setting[61]->required == 1) {
                        echo '<span class="danger">*</span>';
                    } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input data-value="<?= $addStudentValue ?>" name="st_vaccination_certificate[<?= $addStudentValue ?>]" type="file" id="st_vaccination_certificate<?= $addStudentValue ?>" onchange="upload_file2($(this),'vaccination_certificate<?= $addStudentValue ?>')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[61]->required == 1) {
                                                                                                                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                                                                                                                            } ?>>
                    <input type="hidden" name="vaccination_certificate[<?= $addStudentValue ?>]" id="vaccination_certificate<?= $addStudentValue ?>" <?php if ($setting[61]->required == 1) {
                                                                                                                                                            echo 'required';
                                                                                                                                                        } ?>>
                </div>
            </div>
        <?php } ?>

        <?php if ($setting[62]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('family_card1') ?> <?php if ($setting[62]->required == 1) {
                                                                                                            echo '<span class="danger">*</span>';
                                                                                                        } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input data-value="<?= $addStudentValue ?>" name="st_family_card1[<?= $addStudentValue ?>]" type="file" id="st_family_card1<?= $addStudentValue ?>" onchange="upload_file2($(this),'family_card1<?= $addStudentValue ?>')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[62]->required == 1) {
                                                                                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                                                                                        } ?>>
                    <input type="hidden" name="family_card1[<?= $addStudentValue ?>]" id="family_card1<?= $addStudentValue ?>" <?php if ($setting[62]->required == 1) {
                                                                                                                                    echo 'required';
                                                                                                                                } ?>>
                </div>
            </div>
        <?php } ?>

        <?php if ($setting[63]->display == 1) { ?>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('family_card2') ?> <?php if ($setting[63]->required == 1) {
                                                                                                            echo '<span class="danger">*</span>';
                                                                                                        } ?></label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input data-value="<?= $addStudentValue ?>" name="st_family_card2[<?= $addStudentValue ?>]" type="file" id="st_family_card2<?= $addStudentValue ?>" onchange="upload_file2($(this),'family_card2<?= $addStudentValue ?>')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[63]->required == 1) {
                                                                                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                                                                                        } ?>>
                    <input type="hidden" name="family_card2[<?= $addStudentValue ?>]" id="family_card2<?= $addStudentValue ?>" <?php if ($setting[63]->required == 1) {
                                                                                                                                    echo 'required';
                                                                                                                                } ?>>
                </div>
            </div>
        <?php } ?>
        <?php $data['get_row_level'] = $this->student_register_model->get_row_level(); ?>
        <div class="clearfix"></div>

        <?php if ($setting[39]->display == 1) { ?>
            <div class="col-xs-12 p-0">
                <div id="load_student_data1"><?= $this->load->view('Student_Register_brothers', $data) ?></div>
                <a href="javascript:void(0)" id="load_student_data1" class="btn addbro btn_regist_Add"><?= lang('na_add_bro') ?></a>
            </div>
        <?php } ?>

        <div class="clearfix"></div>
        <?php if ($setting[69]->display == 1) { ?>
            <div class="col-xs-12 title_register mt-20">
                <h5><i class="fa fa-bus" aria-hidden="true"></i> <?= lang('bus_serv') ?> </h5>
            </div>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content ">
                <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 11px;padding: 5px;">
                    <?= lang('am_want_transport') ?> </label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <div class="form-control" style="display: flex;align-items: center;">
                        <input type="radio" onclick="checkTransport($(this))" name="want_transport" value="1" style="width:auto;margin-top: 0;margin-left: 10px;" checked> <?= lang('am_transport_no') ?>
                        <input type="radio" onclick="checkTransport($(this))" name="want_transport" value="2" style="width:auto;margin-right: 60px;margin-top: 0;margin-left: 10px;">
                        <?= lang('am_transport_yes') ?>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content ">
                <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('am_transport_address') ?> </label>
                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                    <input type="text" id="transport_address" name="transport_address" class="form-control" disabled>
                </div>
            </div>
        <? } ?>
        <!--<div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content ">-->
        <!--    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_transport_type') ?> </label>-->
        <!--    <div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
        <!--        <select class="form-control" id="transport_type" name="transport_type" disabled>-->
        <!--            <option value=""><?= lang('am_transport_type_select') ?></option>-->
        <!--            <option value="1"><?= lang('am_transport_type1') ?></option>-->
        <!--            <option value="2"><?= lang('am_transport_type2') ?></option>-->
        <!--            <option value="3"><?= lang('am_transport_type3') ?></option>-->
        <!--        </select>-->
        <!--    </div>-->
        <!--</div>-->

    </div>
</div>

<input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">
<input type="hidden" name="reg_year" id="reg_year" value="<?php echo $reg_year; ?>">

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

<div class="modal modal_ds modal_st fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('choose_date') ?></h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div id="calendar-converter" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary p-9" data-dismiss="modal" onclick="set_item_btn();"><?php echo lang('am_save') ?>
                </button>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="<?php echo site_url(); ?>hijri-date/calendar.css">
<script type="text/javascript" src="<?php echo site_url(); ?>hijri-date/hijri-date.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>hijri-date/calendar1.js"></script>
<script type="text/javascript">
    // var cal1 = new Calendar(false, 1, false, false, 2020, 00, 01),
    //     cal2 = new Calendar(true, 0, false, false, 1441, 05, 05),
    var DbName = $('#DbName').val();
    var today = new Date();
    var adjustedDate = new Date(today);
    if(DbName!="SchoolAcclittlecaterpillars"){
        adjustedDate.setFullYear(adjustedDate.getFullYear() - 2);
    }
    
    var hijriDate = gregorianToHijri(adjustedDate.getFullYear(), adjustedDate.getMonth(), adjustedDate.getDate(),DbName);
    var cal1 = new Calendar(false, 1, false, false, adjustedDate.getFullYear(), adjustedDate.getMonth(), adjustedDate.getDate(),DbName),
        cal2 = new Calendar(true, 0, false, false, hijriDate[0], hijriDate[1], hijriDate[2]),
        cal1Mode = cal1.isHijriMode(),
        cal2Mode = cal2.isHijriMode();
    // cal1.getElement().
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

    function gregorianToHijri(year, month, day) {
    var date = new Date(year, month - 1, day);
    var julianDate = Math.floor((date / 86400000) - (date.getTimezoneOffset() / 1440) + 2440587.5);
    var days = julianDate - 1948439;
    var cycles = Math.floor(days / 10631);
    var daysInCycle = days % 10631;
    var yearInCycle = Math.floor(daysInCycle / 354);
    var dayOfYear = daysInCycle % 354;
    var hijriYear = (30 * cycles) + yearInCycle + 1;
    var hijriMonth = Math.floor(dayOfYear / 29) + 1;
    var hijriDay = (dayOfYear % 29) + 1;

    return [hijriYear, hijriMonth, hijriDay];
    }
    $(document).ready(function() {

        $(".normal-date").click(function() {
            itemTxt = $("#itemTxt").val();
            year = ($("#calendar-converter .calendar:first-child .year-field").val());
            month = (parseInt($("#calendar-converter .calendar:first-child .month-field").val()));
            day = ($("#calendar-converter .calendar:first-child .selected-date").html());
            var now = new Date();
            var day = ("0" + day).slice(-2);
            var month = ("0" + (month + 1)).slice(-2);
            var today = year + "-" + (month) + "-" + (day);
            //  $('#item_date').val(today);
            $("#" + itemTxt).val(today);


            year = ($("#calendar-converter .calendar:last-child .year-field").val());
            month = (parseInt($("#calendar-converter .calendar:last-child .month-field").val()));
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


<script type="text/javascript">
    function checkLnagLast(val) {
        if (val == 1) {
            var array = ['parent_name', 'parent_name_eng', 'mother_name'];
            var lang = ['ar', 'en', 'ar'];
            for (var i = 0; i < array.length; i++) {
                var input = $('#' + array[i]);
                var check = checkLnag(input, lang[i]);
                if (check == false) {
                    return false;
                }
            }
        }
        if (val == 2) {
            var array = ['name', 'frist_name_eng'];
            var lang = ['ar', 'en'];
            for (var i = 0; i < array.length; i++) {
                var input = $('input[name^="' + array[i] + '"]');
                input.each(function() {
                    var check = checkLnag($(this), lang[i]);
                    if (check == false) {
                        return false;
                    }
                });
            }
        }

    }
</script>
<script type="text/javascript">
    var addStudentValue = 1;
    $(".addbro").click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?php echo site_url(); ?>' + '/home/student_register/add_stu_bro/' + addStudentValue,
            type: "get",
            dataType: "html",
            success: function(data) {
                $('#load_student_data1').append(data);
                addStudentValue++;
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        document.getElementById("show_status").style.display = "none";
        $("#loadingDiv").hide();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            endDate: new Date(2016, 9, 30),

        });
        /* $.ajax({
             url: 'https://api-eduregdiwan.esol.dev/api/StudentRegister/GetAllSchools',
             type: "GET",
             dataType: 'json',
             success: function(data) {
                 var element = $('#schoolID' + '<?= $addStudentValue ?>');
                 element.empty();
                 element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                 console.log(data);
                 $.each(data, function(key, value) {
                    
                             element.append('<option value="' + value['SchoolId'] + '">' + value['SchoolName'] + '</option>');
                        
                 });
             }
         });*/
    });
</script>
<script>
    $('select[name^="ClassTypeName"]').on('change', function() {

        var ClassTypeName = $(this).val();
        var index = $(this).attr('data-value');
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
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetAllStudyTypes',
            type: "GET",
            data: {},
            dataType: "json",
            success: function(data) {
                var element = $('#studeType');
                $('#studeType').empty();
                $('#schoolID').empty();
                $('#levelID').empty();
                $('#rowID').empty();
                $('#classID').empty();
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

    });
</script>

<script>
    $('select[name^="studeType"]').on('change', function() {
        document.getElementById("show_status").style.display = "none";
        var index = $(this).attr('data-value');
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
                    var element = $('#schoolID' + index);
                    element.empty();
                    element.append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        if ((base_url == "https://almashreqia.com/" && value.SchoolId == 4) || (base_url == "https://medad.esol.com.sa/" && value.SchoolId == 1) || DbName !="SchoolAccMedad") {
                        element.append('<option value="' + value.SchoolId + '">' + value
                            .SchoolName + '</option>');
                            }
                    });
                }
            });

        } else {
            var element = $('#schoolID' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
            var element = $('#YearId' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#schoolID' + index).trigger('change');
        $('#levelID' + index).trigger('change');
    });

    $(document).ready(function() {
        const heres = document.getElementsByClassName("here");
        for (const here of heres) {
            here.style.visibility = 'hidden';
        }
    });
</script>

<script type="text/javascript">
    $('select[name^="school"]').on('change', function() {
        var index      = $(this).attr('data-value');
        var schoolID   = $('#schoolID' + index).val();
        var DbName     = $('#DbName').val();
        var year_array = $('#reg_year').val();
        var reg_year   = $('#reg_year').val().split(',');
        if (schoolID) {

            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetClassesBySchool',
                type: "GET",
                data: {
                    schoolId: schoolID
                },
                dataType: 'json',
                success: function(data) {
                    var element = $('#classID' + index);
                    element.empty();
                    // element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
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
                    schoolId: schoolID
                },
                dataType: 'json',
                success: function(data) {
                    var element = $('#YearId' + index);
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
            var element = $('#schoolID' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
            var element = $('#YearId' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>

<script type="text/javascript">
    $('select[name^="school"]').on('change', function() {
        var index = $(this).attr('data-value');
        var studeType = $('#studeType' + index).val();
        var schoolID = $('#schoolID' + index).val();
        var ClassTypeName = $('#ClassTypeName').val();
        var DbName = $('#DbName').val();
        if (schoolID && studeType != "") {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetLevelsBySchool',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#levelID' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.LevelId + '">' + value
                            .LevelName + '</option>');

                    });
                }
            });
        } else {
            var element = $('#levelID' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#levelID' + index).trigger('change');
    });
</script>

<script type="text/javascript">
    $('select[name^="level"]').on('change', function() {
        var index = $(this).attr('data-value');
        var levelID = $(this).val();
        var schoolID = $('#schoolID' + index).val();
        var studeType = $('#studeType' + index).val();
        var ClassTypeName = $('#ClassTypeName' + index).val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetRowsByLevel',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    levelId: levelID,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#rowID' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {

                        element.append('<option value="' + value.RowId + '">' + value.RowName +
                            '</option>');
                        $('#FeeStatus').val(value.IsSpecialEdu);
                        if (value.IsSpecialEdu == 1) {
                            document.getElementById("show_status").style.display = "block";
                        } else {
                            document.getElementById("show_status").style.display = "none";
                        }
                    });

                }
            });
        } else {
            var element = $('#rowID' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>
<script type="text/javascript">
    $('select[name^="rowID"]').on('change', function() {
        var index = $(this).attr('data-value');
        var rowId = $(this).val();
        var schoolID = $('#schoolID' + index).val();
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

<script type="text/javascript">
    var img = null;

    function upload_file(fileInput) {
        $("#loadingDiv").show();
        var fd = new FormData();
        var files = fileInput[0].files[0];
        fd.append('userfile', files);
        var index = fileInput.attr('data-value');
        $.ajax({
            url: '<?= site_url('home/student_register/do_upload') ?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#loadingDiv").hide();
                if (response.success == 1) {
                    img = response.img;
                    $('#img_name' + index).val(img);
                } else {
                    alert(response.msg);
                }
            }
        });
    }
</script>

<script type="text/javascript">
    var DbName = $('#DbName').val();
    var loadedDataValidation = {
        rules: {
            'name': {

                // minlength: 3,
                maxlength: 50,
                messages: {
                    required: "<?= lang('This field is required') ?>",
                    minlength: "<?= lang('Please enter at least 3 characters') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
            },
            'frist_name_eng': {

                // minlength: 3,
                maxlength: 50,
                messages: {
                    required: "<?= lang('This field is required') ?>",
                    minlength: "<?= lang('Please enter at least 3 characters') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
            },

            'student_NumberID': {

                number: true,
                maxlength: 14,
                messages: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",
                    maxlength: "<?= lang('Please enter no more than 14 characters') ?>"
                },

            },

            'student_region': {
                maxlength: 255,
                messages: {
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
            },
            'birthplace': {

                maxlength: 50,
                messages: {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
            },
            'studeType': {

                messages: {
                    required: "<?= lang('This field is required') ?>",

                },
            },
            'school': {
                // 'required': true, 
                messages: {
                    required: "<?= lang('This field is required') ?>",
                },
            },
            'level': {

                messages: {
                    required: "<?= lang('This field is required') ?>",
                },
            },
            'rowID': {

                messages: {
                    required: "<?= lang('This field is required') ?>",
                },
            },
            'language': {

                messages: {
                    required: "<?= lang('This field is required') ?>",
                },
            },
            'gender': {

                messages: {
                    required: "<?= lang('This field is required') ?>",
                },
            },
            'YearId': {

                messages: {
                    required: "<?= lang('This field is required') ?>",
                },
            },
            //  'uploadFile': {
            //       
            //          messages: {
            //           required: "<?= lang('This field is required') ?>",  
            //         },
            //     },
        }
    };

    addRules2(loadedDataValidation, "<?= $addStudentValue ?>");

    function addRules2(rulesObj, idVal) {
        for (var item in rulesObj.rules) {
            var res = item;
            if (item == 'school') {
                res = 'schoolID';
            }
            if (item == 'level') {
                res = 'levelID';
            }
            $('#' + res + idVal).rules('add', rulesObj.rules[item]);
        }
    }
</script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" /> -->
<script type="text/javascript">
    $(document).ready(function() {
        // Hide datepicker when clicked
        $(".datepicker").click(function() {
            $('.datepicker').hide();
        });

        // Initialize datepicker for date of birth
        $('#birth').datepicker({
            format: "yyyy-mm-dd",
            changeMonth: true,
            changeYear: true,
            onSelect: function(selectedDate) {
                $("#birth").val(selectedDate);
            },
            position: {
                my: "left top",
                at: "left bottom",
                of: "#birth"
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        document.getElementById("show").style.display = "none";
    });
    $('select[name^="na_school_type"]').on('change', function() {
        var na_school_type = $('#na_school_type').val();
        if (na_school_type == 2) {
            document.getElementById("show").style.display = "block";
        }
        if (na_school_type == 1) {
            document.getElementById("show").style.display = "none";
        }
    });
</script>
