<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Required Meta Tags -->
    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?= lang('description') ?>" />
    <meta name="keywords" content="<?= lang('keywords') ?>" />
    <!-- Other Meta Tags -->
    <?php $query = $this->db->query("SELECT `Logo`,`SchoolName`, `SchoolEnName` FROM `setting` ")->row_array(); ?>
    <?php if ($this->session->userdata('language') != 'english') { ?>
        <title><?php echo $query['SchoolName'] ?></title>
    <?php } else { ?>
        <title><?php echo $query['SchoolEnName'] ?></title>
    <?php } ?>
    <meta name="robots" content="index, follow" />
    <meta name="copyright" content="Sitename Goes Here">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>">
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>login/css/tornado-icons.css" media="all">
    <?php if ($this->session->userdata('language') != 'english') { ?>
        <link href="<?php echo base_url(); ?>login/css/tornado-rtl.css" rel="stylesheet" />
    <?php } else { ?>
        <link href="<?php echo base_url(); ?>login/css/tornado.css" rel="stylesheet" />
    <?php } ?>
</head>
<body>
  <!-- Portal -->
  
        <div class="portal-page flexbox align-center-x align-center-y">
            <?php if($this->session->flashdata('ErrorAdd')){ ?>
            <div class="alert alert-danger" style="font-size: x-large; text-align: center;">
                <?php 
            echo $this->session->flashdata('ErrorAdd'); ?>
            </div>
            <?php } else if($this->session->flashdata('SuccessAdd')){ ?>
            <div class="alert alert-success" style="font-size: x-large; text-align: center;">
                <?php echo $this->session->flashdata('SuccessAdd'); ?>
            </div>
            <?php }?> 
            <?php if($this->session->flashdata('Failuer') != ""){?>
            <div class="alert alert-danger" style="font-size: x-large; text-align: center;">
            
                 <div class="alert danger"><?php echo $this->session->flashdata('Failuer');?> </div> 
            </div>     
            <?php } ?>
        
            <div class="bg-slider">
                <?php  
                //  $get_imgs      = $this->home_model->Get_specific_details(234); 
               
        		$get_imgs = $this->db->query(" SELECT cms_details.`ID`, cms_details.`MainSubID`, cms_details.`like_count`, cms_details.Title AS Title, cms_details.Content AS Content, 
        		                            cms_details.`ImagePath`, cms_details.`YoutubeScript`, cms_details.`Sound`, cms_details.`LevelID`, 
                                    		cms_details.`schoolID`, cms_details.`contactID`, cms_details.`Date`, cms_details.`IsSystem`, cms_details.`IsActive`,
                                    		cms_details.`Token`, cms_details.`ContentTypeID`, cms_details.`YoutubeScriptArray`,cms_main_sub_new.cms_type_id ,cms_main_sub_new.cms_type_id
                                    		,cms_main_sub_new.cms_type_id FROM cms_details 
        		                            INNER JOIN cms_main_sub_new ON cms_main_sub_new.ID = cms_details.MainSubID
        		                            INNER JOIN cms_main ON cms_main.ID = cms_main_sub_new.cms_main_id
        		                            where MainSubID = 234 AND cms_main.Is_Active = 1  AND cms_main_sub_new.IsActive != 0 AND  FIND_IN_SET(0,LevelID) order by cms_details.id desc")->result();
        		
        		foreach($get_imgs as $num=>$item){
                    $ImagePath = $item->ImagePath; 
                    if($item->ImagePath){
                        $ImagePath=explode(",",$item->ImagePath);
                        foreach($ImagePath as $key=>$Image){
                            if($Image){
                    ?>  
                    <div class="item bgImg" data-src="<?php echo base_url().'upload/'.$Image?>"></div>
                <?php }}}}
                 ?>
                <!-- item -->
                
            </div>
            <!-- Steps Form -->
            <form method="post" class="steps-form form-ui max-980" action="<?php echo site_url('home_new/home/NewRegisterInstitute'); ?>">
                <!-- Head -->
                <div class="head">
                    <h3>
                        <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" alt="">
                        التسجيل 
                    </h3>
                    <a href="<?php echo base_url(); ?>" class="btn primary small">الرئيسية</a>
                </div>
                <!-- Steps List -->
                
                <h3 class="title ti-user-tie">بيانات الطالب</h3>
                <!-- Grid -->
                <div class="row">
                    <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">الاسم بالكامل</label>
                        <input name="student_name" id="student_name"  type="text" placeholder="- - -">
                    </div>
                   
                    <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">النوع </label>
                        <select name="gender" id="gender" class="selectpicker form-control">
                            <option value="">ذكر</option>
                            <option value="">انثى</option>
                        </select>
                    </div>
                    <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">البريد الالكتروني </label>
                        <input name="mail" id="mail" type="text" placeholder="- - -">
                    </div>
                    <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">الجنسية</label>
                        <select name="nationality" id="nationality" class="selectpicker form-control">
                            <option value="">-- اختر --</option>
                            <?php
                            $nationality = $this->db->query("SELECT * FROM `name_space` WHERE `Parent_ID` = 1")->result();
                            foreach($nationality as $item ){ ?>
                                            
                                <option value="<?=$item->ID;?>" <?php echo set_select('parent_national_ID',$item->Name, ( !empty($data) && $data == $item->Name ? TRUE : FALSE )); ?>><?=$item->Name;?></option>
                                            
                          <?php } ?>
                        </select>
                    </div>
                    <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">رقم الهوية</label>
                        <input name="student_NumberID" id="student_NumberID"  type="text" placeholder="- - -">
                    </div>
                    <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">الجوال</label>
                        <input name"mobile" id"mobile" type="text" placeholder="- - -">
                    </div>
                     <!-- Form Control -->
                    <div class="col-12 col-m-6 col-l-4">
                        <label for="">الدورة</label>
                        <select name="courses" id="courses" class="selectpicker form-control">
                            <? foreach($get_Courses as $item ){ ?>
                                <option value="<?=$item->ID;?>"><?=$item->Name;?></option>
                          <?php } ?>
                        </select>
                    </div>    
                    <!--<h3 class="title ti-id-badge col-12">بيانات الدخول</h3>-->
                    <!-- Form Control -->
                    <!--<div class="col-12 col-m-6 col-l-4">-->
                    <!--    <label for="">اسم المستخدم</label>-->
                    <!--    <input username="" type="text" placeholder="- - -">-->
                    <!--</div>-->
                    <!-- Form Control -->
                    <!--<div class="col-12 col-m-6 col-l-4">-->
                    <!--    <label for="">كلمة المرور</label>-->
                    <!--    <input type="text" placeholder="- - -">-->
                    <!--</div>-->
                </div>
                <!-- Buttons -->
                <div class="flex-box btns">
                    <a href="#" class="btn primary btn-icon ti-arrow-left-c next-step">حفظ</a>
                </div> 
                <!-- // Buttons -->
            </form>
            <!-- // Steps Form -->
        </div>
        <!-- // Portal -->

        <!-- Required JS Files -->
        <script src="<?php echo base_url(); ?>login/js/tornado.min.js"></script>
</body>
</html>