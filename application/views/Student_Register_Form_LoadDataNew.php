<!--<script src="<?php base_url()?>/assets_new/js/reg_validation.js"></script>-->
<div class="col-md-12 p-0 studentData">
    <?php if (isset($val)) { ?>
    <hr><button onclick="$(this).closest('.studentData').remove();$('#addStudentValue'+'<?=$addStudentValue?>').remove();" type="button" class="btn btn-danger btn-lg deleteStudent"> <i class="fa fa-trash" aria-hidden="true"></i> <?=lang('am_delete_student')?></button>
    <?php }
    else {
        //$addStudentValue = 0;
    }
    
    
     ?>
 <?php $setting = $this->db->query("SELECT * FROM `form_setting`")->result();?>
    <div class="row">
        <div class="col-xs-12 title_register">
            <h5><i class="fa fa-user" aria-hidden="true"></i><?=lang('am_student_data')?></h5>
        </div>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_frist_name')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="name<?=$addStudentValue?>" name="name[<?=$addStudentValue?>]" maxlength="50" value="<?=set_value('name[]'); ?>" onkeyup="checkLnag($(this), 'ar');" class="form-control" required>
            </div>
        </div>
        
        <?php if($setting[21]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_frist_name_eng')?><?php if($setting[21]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="frist_name_eng<?=$addStudentValue?>" name="frist_name_eng[<?=$addStudentValue?>]" maxlength="50" onkeyup="checkLnag($(this), 'en');" value="<?=set_value('frist_name_eng[]'); ?>" class="form-control" <?php if($setting[21]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('reg_id_number')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="student_NumberID<?=$addStudentValue?>" name="student_NumberID[<?=$addStudentValue?>]" value="<?=set_value('student_NumberID[]'); ?>" onkeypress="return onlyNumberKey(event)" maxlength="14" minlength="10" class="form-control" required>
            </div>
        </div>


        <?php if($setting[23]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_title')?><?php if($setting[23]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="student_region<?=$addStudentValue?>" name="student_region[<?=$addStudentValue?>]" value="<?=set_value('student_region[]'); ?>" maxlength="255" class="form-control" <?php if($setting[23]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_type')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select id="gender" name="gender[<?=$addStudentValue?>]" class="form-control" required>
                     <option value=""><?php echo lang('am_choose_select'); ?></option>
                  <?php 
										if ($get_genders) {
											foreach ($get_genders as $gender) {
										?>
                                            <option value="<?=$gender->GenderId?>"><?=$gender->GenderName?></option>
                                            <?php
											}
										}
										?>
                </select>
            </div>
        </div>
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('class_type')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select id="ClassTypeName" name="ClassTypeName[<?=$addStudentValue?>]" class="form-control" required>
                    <option value=""><?=lang('am_select')?></option>
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
        
        <?php if($setting[26]->display == 1){ ?>
       <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('br_BirhtDate')?> <?php if($setting[26]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="date" id="birth" name="birthdate[<?=$addStudentValue?>]" class="form-control" value="<?=set_value('birthdate'); ?>" max="2018-04-01" style="text-align: right" <?php if($setting[26]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <?php if($setting[27]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_place_birth')?> <?php if($setting[27]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="birthplace<?=$addStudentValue?>" name="birthplace[<?=$addStudentValue?>]" value="<?=set_value('birthplace[]'); ?>" maxlength="50" class="form-control" <?php if($setting[27]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('am_studeType')?><span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="<?=$addStudentValue?>" id="studeType<?=$addStudentValue?>" name="studeType[<?=$addStudentValue?>]" value="<?=set_value('studeType[]'); ?>" class="form-control" required>
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
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('br_school_name')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <?php $query = $this->db->query("SELECT SchoolName , ID FROM school_details ")->result(); ?>
                <select data-value="<?=$addStudentValue?>" id="schoolID<?=$addStudentValue?>" name="school[<?=$addStudentValue?>]" value="<?=set_value('school[]'); ?>" class="form-control" required>
                    <option value="" selected><?php echo lang('am_choose_select'); ?></option>
                     <?php 
								// 		if ($get_schools) {
								// 			foreach ($get_schools as $school) {
										?>
                                            <!--<option value="<?=$school->SchoolId?>"><?=$school->SchoolName?></option>-->
                                            <?php
								// 			}
								// 		}
										?>
                </select>
            </div>
        </div>
        
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('am_level')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="<?=$addStudentValue?>" id="levelID<?=$addStudentValue?>" value="<?=set_value('level[]'); ?>" name="level[<?=$addStudentValue?>]" class="form-control" required>
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                </select>
            </div>
        </div>
        
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('br_row_level')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="<?=$addStudentValue?>" id="rowID<?=$addStudentValue?>" name="rowID[<?=$addStudentValue?>]" value="<?=set_value('rowID[]'); ?>" class="form-control" required>
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                </select>
            </div>
        </div>
        
        <?php if($setting[31]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('br_class')?><?php if($setting[31]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="<?=$addStudentValue?>" id="classID<?=$addStudentValue?>" name="classID[<?=$addStudentValue?>]" value="<?=set_value('classID[]'); ?>" class="form-control" <?php if($setting[31]->required == 1){ echo 'required';} ?>>
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                </select>
            </div>
        </div>
        <?php } ?>
        
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12">  <?=lang('br_year')?> <span class="danger">*</span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="<?=$addStudentValue?>" id="YearId<?=$addStudentValue?>" name="YearId[<?=$addStudentValue?>]" class="form-control" required>
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                </select>
            </div>
        </div>
        
        <?php if($setting[33]->display == 1){ ?>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_student_religion')?><?php if($setting[33]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" name="religion[<?=$addStudentValue?>]" name="religion[<?=$addStudentValue?>]" maxlength="50"  value="" class="form-control" <?php if($setting[33]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <?php if($setting[34]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('second_lang')?><?php if($setting[34]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select id="language"  name="language" class="form-control" <?php if($setting[34]->required == 1){ echo 'required';} ?>>
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                    <option value="1">><?=lang('French language')?> </option>
                    <option value="2"> <?=lang('German language')?> </option>
                </select>
            </div>
        </div>
        <?php } ?>
        
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/load.css">
        <div class="loading_div" id="loadingDiv" ></div>
        <!--<div class="clearfix"></div>-->
        
        <?php if($setting[35]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_last_Degree')?> <?php if($setting[35]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input data-value="<?=$addStudentValue?>" name="uploadFile[<?=$addStudentValue?>]" type="file" id="uploadFile<?=$addStudentValue?>" onchange="upload_file($(this))" accept="image/*" class="form-control" style="padding-top:5px "<?php if($setting[35]->required == 1){ echo 'required';} ?>>
                <input type="hidden" name="img_name[<?=$addStudentValue?>]" id="img_name<?=$addStudentValue?>" >
            </div>
            <div class="col-xs-12 p-0" style="font-size: 11px;margin-top: 6px;font-weight: bold;">
                <span class="fa fa-file-text"></span> <?=lang('am_last_Degree_note')?>
            </div>
        </div>
        <?php } ?>
        
        <?php if($setting[36]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_last_school')?><?php if($setting[36]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="exSchool"  name="exSchool[<?=$addStudentValue?>]" value="<?=set_value('exSchool[]'); ?>" class="form-control" <?php if($setting[36]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <?php if($setting[37]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('br_notes')?> <?php if($setting[37]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="note" name="note[<?=$addStudentValue?>]"  class="form-control" <?php if($setting[37]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <!--<div class="clearfix"></div>-->
        
        
        <?php if($setting[38]->display == 1){ ?>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12">  <?=lang('birth_certificate')?> <?php if($setting[38]->required == 1){ echo '<span class="danger">*</span>';} ?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input data-value="<?=$addStudentValue?>" name="st_birth_certificate[<?=$addStudentValue?>]" type="file" id="st_birth_certificate<?=$addStudentValue?>" onchange="upload_file2($(this),'birth_certificate<?=$addStudentValue?>')" accept="image/*" class="form-control" style="padding-top:5px !important"  <?php if($setting[38]->required == 1){ echo 'required';} ?>>
                <input type="hidden" name="birth_certificate[<?=$addStudentValue?>]" id="birth_certificate<?=$addStudentValue?>" <?php if($setting[38]->required == 1){ echo 'required';} ?>>
            </div>
        </div>
        <?php } ?>
        
        <?php $data['get_row_level']=$this->student_register_model->get_row_level(); ?>
        <!--<div class="clearfix"></div>-->
        
        <?php if($setting[39]->display == 1){ ?>
        <div class="col-xs-12 p-0">
            <div id="load_student_data1"><?=$this->load->view('home/Student_Register_brothers',$data)?></div>
            <a href="javascript:void(0)" id="load_student_data1" class="btn btn-danger addbro btn_regist_Add"><?=lang('na_add_bro')?></a>
        </div>
        <?php } ?>
        
        <!--<div class="clearfix"></div>-->
        <!--<div class="col-xs-12 title_register mt-20">-->
        <!--    <h5><i class="fa fa-bus" aria-hidden="true"></i> <?=lang('bus_serv')?>  </h5>-->
        <!--</div>-->
        <!--<div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content ">-->
        <!--    <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 11px;padding: 5px;"> <?=lang('am_want_transport')?> </label>-->
        <!--    <div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
        <!--        <div class="form-control" style="display: flex;align-items: center;">-->
        <!--            <input type="radio" onclick="checkTransport($(this))" name="want_transport" value="1" style="width:auto;margin-top: 0;margin-left: 10px;" checked> <?=lang('am_transport_no')?>-->
        <!--            <input type="radio" onclick="checkTransport($(this))" name="want_transport" value="2" style="width:auto;margin-right: 60px;margin-top: 0;margin-left: 10px;"> <?=lang('am_transport_yes')?>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content ">-->
        <!--    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('am_transport_address')?> </label>-->
        <!--    <div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
        <!--        <input type="text" id="transport_address" name="transport_address" class="form-control" disabled>-->
        <!--    </div>-->
        <!--</div>-->
                                <!--<div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content ">-->
                                <!--    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_transport_type')?> </label>-->
                                <!--    <div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
                                <!--        <select class="form-control" id="transport_type" name="transport_type" disabled>-->
                                <!--            <option value=""><?=lang('am_transport_type_select')?></option>-->
                                <!--            <option value="1"><?=lang('am_transport_type1')?></option>-->
                                <!--            <option value="2"><?=lang('am_transport_type2')?></option>-->
                                <!--            <option value="3"><?=lang('am_transport_type3')?></option>-->
                                <!--        </select>-->
                                <!--    </div>-->
                                <!--</div>-->

    </div>
</div>

<input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname ;?>">

<script type="text/javascript">
    function checkLnagLast(val) {
        if (val == 1) {
            var array = ['parent_name', 'parent_name_eng', 'mother_name'];
            var lang  = ['ar', 'en', 'ar'];
            for (var i = 0; i < array.length; i++) {
                var input = $('#'+array[i]);
                var check = checkLnag(input, lang[i]);
                if (check == false) {
                    return false;
                }
            }
        }
        if (val == 2) {
            var array = ['name', 'frist_name_eng'];
            var lang  = ['ar', 'en'];
            for (var i = 0; i < array.length; i++) {
                var input = $('input[name^="'+array[i]+'"]');
                input.each(function(){
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
    function checkLnag(input, lang) {
        var userInput = input.val();
        
        if (lang == 'ar') {
            let regex = /^[؀-ۿ ]+$/;
            if (!userInput.match(regex)) {
               // alert("Only use Arabic characters!");
                input.val('');
            }
        } else {
            let regex = /[\u0600-\u06FF\u0750-\u077F^0-9]/;
            if (userInput.match(regex)) {
              //  alert("Only use English characters!");
                input.val('');
            }
        }
    }

</script>
<script type="text/javascript">
    var addStudentValue = 1;
    $(".addbro").click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?php echo site_url();?>' + '/home/student_register/add_stu_bro/' + addStudentValue,
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
                var element = $('#schoolID' + '<?=$addStudentValue?>');
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
     $('select[name^="studeType"]').on('change', function() {
        var index = $(this).attr('data-value');
        var studeType = $(this).val();
        var DbName = $('#DbName').val();
        if (studeType) {
           $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/Schools/'+DbName+'/GetSchoolsByStudyType',
                type: "GET",
                data: {studyTypeId:studeType},
                dataType: "json",
                success: function(data) {
                    var element = $('#schoolID' + index);
                    element.empty();
                    element.append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.SchoolId + '">' + value.SchoolName + '</option>');
                    });
                }
            });

        }
        else {
            var element = $('#schoolID' + index);
            element.empty();
            element.append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
            var element = $('#YearId' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#schoolID' + index).trigger('change');
        $('#levelID' + index).trigger('change');
    });

</script>

<script type="text/javascript">
    $('select[name^="school"]').on('change', function() {
        var index = $(this).attr('data-value');
        var schoolID = $('#schoolID' + index).val();
        var DbName = $('#DbName').val();
        if(schoolID) {
            
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/'+DbName+'/GetClassesBySchool',
                type: "GET",
                data: {schoolId:schoolID},
                dataType: 'json',
                success: function(data) {
                    var element = $('#classID' + index);
                    element.empty();
                    element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        
                        element.append('<option value="' + value.ClassId + '">' + value.ClassName + '</option>');
                    
                    });
                }
            });
   $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/Years/'+DbName+'/GetOpenedYearsBySchoolId',
                type: "GET",
                data: {schoolId:schoolID},
                dataType: 'json',
                success: function(data) {
                    var element = $('#YearId' + index);
                    element.empty();
                    element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        if(value.IsNextYear===true){
                        element.append('<option value="' + value.YearId + '">' + value.YearName + '</option>');
                        }
                    });
                }
            });
            
    }
    else {
            var element = $('#schoolID' + index);
            element.empty();
            element.append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
            var element = $('#YearId' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
            </script>

<script type="text/javascript">
   $('select[name^="school"]').on('change', function() {
        var index = $(this).attr('data-value');
        var studeType =$('#studeType' + index).val();
        var schoolID = $('#schoolID' + index).val();
        var ClassTypeName = $('#ClassTypeName').val();
        var DbName = $('#DbName').val();
        if(schoolID && studeType !="") {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/'+DbName+'/GetLevelsBySchool',
                type: "GET",
                data: {schoolId:schoolID ,studyTypeId:studeType ,genderId:ClassTypeName},
                dataType: "json",
                success: function(data) {
                    var element = $('#levelID' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.LevelId + '">' + value.LevelName + '</option>');
                        
                    });
                }
            });
        }
        else {
            var element = $('#levelID' + index);
            element.empty();
            element.append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#levelID' + index).trigger('change');
    });

</script>

<script type="text/javascript">
    $('select[name^="level"]').on('change', function() {
        var index = $(this).attr('data-value');
        var levelID = $(this).val();
        var schoolID = $('#schoolID' + index).val();
        var studeType =$('#studeType' + index).val();
        var ClassTypeName = $('#ClassTypeName'+ index).val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/'+DbName+'/GetRowsByLevel',
                type: "GET",
                 data: {schoolId:schoolID ,levelId:levelID,studyTypeId:studeType,genderId:ClassTypeName},
                dataType: "json",
                success: function(data) {
                    var element = $('#rowID' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        if(value.RowName != 104 && value.RowId != 375 && value.RowId != 376 && value.RowId != 104 && value.RowId!= 98){
                        element.append('<option value="' + value.RowId + '">' + value.RowName+ '</option>');
                        }
                    });
                }
            });
        }
        else {
            var element = $('#rowID' + index);
            element.empty();
            element.append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
        }
        if(levelID==56 || levelID==145 || levelID==146 || levelID==147)
        
            {
                
                $('#father_data').show();
    
            }else{
                
                $('#father_data').hide();  
            }
        if(levelID==58)
        {

			$('#mobile_data').show();

        }else{
            
            $('#mobile_data').hide();
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
            url: '<?=site_url('home/student_register/do_upload')?>',
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
    var loadedDataValidation = {
        rules: {
            'name': {
                
                minlength: 3,
                maxlength: 50,
                messages: {
                    required: "<?=lang('This field is required')?>",
                    minlength: "<?=lang('Please enter at least 3 characters')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
            },
            'frist_name_eng': {
                
                minlength: 3,
                maxlength: 50,
                messages: {
                    required: "<?=lang('This field is required')?>",
                    minlength: "<?=lang('Please enter at least 3 characters')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
            },
            'student_NumberID': {
                
                number: true,
                maxlength: 14,
                messages: {
                    required: "<?=lang('This field is required')?>",
                    number: "<?=lang('Please enter a valid number')?>",
                    maxlength: "<?=lang('Please enter no more than 14 characters')?>"
                },
            },
            'student_region': {
                maxlength: 255,
                messages: {
                    maxlength: "<?=lang('Please enter no more than 255 characters')?>"
                },
            },
            'birthplace': {
                
                maxlength: 50,
                messages: {
                    required: "<?=lang('This field is required')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
            },
            'studeType': {
                
                messages: {
                    required: "<?=lang('This field is required')?>",
                   
                },
            },
            'school': {  
                // 'required': true, 
                messages: {
                    required: "<?=lang('This field is required')?>",  
                },
            },
            'level': {
                
                messages: {
                    required: "<?=lang('This field is required')?>",  
                },
            },
            'rowID': {
                
                messages: {
                    required: "<?=lang('This field is required')?>",  
                },
            },
             'language': {
                
                messages: {
                    required: "<?=lang('This field is required')?>",  
                },
            },
            'gender': {
                
                messages: {
                    required: "<?=lang('This field is required')?>",  
                },
            },
            'YearId': {
                
                messages: {
                    required: "<?=lang('This field is required')?>",  
                },
            },
        //  'uploadFile': {
        //       
        //          messages: {
        //           required: "<?=lang('This field is required')?>",  
        //         },
        //     },
        }
    };
    
    addRules2(loadedDataValidation, "<?=$addStudentValue?>");

    function addRules2(rulesObj, idVal){
        for (var item in rulesObj.rules){
            var res = item;
            if (item == 'school') {
                res = 'schoolID';
            }
            if (item == 'level') {
                res = 'levelID';
            }
            $('#'+res+idVal).rules('add',rulesObj.rules[item]);  
        } 
    }
</script>
<script type ="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
<script type="text/javascript">
            $(document).ready(function () {
                $(".datepicker").click(function() {
                    $('.datepicker').hide();
                });
                $('#birthdate').datepicker({
                    format: "yyyy-mm-dd"
                });

				   
            });
</script>

<!--<script> -->
<!--        $('input').blur(function() {-->
<!--        if ($('#student_NumberID').attr('value') == $('#ParentNumberID').attr('value')) {-->
<!--        alert('Same Value');-->
<!--        return false;-->
<!--        } else { return true; }-->
<!--        });-->
<!--</script>-->
 