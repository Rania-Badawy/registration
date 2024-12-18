<?php include('header.php'); ?> 



<?php //print_r($get_levels);die;  ?>
<div style="color:red" id="recaptchaMsg"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<?php $setting = $this->db->query("SELECT * FROM `form_setting`")->result(); ?>
<style>
.hedddin{display:none;}
    body {
        margin: 20px 0;
        font-family: 'Lato';
        font-weight: 300;
        font-size: 1.25rem;
    }

    .datepicker-days {
        width: 300px;
    }

    .datepicker.dropdown-menu {
        width: 300px !important;
        margin-top: 19px;
    }

    .table-condensed {
        width: 100%;
    }

    form,
    p {
        margin: 20px;
    }

    p.note {
        font-size: 1rem;
        color: red;
    }

    input,
    textarea {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 4px;
        font-family: 'Lato';
        width: 300px;
        margin-top: 10px;
    }

    label {
        width: 300px;
        font-weight: bold;
        display: inline-block;
        margin-top: 20px;
    }

    label span {
        font-size: 1rem;
    }

    label.error {
        color: red;
        font-size: 1rem;
        display: block;
        margin-top: 5px;
        position: absolute;
    }

    input.error,
    textarea.error {
        border: 1px dashed red;
        font-weight: 300;
        color: red;
    }

    [type="submit"],
    [type="reset"],
    button,
    html [type="button"] {
        margin-left: 0;
        border-radius: 0;
        background: black;
        color: white;
        border: none;
        font-weight: 300;
        padding: 10px 0;
        line-height: 1;
    }
<?php if($setting[43]->display == 1){?>
    .nav-tabs>li {
        width: 25%;
    }
<?php } ?> 
    @media(max-width:992px) {
        .nav-tabs>li {
            width: 50%;
        }
    }
    @media(max-width:600px) {
        .nav-tabs>li {
            width: 100%;
        }
        .nav-tabs.nav-tabs-ddds {
            height: 100px;
            overflow: hidden;
        }
    }

    .top-bar,
    .nav-bar,
    footer {
        display: none;
    }

    .tab-content span.danger {
        color: red;
    }

    .tab-content .btn-primary,
    .tab-content .btn-primary:active,
    .tab-content .btn-primary:hover,
    .tab-content .btn-primary:focus,
    .tab-content .btn-primary:hover:focus {
        color: #fff;
        background-color: #1f64a4;
        border-color: #1f64a4;
    }

    .tab-content .btn-danger,
    .tab-content .btn-danger:active,
    .tab-content .btn-danger:hover,
    .tab-content .btn-danger:focus,
    .tab-content .btn-danger:hover:focus {
        color: #fff;
        background-color: #a9122a;
        border-color: #a9122a;
    }

    .nav-tabs.nav-tabs-ddds>li a {
        padding: 5px 0;
        width: 100%;
        height: 70px;
        margin: 20px auto;
        border-radius: 0;
        text-align: center;
        line-height: 70px;
        border: 0;
        color: #333 !important;
    }

    .nav-tabs.nav-tabs-ddds>li {
        float: right;
    }

    .nav-tabs.nav-tabs-ddds>li.active {
        background-color: #a9122a !important;
    }

    .nav-tabs.nav-tabs-ddds>li.active a {
        color: #fff !important;
        background-color: transparent !important;
    }

    .nav-tabs.nav-tabs-ddds {
        border: 1px solid #ddd;
        padding: 0px;
    }

    .nav-tabs li.active:after {
        border-bottom-color: #fff !important;
    }

</style>
<?php $query=$this->db->query("select * from setting")->row_array(); ?>
<div class="container container-dd">
    <div class="row">
        <div class="col-md-12 text-left" >
            <?php if($query['homeLink']){ ?>
            <a class="btn btn-danger btn-st btn-st" href="<?php echo $query['homeLink'] ?>" target="_blank"><?php echo lang('am_home');?> </a>
            <?php }else{?>
            <a class="btn btn-danger btn-st btn-st" href="<?= site_url(); ?>"><?php echo lang('am_home');?> </a>
            <?php } ?>
            <a class="btn btn-danger btn-st btn-st" href="<?= base_url() ?>home/student_register/check_code"><?php echo lang('am_new_student_Check_Code');?></a>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
		    <img src="<?= base_url() ?>intro/images/school_logo/<?php echo $query['Logo']?>" class="mt-20" width="120"/>
            <h3 style="margin-bottom: 35px;"><?= lang('am_RegistrationForm') ?></h3>
        </div>
    </div>
        <ul class="nav nav-tabs nav-tabs-ddds">
            <!--<li class="active">-->
            <!--    <a href="#tab1" data-toggle="tab">-->
            <!--        <h4 class="list-group-item-heading btnNext"><?=lang('am_frist_stap')?></h4>-->
            <!--        <p class="list-group-item-text">  معلومات الكورسات</p>-->
            <!--    </a>-->
            <!--</li>-->
            <li class="active">
                <a href="#tab1" data-toggle="tab">
                    <h4 class="list-group-item-heading btnNext"><?=lang('am_frist_stap');?></h4>
                    <p class="list-group-item-text">بيانات المتقدم/ة</p>

                </a>
            </li>
            <?php if($setting[43]->display == 1){ ?>
            <li >
                <a href="#tab4" data-toggle="tab">
                    <h4 class="list-group-item-heading btnNext"><?=lang('am_third_step');?></h4>
                    <p class="list-group-item-text"> <?=lang('am_student_psy');?> </p>

                </a>
            </li>
            <?php } ?>
            <li >
                <a href="#tab3" data-toggle="tab">
                    <h4 class="list-group-item-heading btnNext"><?php if($setting[44]->display == 0){ echo lang('am_frist_second'); }else{ echo lang('am_frist_second');}?></h4>
                    <p class="list-group-item-text"> <?=lang('am_Registration');?> </p>

                </a>
            </li>
        </ul>
        <div class="alert alert-success">
         يتم ارسال خطة الدراسة في الكورس بعد التسجيل للمزيد من المعلومات والاستفسارات عن طريق ارقام التواصل
         01100968700 -- 01100968305  
        </div>
        <?php if($this->session->flashdata('ErrorAdd')){ ?>
        <div class="alert alert-danger">
            <?php 
        echo $this->session->flashdata('ErrorAdd'); ?>
        </div>
        <?php } else if($this->session->flashdata('SuccessAdd')){ ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('SuccessAdd'); ?>
        </div>
        <?php } ?>

        <form action="<?=site_url('home/student_register/NewRegister');?>" method="post" id="registration-form" onsubmit="return validation_speed();" style="margin:25px 10px">
            <div class="tab-content">
                <!--    Tab1    -->
                <!--<div class="tab-pane active" id="tab1">-->
                <!--    <div class="col-xs-12 p-0">-->
                <!--        <div class="col-md-12 mt-20 p-0">-->
                <!--            <div class="panel panel-default panel_regist_all">-->
                <!--                <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                <!--                    <div class="card-header" id="headingTwo">-->
                <!--                        <h4 class="panel-title mb-0">-->
                <!--                        <div class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">-->
                <!--                            برنامج المبرمح الصغير -->
                <!--                        </div>-->
                <!--                        </h4>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div id="" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">-->
                <!--                  <div class="card-body">-->
                <!--                      <img src="<?= base_url() ?>/upload/9.jpg" width="100%">-->
                <!--                  </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                    
                <!--    <div class="col-xs-12 p-0">-->
                <!--        <div class="col-md-12 mt-20 p-0">-->
                <!--            <div class="panel panel-default panel_regist_all">-->
                <!--                <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                <!--                    <div class="card-header" id="headingTwo">-->
                <!--                        <h4 class="panel-title mb-0">-->
                <!--                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">-->
                <!--                            web design course -- دورة تصميم الويب-->
                <!--                        </button>-->
                <!--                        </h4>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div id="collapseSeven" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">-->
                <!--                  <div class="card-body">-->
                <!--                      <img src="<?= base_url() ?>/upload/Web Design.jpg" width="100%"> -->
                <!--                  </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                    
                <!--    <div class="col-xs-12 p-0">-->
                <!--        <div class="col-md-12 mt-20 p-0">-->
                <!--            <div class="panel panel-default panel_regist_all">-->
                <!--                <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                <!--                    <div class="card-header" id="headingTwo">-->
                <!--                        <h4 class="panel-title mb-0">-->
                <!--                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">-->
                <!--                            mobile applications -- تطبيقات الهاتف الجوال-->
                <!--                        </button>-->
                <!--                        </h4>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">-->
                <!--                  <div class="card-body">-->
                <!--                      <img src="<?= base_url() ?>/upload/mobile apps.jpg" width="100%"> -->
                <!--                  </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                    
                    <!--<div class="col-xs-12 p-0">-->
                    <!--    <div class="col-md-12 mt-20 p-0">-->
                    <!--        <div class="panel panel-default panel_regist_all">-->
                    <!--            <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                    <!--                <div class="card-header" id="headingTwo">-->
                    <!--                    <h4 class="panel-title mb-0">-->
                    <!--                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">-->
                    <!--                        robotics -- علم الروبوتات-->
                    <!--                    </button>-->
                    <!--                    </h4>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">-->
                    <!--              <div class="card-body">-->
                    <!--                  <img src="<?= base_url() ?>/upload/robotics.jpg" width="100%"> -->
                    <!--              </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <!--<div class="col-xs-12 p-0">-->
                    <!--    <div class="col-md-12 mt-20 p-0">-->
                    <!--        <div class="panel panel-default panel_regist_all">-->
                    <!--            <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                    <!--                <div class="card-header" id="headingTwo">-->
                    <!--                    <h4 class="panel-title mb-0">-->
                    <!--                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">-->
                    <!--                        Databases -- قواعد البيانات-->
                    <!--                    </button>-->
                    <!--                    </h4>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--            <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">-->
                    <!--              <div class="card-body">-->
                    <!--                  <img src="<?= base_url() ?>/upload/Databases.jpg" width="100%"> -->
                    <!--              </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <!--<div class="col-xs-12 p-0">-->
                    <!--    <div class="col-md-12 mt-20 p-0">-->
                    <!--        <div class="panel panel-default panel_regist_all">-->
                    <!--            <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                    <!--                <div class="card-header" id="headingTwo">-->
                    <!--                    <h4 class="panel-title mb-0">-->
                    <!--                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">-->
                    <!--                        c# -- لغة برمجة-->
                    <!--                    </button>-->
                    <!--                    </h4>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--            <div id="collapseFive" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">-->
                    <!--              <div class="card-body">-->
                    <!--                  <img src="<?= base_url() ?>/upload/c#.jpg" width="100%"> -->
                    <!--              </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <!--<div class="col-xs-12 p-0">-->
                    <!--    <div class="col-md-12 mt-20 p-0">-->
                    <!--        <div class="panel panel-default panel_regist_all">-->
                    <!--            <div class="panel-heading panel-regist card" role="tab" id="heading3">-->
                    <!--                <div class="card-header" id="headingTwo">-->
                    <!--                    <h4 class="panel-title mb-0">-->
                    <!--                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">-->
                    <!--                        PHP -- لغة برمجة-->
                    <!--                    </button>-->
                    <!--                    </h4>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--            <div id="collapseSix" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">-->
                    <!--              <div class="card-body">-->
                    <!--                  <img src="<?= base_url() ?>/upload/PHP.jpg" width="100%"> -->
                    <!--              </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
 
                <!--    <div class="col-md-12 text-left mt-20 p-0">-->
                <!--        <a class="btn btn-primary btnNext btn_regist"> <?=lang('am_Next')?></a>-->
                <!--    </div>-->
                <!--</div> -->
                <!--    Tab2    -->
                <div class="tab-pane active" id="tab1">
                    <div class="col-xs-12 p-0">
                        
                    </div>
                    <div class="col-xs-12 p-0">
                        <div id="load_student_data"><?=$this->load->view('home/Student_Register_Form_LoadDataNew')?></div>
                        <?php 
                        // if($this->load->view['levelID'] == 58){ 
                        ?>
                    <div id="father_data" style="display:none;">
                        <div class="row">
                                <div class="col-xs-12 title_register">
                                    <h5><i class="fa fa-user" aria-hidden="true"></i><?=lang('am_father_data')?></h5>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_father_name_quadrilateral');?><span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_name" name="parent_name" value="<?=set_value('parent_name'); ?>" onkeyup="checkLnag($(this), 'ar');" maxlength="50" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_ID_Number')?><span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="ParentNumberID" name="ParentNumberID" value="<?=set_value('ParentNumberID'); ?>" onkeypress="return onlyNumberKey(event)" maxlength="14" minlength="10" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_Nationality')?> </label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="parent_national_ID" name="parent_national_ID" class="form-control" required>
                                            <option value=""><?=lang('am_select')?></option>
                                            <?php foreach($get_nationality as $item ){ ?>
                                            <option value="<?=$item->NationalityId;?>" <?php echo set_select('parent_national_ID',$item->NationalityName, ( !empty($data) && $data == $item->NationalityName ? TRUE : FALSE )); ?>><?=$item->NationalityName;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('na_mobile')?> <span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" onkeypress="return onlyNumberKey(event)" id="parent_mobile" name="parent_mobile" value="<?=set_value('parent_mobile'); ?>" maxlength="14" minlength="10" class="form-control" required>
                                    </div>
                                </div>
                                <?php if($setting[3]->display == 1){ ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_mail')?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_email" name="parent_email" value="<?=set_value('parent_email'); ?>" maxlength="50" class="form-control" required>
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                        <?php  
                        // }else{
                        ?>
                        <div id="mobile_data" style="display:none;">
                            <div class="row">
                                <?php if($setting[7]->display ==  1){ ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> رقم الطالب <?php if($setting[7]->required ==  1){ echo '<span class="danger">*</span>' ;} ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" onkeypress="return onlyNumberKey(event)" id="parent_mobile2" name="parent_mobile2" value="<?=set_value('parent_mobile2'); ?>" maxlength="14" minlength="10" class="form-control" <?php if($setting[7]->required ==  1){ echo 'required';} ?>>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if($setting[3]->display == 1){ ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_mail')?><?php if($setting[3]->required == 1){ echo '<span class="danger">*</span>' ;} ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_email" name="parent_email" value="<?=set_value('parent_email'); ?>" maxlength="50" class="form-control" required>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php 
                        // }
                        ?>
                        <div class="col-md-12 text-left mt-20 p-0">
                            <!--<a href="javascript:void(0)" class="btn btn-warning addStudent btn_regist_Add"><?=lang('am_add_student')?></a>-->
                            <a class="btn btn-danger btnPrevious btn_regist_Previous"><?=lang('am_previous')?></a>
                            <a class="btn btn-primary btnNext btn_regist"> <?=lang('am_Next')?> </a>
                        </div>
                    </div>
                </div>
                <!--    Tab3    -->
                <div class="tab-pane" id="tab4">
                    <div class="col-xs-12 p-0">
                        <div id="load_student_psy"><?=$this->load->view('home/Student_Register_Form_Psy')?></div>
                        <div class="col-md-12 text-left mt-20 p-0">
                            <a class="btn btn-danger btnPrevious btn_regist_Previous"><?=lang('am_previous')?></a>
                            <a class="btn btn-primary btnNext btn_regist"> <?=lang('am_Next')?></a>
                        </div>
                        <!--<div class="col-md-12 text-left mt-20 p-0">-->
                        <!--    <a class="btn btn-danger btnPrevious btn_regist_Previous"><?=lang('am_previous')?></a>-->
                        <!--    <input type="submit" id="save" class="btn btn-primary btn_regist" value="<?=lang('am_save')?>" style="width:auto;margin:0">-->
                        <!--</div>-->
                    </div>
                </div>
                <!--    Tab4    -->
                <div class="tab-pane" id="tab3">
                    <div class="col-xs-12 p-0">
                        <div class="col-md-12 p-0">
                            <div class="row">
                                <p class="text-justify" style="line-height: 50px;font-size: 20px;"> اقر انا المتقدم/ة بان كل البيانات التي سبق ادخالها صحيحه وفى حاله وجود خطأ فى اى منها يعتبر التسجيل لاغي </p>
                                <div class="clearfix"></div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content mt-20">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('am_Signature')?> <span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="Signature" name="Signature" value="<?=set_value('Signature'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-12 text-left mt-20 p-0">
                            <a class="btn btn-danger btnPrevious btn_regist_Previous"><?=lang('am_previous')?></a>
                            <input type="submit" id="save" class="btn btn-primary btn_regist" value="<?=lang('am_save')?>" style="width:auto;margin:0" >
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var img = null;
    function upload_file2(fileInput, name) {
        var fd = new FormData();
        var files = fileInput[0].files[0]; 
        fd.append('userfile', files);
        $.ajax({
            url: '<?=site_url('home/student_register/do_upload')?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == 1) {
                    img = response.img;
                    $('#' + name).val(img);
                } else {
                    alert(response.msg);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    var addStudentValue = 1;
    $(".addStudent").click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?php echo site_url();?>' + '/home/student_register/getStudentView/' + addStudentValue,
            type: "get",
            dataType: "html",
            success: function(data) {
                $('#load_student_data').append(data);
                addStudentValue++;
            }
        });
    });

    function addStudentPsy() {
        $.ajax({
            url: '<?php echo site_url();?>' + '/home/student_register/getStudentPsy/' + (addStudentValue),
            type: "get",
            dataType: "html",
            success: function(data) {
                $('#load_student_psy').append(data);
            }
        });
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

<script>
    $(document).ready(function() {
        $('#person_name').keyup(function(e) {
            var txtVal = $(this).val();
            $('#Signature').attr("value", txtVal);
        });
        $('#parent_name').keyup(function(e) {
            var txtVal = $(this).val();
            $('#person_name').attr("value", txtVal);
            $('#Signature').attr("value", txtVal);
        });
          
         $('select[name^="level"]').on('change', function() {
              var index = $(this).attr('data-value');
            var txtVal = $(this).val();
             var name = $('#name'+ index).val();
            if(txtVal==58){
                $('#Signature').attr("value", name);
            }
            
        });
        $('#ParentNumberID').keyup(function(e) {
            var txtVal = $(this).val();
            $('#person_NumberID').attr("value", txtVal);
        });
        $('#parent_mobile').keyup(function(e) {
            var txtVal = $(this).val();
            $('#person_mobile').attr("value", txtVal);
        });
    });

    var transportRules = {
        transport_address : {
            required: true,
        },
        transport_type : {
            required: true,
        }
    };


    $('.btnNext').click(function() {
        var form = $("#registration-form");
        form.validate({
            rules: {
                // parent_name: {
                    
                //     minlength: 3,
                //     maxlength: 50
                // },
                // parent_name_eng: {
                    
                //     minlength: 3,
                //     maxlength: 50
                // },
                // ParentNumberID: {
                    
                //     number: true,
                //     maxlength: 14,
                // },
                parent_type_Identity: {
                    maxlength: 250,
                },
                parent_source_identity: {
                    maxlength: 50,
                },
                parent_email: {
                    //
                    email: true,
                    maxlength: 50,
                },
                'parent_educational_qualification': {
                    
                    maxlength: 255,
                },
                'mother_educational_qualification' : {
                    
                    
                },
                parent_national_ID: {
                    
                    maxlength: 255
                },
                parent_mobile: {
                    
                    number: true,
                    // maxlength: 20
                },
                parent_mobile2: {
                    number: true,
                    number: true,
                    // maxlength: 20
                },
                parent_phone: {
                    number: true,
                    number: true,
                    // maxlength: 20
                },
                parent_access_station: {
                    maxlength: 255
                },
                parent_house_number: {
                    maxlength: 11
                },
                parent_region: {
                    maxlength: 255
                },
                parent_profession: {
                    maxlength: 50
                },
                parent_profession_mather: {
                    
                    maxlength: 50
                },
                mother_work: {
                    
                    maxlength: 50
                },
                parent_work_address: {
                    maxlength: 50
                },
                parent_phone2: {
                    number: true,
                    number: true,
                    // maxlength: 20
                },
                person_name: {
                    maxlength: 50
                },
                person_NumberID: {
                    number: true,
                    maxlength: 15
                },
                person_mobile: {
                    number: true,
                    maxlength: 20
                },
                school_staff: {
                    number: true,
                    maxlength: 4
                },
                'name[]': {
                    
                    minlength: 3,
                    maxlength: 50
                },
                'frist_name_eng[]': {
                    
                    minlength: 3,
                    maxlength: 50
                },
                how_school: {
                    
                },
                'student_NumberID[]': {
                    
                    number: true,
                    maxlength: 15
                },
                'student_region[]': {
                    
                    maxlength: 255
                },
                gender: {
                    
                    number: true,
                    maxlength: 1
                },
                'birthplace[]': {
                    
                    maxlength: 50
                },
               /* 'studeType[]': {
                    
                  
                },*/
                // "parent_profession": "required",
                // "parent_profession_mather": "required",
                // "mother_work":"required",
                // "studeType[]": "required",
                // "school[]": "required",
                // "mother_educational_qualification" : "required",
                /*'school[]': {  
                  'required': true, 
                  //number: true,  
                },*/
                // "level[]": "required",
                // "rowID[]": "required",
                // "YearId[]": "required",
                // "uploadFile[]": "required",
                //  "birthdate[]": "required",
                //  "exSchool[]": "required",
               /* 'level[]': {
                    
                    //number: true,  
                },*/
               /* 'rowLevelID[]': {
                    
                    //number: true,  
                },*/
                /*exSchool: {  
                    
                  maxlength: 50
                }, */
                /*note: {   
                  maxlength: 50
                },*/
                Signature: {
                    maxlength: 500
                },
                file: {
                    
                    minlength: 1,
                    extension: "png |gif | jpg | png | jpeg | pdf"
                },
                'img_name[]': {
                   // 
                    minlength: 1,
                },
                mother_name : {
                    // required: true
                  },
                  mother_email : {
                    // email: true
                  },
                  mother_mobile: { 
                    
                    // number: true
                  },
            },
            messages: {
                // parent_name: {
                //     required: "<?=lang('This field is required')?>",
                //     minlength: "<?=lang('Please enter at least 3 characters')?>",
                //     maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                // },
                // parent_name_eng: {
                //     required: "<?=lang('This field is required')?>",
                //     minlength: "<?=lang('Please enter at least 3 characters')?>",
                //     maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                // },
                // ParentNumberID: {
                //     required: "<?=lang('This field is required')?>",
                //     number: "<?=lang('Please enter a valid number')?>",
                //     maxlength: "<?=lang('Please enter no more than 14 characters')?>"
                // },
                parent_type_Identity: {
                    maxlength: "<?=lang('Please enter no more than 250 characters')?>"
                },
                parent_source_identity: {
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                parent_email: {
                   // required: "<?=lang('This field is required')?>",
                    email: "<?=lang('Please enter a valid email')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                // parent_educational_qualification: {
                //     required: "<?=lang('This field is required')?>",
                //     maxlength: "<?=lang('Please enter no more than 255 characters')?>"
                // },
                // mother_educational_qualification :  {
                //     required: "<?=lang('This field is required')?>",
                //     maxlength: "<?=lang('Please enter no more than 255 characters')?>"
                // },
                // parent_national_ID: {
                //     required: "<?=lang('This field is required')?>",
                //     maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                // },
                // parent_mobile: {
                //     required: "<?=lang('This field is required')?>",
                //     number: "<?=lang('Please enter a valid number')?>",
                //     // maxlength: "<?=lang('Please enter no more than 20 characters')?>"
                // },
                // parent_mobile2: {
                //     required: "<?=lang('This field is required')?>",
                //     number: "<?=lang('Please enter a valid number')?>",
                //     // maxlength: "<?=lang('Please enter no more than 20 characters')?>"
                // },
                // parent_phone: {
                //     required: "<?=lang('This field is required')?>",
                //     number: "<?=lang('Please enter a valid number')?>",
                //     // maxlength: "<?=lang('Please enter no more than 20 characters')?>"
                // },
                parent_access_station: {
                    maxlength: "<?=lang('Please enter no more than 255 characters')?>"
                },
                parent_house_number: {
                    maxlength: "<?=lang('Please enter no more than 10 characters')?>"
                },
                parent_region: {
                    maxlength: "<?=lang('Please enter no more than 255 characters')?>"
                },
                parent_profession: {
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                parent_profession_mather: {
                    // required: "<?=lang('This field is required')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                mother_work: {
                    // required: "<?=lang('This field is required')?>",
                    maxlength: "<?=lang('Please enter no more than 100 characters')?>"
                },
                parent_work_address: {
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                parent_phone2: {
                    required: "<?=lang('This field is required')?>",
                    number: "<?=lang('Please enter a valid number')?>",
                    // maxlength: "<?=lang('Please enter no more than 20 characters')?>"
                },
                person_name: {
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                person_NumberID: {
                    number: "<?=lang('Please enter a valid number')?>",
                    maxlength: "<?=lang('Please enter no more than 14 characters')?>"
                },
                person_mobile: {
                    number: "<?=lang('Please enter a valid number')?>",
                    maxlength: "<?=lang('Please enter no more than 20 characters')?>"
                },
                school_staff: {
                    number: "<?=lang('Please enter a valid number')?>",
                    maxlength: "<?=lang('Please enter no more than 4 characters')?>"
                },
                'name[]': {
                    required: "<?=lang('This field is required')?>",
                    minlength: "<?=lang('Please enter at least 3 characters')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                'frist_name_eng[]': {
                    // required: "<?=lang('This field is required')?>",
                    minlength: "<?=lang('Please enter at least 3 characters')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                how_school: {
                    required: "<?=lang('This field is required')?>",
                },
                'student_NumberID[]': {
                    required: "<?=lang('This field is required')?>",
                    number: "<?=lang('Please enter a valid number')?>",
                    maxlength: "<?=lang('Please enter no more than 14 characters')?>"
                },
                'mother_educational_qualification': {
                    required: "<?=lang('This field is required')?>",
                },
                'student_region[]': {
                    required: "<?=lang('This field is required')?>",
                    maxlength: "<?=lang('Please enter no more than 255 characters')?>"
                },
                gender: {
                    required: "<?=lang('This field is required')?>",
                    number: "<?=lang('Please enter a valid number')?>",
                    maxlength: "<?=lang('Please enter no more than 1 characters')?>"
                },
                'birthplace[]': {
                    required: "<?=lang('This field is required')?>",
                    maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                },
                
                'studeType[]': {
                    required: "<?=lang('This field is required')?>",
                },
                "school[]": "<?=lang('This field is required')?>",
                /*'school[]': {
                  required: "<?=lang('This field is required')?>", 
                  //number: "<?=lang('Please enter a valid number')?>",  
                },*/
                "parent_profession": "<?=lang('This field is required')?>",
                "parent_profession_mather": "<?=lang('This field is required')?>",
                "level[]": "<?=lang('This field is required')?>",
                "rowID[]": "<?=lang('This field is required')?>",
                "YearId[]": "<?=lang('This field is required')?>",
               // "uploadFile[]": "<?=lang('This field is required')?>",
                "birthdate[]": "<?=lang('This field is required')?>",
                "exSchool[]": "<?=lang('This field is required')?>",
                 "mother_educational_qualification": "<?=lang('This field is required')?>",
                /*'level[]': {
                    required: "<?=lang('This field is required')?>",
                    //number: "<?=lang('Please enter a valid number')?>",  
                },*/
               /* 'rowLevelID[]': {
                    required: "<?=lang('This field is required')?>",
                    //number: "<?=lang('Please enter a valid number')?>",  
                },*/
                /* exSchool: {
                   required: "<?=lang('This field is required')?>",   
                   maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                 },
                 note: { 
                   maxlength: "<?=lang('Please enter no more than 50 characters')?>"
                 },*/
                Signature: {
                    maxlength: "<?=lang('Please enter no more than 500 characters')?>"
                },
                file: {
                    required: "<?=lang('This field is required')?>",
                    minlength: "<?=lang('Please enter a valid image type (png |gif | jpg | png | jpeg | pdf)')?>",
                    extension: "<?=lang('Please enter a valid image type (png |gif | jpg | png | jpeg | pdf)')?>"
                },
                'img_name[]': {
                   // required: "<?=lang('This field is required')?>",
                    minlength: "<?=lang('Please enter a valid image type (png |gif | jpg | png | jpeg | pdf)')?>"
                },
                mother_name: {
                    required: "<?=lang('This field is required')?>"
                  },
                  mother_email: {
                    email: "<?=lang('Please enter a valid email')?>"
                  },
                  mother_mobile: { 
                    required: "<?=lang('This field is required')?>", 
                    number: "<?=lang('Please enter a valid number')?>"
                  },
                  transport_address: {
                    required: "<?=lang('This field is required')?>"
                  },
                  transport_type: {
                    required: "<?=lang('This field is required')?>"
                  },
            }
        });
        if ($('input[name=want_transport]:checked').val() == 2) {
            addRules(transportRules);
        }
        else {
            removeRules(transportRules);
        }
        if (form.valid() == true) {

            $('.nav-tabs > .active').next('li').find('a').trigger('click');
        }
    });

    $('.btnPrevious').click(function() {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });

    function onlyNumberKey(evt) {

        // Only ASCII charactar in that range allowed 
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

<script type="text/javascript">
    function checkTransport(input) {
        if (input.is(':checked') && input.val() == 2) {
            $('input[name=transport_address]').attr('disabled', false);
            $('select[name=transport_type]').attr('disabled', false);
            addRules(transportRules);
        }
        else {
            $('input[name=transport_address]').val('');
            $('select[name=transport_type]').val('');
            $('input[name=transport_address]').attr('disabled', true);
            $('select[name=transport_type]').attr('disabled', true);
            removeRules(transportRules);
        }
    }

    function addRules(rulesObj){
        for (var item in rulesObj){
           $('#'+item).rules('add',rulesObj[item]);  
        } 
    }

    function removeRules(rulesObj){
        for (var item in rulesObj){
           $('#'+item).rules('remove');  
           $('#'+item+'-error').remove();
           $('#'+item).removeClass('error');
        } 
    }
</script>

<script>
    function validation_speed() {
        ////////
        if ($("#parent_name").val() == '') {
          //  alert(' اسم الاب اجبارى فى الخطوة الاولى');
            return false;
        } else if ($("#parent_name").val().length > 51) {
           // alert('اسم الاب لايزيد عن 50 حرف');
            return false;
        }
        ///////////////
        if ($("#ParentNumberID").val() == '') {
          //  alert('الرقم القومي اجباري في الخطوه الاولي');
            return false;
        } else if ($("#ParentNumberID").val().length > 15) {
           // alert('الرقم القومي لا يزيد عن 14 رقم');
            return false;
        }
        //////
        if ($("#parent_type_Identity").val().length > 251) {
        //    alert('نوع الهويه لاتزيد عن 250 حرف');
            return false;
        }
        //////
        if ($("#parent_type_Identity").val().length > 51) {
         //   alert('مصدر الهوية لاتزيد عن 50 حرف');
            return false;
        }
        //
        if ($("#parent_email").val() != '') {
            if (!ValidateEmail($("#parent_email").val())) {
           //     alert('اكتب الايميل بشكل صحيح');
                return false;
            }
        }
        //
        if ($("#parent_mobile").val() == '') {
          //  alert(' رقم جوال الاب اجبارى فى الخطوة الاولى ');
            return false;
        }
        if ($("#student_NumberID").val() == '') {
           // alert(' رقم هوية الطالب اجبارى فى الخطوة الثانية ');
            return false;
        }
        if ($("#rowLevelID").val() == 'f') {
         //   alert('اختر الصف للطالب فى الخطوة الثانية ');
            return false;
        }
        if (img == null) {
            alert(' قم برفع اخر صورة شهادة فى الخطوة الثانية');
            return false;
        }
        /*if($("#exSchool").val() == ''){
            alert(' اسم اخر مدرسة اجبارى فى الخطوة الثانية');
             return false;
        }*/
        /*if($("#semesterID").val() == 'f'){
            alert('اختر الفصل الدراسى فى الخطوة الثانية ');
             return false;
        }*/

        return true;

    }

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.emailAddr.value)) {
            return (true)
        }
      //  alert("You have entered an invalid email address!")
        return (false)
    }
    /* $.validate({
         form : '#registration-form',
         lang: 'ar',
         onError : function($form) {
          
         }
         onSuccess : function($form) {
             var response = grecaptcha.getResponse();
              if(response.length === 0){
                 document.getElementById("recaptcha").style.border = '1px solid red';
                 document.getElementById("recaptchaMsg").innerHTML = 'قم بتفعيل  انا لست برنامج روبوت   ';
                 test = false ;
             }else{
                 test = true;
             }
             return test;
           
         }
     });*/

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#registration-formx").validate({

        });
    });

</script>



<?php include('footer.php'); ?>
