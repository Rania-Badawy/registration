<!DOCTYPE html>
<?php $query=$this->db->query("select * from setting")->row_array();
$query_setting = $query; //بنستخدمها في ال mainPage
?>
<html lang="ar" dir="rtl"
    style="--header-color:<?php echo $query['home_color']?>;--primary-color: <?php echo $query['main-color2'];?>;--primary-hover:<?php echo $query['main-color'];?> !important;">

<head>
    
    <!-- Required Meta Tags -->
    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?= lang('description')?>">
    <meta name="keywords" content="<?= lang('keywords')?>">
    <meta name="author" content="<?= lang('author')?>">
    <?php $queryName=$this->db->query("select Name from contact where ID =".$this->session->userdata('id')."")->row_array(); ?>
    <title><?php echo $queryName['Name']?></title>
    <!-- Other Meta Tags -->
    <meta name="robots" content="index, follow" />
    <meta name="copyright" content="شركة الحلول الخبيرة">

    <link rel="shortcut icon" type="image/png"
        href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/table_style.css">
    <!-- Required CSS Files -->
    <link href="<?php echo base_url(); ?>assets_emp/exam/css/fontawsome.css" rel="stylesheet" crossorigin="anonymous" />
    <?php if($this->session->userdata('language') != 'english'){ ?>
    <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado-rtl.css" rel="stylesheet" />
    <?php }else{ ?>
    <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado.css" rel="stylesheet" />
    <?php } ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/load.css">
    <link href="<?php echo base_url(); ?>assets_new/css/inbox-style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets_new/css/select2.min.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets_new/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/new/js/jquery.fireworks.js"></script>

    <?php if($this->session->userdata('language') != 'english'){ $dir="rtl";} else{$dir="ltr";}?>
    <?php 
    if($query['ApiDbname'] == 'SchoolAccElinjaz'){?>
     <!-- Hotjar Tracking Code for Site 5072502 (name missing) -->
     <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:5072502,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    <?php } ?>
    <script type="text/javascript">
    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        theme: "advanced",
        theme_advanced_buttons1: "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
        theme_advanced_buttons2: "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg,,tiny_mce_wiris_formulaEditor,tiny_mce_wiris_formulaEditorChemistry",
        theme_advanced_buttons3: "",
        theme_advanced_fonts: "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        plugins: 'asciimath,asciisvg,table,inlinepopups,media,tiny_mce_wiris',
        AScgiloc: 'https://www.imathas.com/editordemo/php/svgimg.php', //change me  
        ASdloc: 'https://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg', //change me  	
        directionality: "<?php echo $dir?>",
        content_css: "<?php echo base_url()?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
    });
    </script>
    <style>
        .half_star {
    -webkit-text-fill-color: transparent;
    -webkit-background-clip: text !important;
    display: inline-block;
    background-clip: text;
}
    .star-rating {
      font-size: 24px;
      color: gold; /* Default star color */
      display: inline-block;
      position: relative;
    }

    .star-rating::before {
      content: '★★★★★'; /* Five stars */
      letter-spacing: 3px;
      position: absolute;
      top: 0;
      left: 0;
      color: #ccc; /* Inactive star color */
    }

    .star-rating span {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      overflow: hidden;
      white-space: nowrap;
      color: gold; /* Active star color */
    }

    .star-rating span::before {
      content: '★★★★★'; /* Five stars */
      letter-spacing: 3px;
      position: absolute;
      top: 0;
      left: 0;
    }

    .star-rating .stars-inner {
      width: 0;
      white-space: nowrap;
      overflow: hidden;
      color: red; /* Warning color */
    }
    .star { 
            width:150px; 
            position: relative;
            color: #bdbdbd;
            }
        .fixed-sidebar,
        .page-wraper{
            direction: ltr !important;
        }
       .fixed-sidebar .main-menu,
       .page-wraper div{
            direction: rtl !important;
        }
        .page-wraper{
            overflow: auto !important;
        }
        .fixed-sidebar .main-menu>li:hover {
            background: #d7d6d6;
        }
        .fixed-sidebar .main-menu>li.active,
        .fixed-sidebar .main-menu>li.active:hover {
            background: #d7d6d6;
        }
        @media (max-width: 1100px){
            .fixed-sidebar.activated .logo,.fixed-sidebar.activated .user-info *:not(.avatar,h3,span), .fixed-sidebar .user-info a {display: inline-block;}
        }
    </style>
    <?php if ($this->session->userdata('language') == 'english') {?>
        <style>
        .fixed-sidebar,
        .page-wraper{
            direction: rtl !important;
        }
        .fixed-sidebar .main-menu,
        .page-wraper div{
            direction: ltr !important;
        }
        .page-wraper{
            overflow: auto !important;
        }
    </style>
        <?php } ?>
</head>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/bank/js/sweetalert2.all.js"></script>

<?php if($this->session->userdata('type')!="R" && $this->session->userdata('type')!="A"){ ?>

<?php	   
        $CI                  = get_instance();
        $CI->load->model('e_library_model');
        $CI->load->model('contact/contact_model');
        $CI->load->model('student/student_class_table_model');
        $CI->load->model('admin/setting_model');
        $UID      = $this->session->userdata('id');
        $get_subject_header    = $CI->e_library_model->getStudentRowLevel_header($UID);
        $contact_details = $CI->contact_model->get_details($UID);
        ?>

<!-- Layout Wraper -->
<div class="row no-guuter row-reverse">
    <!-- Sidebar -->
    <div class="fixed-sidebar col-12 mxw-270 white-bg nested-menu hidden-print"><script async src="https://cse.google.com/cse.js?cx=332f688d4e39c4842">
    <iframe src="https://cse.google.com/cse.js?cx=332f688d4e39c4842" width="100%" height="500" frameborder="0" scrolling="auto"></iframe>

</script>
<!-- <div class="gcse-search"></div> -->
        <!-- Sidebar Toggle -->
        <a href="#" class="btn square parent-toggle far fa-bars sidebar-toggle"></a>
        <!-- Site Logo -->
        <!--<h2 class="logo"><img src="<?php echo site_url(); ?>intro/images/logo.png" alt=""></h2>-->
        <!-- User Info -->
        <div class="user-info tx-align-center" style="margin-top: 31px;">
            <!-- Avatar -->
            <?php if(!empty($contact_details['img'])){?>
            <img src="<?php echo base_url()?>assets/user_data/<?php echo $contact_details['img'];?>" alt=""
                class="avatar from-image-final">
            <?php } elseif($contact_details['Gender']==2) { ?>
                <img src="<?php echo base_url(); ?>intro/images/school_logo/woman.png" alt="" class="avatar from-image-final">
            <?php } else { ?>
            <img src="<?php echo base_url(); ?>intro/images/school_logo/man2-avatar.png" alt=""
                class="avatar from-image-final">
            <?php } ?>
            <?php 
                    $UID      = $this->session->userdata('id');
                    $stuclass = '' ;
                    $QueryGetstuclass = $this->db->query("SELECT student.Class_ID,row_level.ID AS rowLevelId,row_level.Level_Name as levelname,row_level.Row_Name as rowname,class.Name as classname FROM student INNER JOIN class ON student.Class_ID = class.ID INNER JOIN row_level ON student.R_L_ID = row_level.ID  WHERE student.Contact_ID = $UID ")->row_array(); 
                    if(sizeof($QueryGetstuclass) > 0 ){$stuclass = $QueryGetstuclass['levelname']."-".$QueryGetstuclass['rowname']."-".$QueryGetstuclass['classname'];}
                    //print_r($stuclass);die;
                    ?>
            <!-- Username -->
            <?php 
                if($this->session->userdata('language') == 'english' && $query['ApiDbname'] != 'SchoolAccAtlas'){
                    if(!empty($contact_details['Name_en'])){
                       $stuName =  $contact_details['Name_en'];
                    }else{
                        $stuName = $this->session->userdata('contact_name');
                    }
                }else{
                    $stuName = $this->session->userdata('contact_name');
                }
            ?>
            <h3><?php echo $stuName; ?><a
                    href="<?php echo site_url('contact/contact/edit_contact') ?>"
                    class="btn small circle far fa-edit"></a></h3>
            <!-- ID -->
            <?php  if($query['ApiDbname'] =="ksiscs"){  ?>
            <span class="small-text gray-color"> <?php echo $stuclass;?></span> <br>
            <?php }else{  ?>
            <span class="small-text gray-color">Class : <?php echo $stuclass;?></span> <br>
            <?php } ?>
            <span class="small-text gray-color">ID : <?php echo $contact_details['Number_ID'];?></span>
            <!-- Rating -->
            <!-- <div class="stars gray-color">
                <i class="fas fa-star warning-color"></i>
                <i class="fas fa-star warning-color"></i>
                <i class="fas fa-star warning-color"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div> -->

            <?php 

$current_sem    = $CI->setting_model->get_semester();
$ReturnData1 = $this->db->query("SELECT  start_date, end_date  FROM `config_semester` WHERE ID= '".$current_sem."'   ")->row_array();
$Score_total = 0;
$totalRateSum = 0;  
$stu_Data  = $this->db->query("SELECT R_L_ID  ,  Class_ID ,s_language  FROM  student  WHERE Contact_ID ='".$this->session->userdata('id')."'    ")->row_array(); 
     $Class_ID  = $stu_Data['Class_ID'] ;
     $R_L_ID    = $stu_Data['R_L_ID'] ;
     $s_language    = $stu_Data['s_language'] ;
     if(empty($s_language)){
         $s_language  = 0 ;
     }
     
    
     // $ReturnData1 = $this->db->query("SELECT MIN(start_date) as start_date , MAX(end_date) as end_date FROM config_semester  ")->row_array(); 

     
     $startDate = $ReturnData1['start_date'];
     $endDate  = $ReturnData1['end_date'];
     $query_points_stu            =$this->db->query(" SELECT SUM(Stu_Degree) AS RoundedTotalDegree FROM send_box_student WHERE Stu_ID = '".$this->session->userdata('id')."'    AND ((send_box_student.Type_ID != 7 AND (`date_from` BETWEEN '$startDate' AND '$endDate' ) AND FIND_IN_SET('$Class_ID', send_box_student.Class_ID))Or(send_box_student.Type_ID = 7 AND `DATE` BETWEEN '$startDate' AND '$endDate')) and send_box_student.`R_L_ID`= '".$R_L_ID."' ")->row_array();
    // print_r($this->db->last_query() );die;
    $query_points           =$this->db->query(" SELECT 
                                                 (SELECT COUNT(*) FROM lesson_prep INNER JOIN subject ON lesson_prep.Subject_ID = subject.ID   WHERE lesson_prep.RowLevel_ID = $R_L_ID AND FIND_IN_SET('$Class_ID', lesson_prep.classID)  AND lesson_prep.date_from   BETWEEN '$startDate' AND '$endDate' AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0)) AS count_lesson_prep,
                                                 (SELECT COUNT(*) FROM e_library INNER JOIN subject ON e_library.SubjectID  = subject.ID  WHERE e_library.RowLevelID = $R_L_ID AND FIND_IN_SET('$Class_ID', e_library.ClassID )  AND e_library.SemesterID = $current_sem AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0)) AS count_e_library,
                                                 (SELECT COUNT(*) FROM clerical_homework INNER JOIN subject ON clerical_homework.Subject_ID   = subject.ID WHERE clerical_homework.RowLevelID = $R_L_ID AND FIND_IN_SET('$Class_ID', clerical_homework.classID ) AND clerical_homework.date_from   BETWEEN '$startDate' AND '$endDate' AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0)) AS count_clerical_homework,
                                                 (SELECT COALESCE(SUM(test.examDegree), 0) FROM test  INNER JOIN subject ON test.subject_id    = subject.ID WHERE test.RowLevelID = $R_L_ID AND FIND_IN_SET('$Class_ID',  test.classID) and test.config_semester_ID= $current_sem AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0)) AS count_test,
                                                 (SELECT COUNT(*) FROM lesson_prep INNER JOIN subject ON lesson_prep.Subject_ID = subject.ID WHERE lesson_prep.RowLevel_ID = $R_L_ID AND FIND_IN_SET('$Class_ID', lesson_prep.classID) AND lesson_prep.date_from   BETWEEN '$startDate' AND '$endDate'  AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0)) +
                                                 (SELECT COUNT(*) FROM e_library INNER JOIN subject ON e_library.SubjectID  = subject.ID WHERE e_library.RowLevelID = $R_L_ID AND FIND_IN_SET('$Class_ID', e_library.ClassID ) AND e_library.SemesterID = $current_sem AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0))  +
                                                 (SELECT COUNT(*) FROM clerical_homework INNER JOIN subject ON clerical_homework.Subject_ID   = subject.ID WHERE clerical_homework.RowLevelID = $R_L_ID AND FIND_IN_SET('$Class_ID', clerical_homework.classID ) AND clerical_homework.date_from   BETWEEN '$startDate' AND '$endDate' AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0) ) +
                                                 (SELECT COALESCE(SUM(test.examDegree), 0) FROM  test INNER JOIN subject ON test.subject_id    = subject.ID  WHERE test.RowLevelID = $R_L_ID AND FIND_IN_SET('$Class_ID',  test.classID) and test.config_semester_ID= $current_sem AND ((subject.basic = 0 AND subject.ID  IN ($s_language))  OR subject.basic <> 0)) AS total_count ")->row_array();
                                              //print_r($this->db->last_query() );die;
     if ($query_points_stu['RoundedTotalDegree']){
         $Score_total = $query_points_stu['RoundedTotalDegree'];
     }
  
   $totalRateSum = $query_points['total_count'];

    $star_score =($totalRateSum > 0 ? $Score_total / $totalRateSum : 0) *100 ; 
    $star_score =  $star_score /20 ;

     $star_score_int = floor($star_score);
    
     $star_score_fractional = $star_score - $star_score_int; 

     $star_score_formatted = number_format($star_score, 1);
   //  print_r($star_score_formatted );die;
     ?>

     
         <div class="stars gray-color" data-toggle="tooltip" data-placement="bottom" title="<?=$star_score_formatted?>">
             <?php
             for ($i = 1; $i <= 5; $i++) {
                 if ($i <= $star_score_int) {
                     echo '<i class="fas fa-star warning-color"></i>';
                 } elseif ($i == $star_score_int + 1 && $star_score_fractional > 0) {
                       $gradient_percentage = $star_score_fractional * 100;
                       echo '<i class="fas fa-star half_star" style="background: linear-gradient(to right, #f4bb10 '.$gradient_percentage.'%, #878e96 '.$gradient_percentage.'%); -webkit-background-clip: text; color: transparent;"></i>';
                 } else {
                     echo '<i class="fas fa-star"></i>';
                 }
             }
             ?>
         </div>
<!-- // Rating -->
</div>
        <!-- Main Menu -->
        <ul class="main-menu">
            <li><a href="<?php echo site_url('student/cpanel/main_page'); ?>" class="fas fa-home">
                    <?php echo lang('am_general');?></a></li>
        <?php if($query['ApiDbname']=="SchoolAccAlfadeelah"){ ?>
        <li><a target="_blank"  href="https://schools.madrasati.sa/Auth/Index" class="fas fa-book-reader">منصة مدرستي</a></li>
        <?php } ?>
        <?php if($query['platform']==1){ ?>
            <?php if($query['ApiDbname']=="SchoolAccGheras"){ ?>
            <li><a target="_blank" href="https://gherasalakhlaq.net/" class="fa fa-globe">موقع لتعلم وتطوير اللغة
                    الانجليزية </a> </li>
            <?php } ?>
            <?php if($query['ApiDbname']=="SchoolAccExpert"){ ?>
            <li><a target="_blank" href="https://www.cardscanner.co/image-to-text" class="fa fa-globe">
                    <?php echo lang('am_Transcription');?></a> </li>
            <?php } ?>
            <li><a href="#" class="fas fa-tasks"><?php echo lang('br_per_by_date');?></a>
                <!-- Submenu -->
                <ul>
                    <li><a
                            href="<?php echo site_url('student/StudentTasks/ToDayTasks'); ?>"><?php echo lang('ToDayTasks');?></a>
                    </li>
                    <li><a
                            href="<?php echo site_url('student/StudentTasks/YesterdayTasks'); ?>"><?php echo lang('YesterdayTasks');?></a>
                    </li>
                    <li><a
                            href="<?php echo site_url('student/StudentTasks/FuturTasks/'); ?>"><?php echo lang('FuturTasks');?></a>
                    </li>
                </ul>
                <!-- // Submenu -->
            </li>
            <li id="MEETING_ATTEND"><a href="<?php echo site_url('student/cpanel/meeting_attend'); ?>"
                    class="fas fa-calendar-alt"><?php echo lang('ra_virtual_sessions');?></a></li>
            <li><a href="<?php echo site_url('student/cpanel/recording_list_Zoom_Meeting'); ?>"
                    class="fas fa-download"><?php echo lang('Downloadlectures');?></a></li>
            <li><a href="<?php echo site_url('student/class_table'); ?>" class="fas fa-calendar-alt">
                    <?php echo lang('br_class_table_t');?></a></li>
            <?php 
                       $UID               = $this->session->userdata('id');
	                   $SchoolID          = $this->session->userdata('SchoolID');
                       $semester_id       = $CI->setting_model->get_semester();
                       $week_id           = $CI->setting_model->get_week();
                       $group_day         = $CI->student_class_table_model->get_group_day_header1($SchoolID);
                       if(!$group_day){
                           $group_day=0;
                       }
                       ?>
            <li><a href="<?php echo site_url('student/class_table/plan_week/'.$group_day."/".$week_id."/".$semester_id); ?>"
                    class="fas fa-bullseye"><?php echo lang('br_plan_week');?></a></li>

                    <?php if ($query['ApiDbname']  == "SchoolAccExpert" || $query['ApiDbname']  == "SchoolAccAtlas") {?>

            <li><a href="<?php echo site_url('student/chart/files/1'); ?>" class="fas fa-calendar-alt"><?php echo lang('calendar');?></a></li>  
            <li><a href="<?php echo site_url('student/chart/files/2/'.$QueryGetstuclass['rowLevelId']."/".$QueryGetstuclass['Class_ID']); ?>" class="fas fa-calendar-alt"><?php echo lang('exam_scope');?></a></li>  
            <li><a href="<?php echo site_url('student/chart/files/3/'.$QueryGetstuclass['rowLevelId']."/".$QueryGetstuclass['Class_ID']); ?>" class="fas fa-calendar-alt"><?php echo lang('exam_schedule');?></a></li>    
            <?php } if($query['ApiDbname']!="ksiscs"){  ?>
                <li id="LESSON_WATCH"><a href="#" class="fas fa-layer-group"><?php echo lang('er_lessons');?></a>
                <!-- Submenu -->
                <ul>
                    <?php
                            
                            if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="LESSON_WATCH_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/lessons/index/'.$ClassSubID.'/'.$SRowLevelID); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <li id="ASK_TEACHER"><a href="#"
                    class="icon-btn fas fa-user-tie"><?php echo lang('am_ask_qus_teacher');?></a>
                <!-- Submenu -->
                <ul>
                    <?php if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="ASK_TEACHER_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/ask_teacher/ask_header/'.$ClassSubID.'/'.$SRowLevelID); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <?php } ?>
            <li id="LESSON_REVISION"><a href="#" class="fas fa-file-import"><?php echo lang('br_e_library');?></a>
                <!-- Submenu -->
                <ul>
                    <?php 
                           $semester_id          = $CI->setting_model->get_semester();
                            if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="LESSON_REVISION_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/e_library/index/'.$ClassSubID.'/'.$semester_id); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <?php  if($query['ApiDbname']!="ksiscs"){  ?>
            <li id="CLERICAL_ASSIGNMENT"><a href="#"
                    class="fas fa-file-signature"><?php echo lang('am_clerical_homework');?></a>
                <!-- Submenu -->
                <ul>
                    <?php if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="CLERICAL_ASSIGNMENT_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/clerical_homework/homework_header/'.$ClassSubID."/"."0"); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <li id="WORK_PAPER"><a href="#" class="fas fa-file-signature"><?php echo lang('na_work_paper');?></a>
                <!-- Submenu -->
                <ul>
                    <?php if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="WORK_PAPER_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/clerical_homework/homework_header/'.$ClassSubID."/"."1"); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <li id="ELECTRONIC_ASSIGNMENT"><a href="#"
                    class="fas fa-file-contract"><?php echo lang('am_homework');?></a>
                <!-- Submenu -->
                <ul>
                    <?php if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="ELECTRONIC_ASSIGNMENT_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/answer_exam/answer_exam_header/'.$ClassSubID."/".'1'); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <?php } ?>

            <li id="EXAM"><a href="#" class="fas fa-marker"><?php echo lang('Exams');?></a>
                <!-- Submenu -->
                <ul>
                    <?php if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                $ClassID = $row->ClassID;
                                ?>
                    <li id="EXAM_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/answer_exam/answer_exam_header/'.$ClassSubID."/".'0'); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
                <!-- // Submenu -->
            </li>
            <!--<li id="EVAL_EXAM"><a href="#" class="fas fa-marker"><?php echo lang('na_eval_exam');?></a>-->
            <!-- Submenu -->
            <!--    <ul>-->
            <!--       <php if($get_subject_header!=0){-->
            <!--            foreach($get_subject_header as $row){-->
            <!--            $ClassSubName = $row->ClassSubName;-->
            <!--            $ClassSubID = $row->ClassSubID;-->
            <!--            $SRowLevelID = $row->SRowLevelID;-->
            <!--            ?>-->
            <!--        <li id="EVAL_EXAM_<?php echo $ClassSubID;?>"><a href="<?php echo site_url('student/answer_exam/answer_exam_header/'.$ClassSubID."/".'2'); ?>"><?php echo $ClassSubName ;?></a></li>-->
            <!--        <php }}?>-->
            <!--    </ul>-->
            <!-- // Submenu -->
            <!--</li>-->
            <?php  if($query['ApiDbname']!="ksiscs"){  ?>
            <li><a href="<?php echo site_url('student/answer_exam/degree_report'); ?>"
                    class="fas fa-chart-bar"><?php echo lang('exam_report');?> </a></li>
            <?php  
                    
                    if($query['ApiDbname']!="SchoolAccAsrAlMawaheb"){ 
                        
                        $cer_cheack_all = $this->db->query("SELECT `certificate_father`,`degree_report_father`  FROM `config_emp_school` WHERE `schoolID` = '".$this->session->userdata('SchoolID')."' AND `SemesterID` = $semester_id ")->row_array();     
                        $cer_cheack     = $this->db->query("SELECT `certificate`,`report_certificate` FROM `student` WHERE `Contact_ID`= ".$UID." ")->row_array(); 
                    
                    ?>
            <?php 
            if($cer_cheack_all['degree_report_father'] != 0){
            if($cer_cheack['report_certificate'] == 0){ ?>
            <li><a href="<?php echo site_url('father/exam_result/certificate_report/'.$UID); ?>"
                    class="fas fa-file-contract"><?php echo lang('degree_report');?> </a></li>
            <?php }}
            if($cer_cheack_all['certificate_father'] != 0){
            if($cer_cheack['certificate'] == 0){?>
            <li><a href="<?php echo site_url('father/exam_result/certificate/'.$UID); ?>"
                    class="fas fa-file-contract"><?php echo lang('certificate');?> </a></li>
            <?php }}}?>

            <li><a href="<?php echo site_url('student/zoom/MeetingAttendDetails_Report'); ?>"
                    class="fas fa-file-contract"><?php echo lang('Report attendance of zoom sessions');?> </a></li>
            <!--<li><a href="#" class="fas fa-file-alt"><?php echo lang('am_models');?></a>-->
            <!--    <ul>-->
            <!--        <li><a href="<?php echo site_url('model/model/model_list'); ?>"> <?php echo lang('am_models_list');?></a></li>-->
            <!--<li><a href="forms-graphical.html"> <?php echo lang('Illustrated_form');?></a></li>-->
            <!--        <li><a href="forms-list.html">  <?php echo lang('am_my_models_list');?></a></li>-->
            <!--    </ul>-->
            <!--</li>-->
            <li><a href="#" class="fas fa-wave-square"> <?php echo lang('studentlevelchart');?></a>
                <ul>
                    <li><a
                            href="<?php echo site_url('student/chart/index/weekly1'); ?>"><?php echo lang('weeklystudentlevelchart');?></a>
                    </li>
                    <li><a
                            href="<?php echo site_url('student/chart/index/monthly1'); ?>"><?php echo lang('monthlystudentlevelchart');?></a>
                    </li>

                </ul>
            </li>

            <?php 
                        $query_vote=$this->db->query("select * from vote_quiz where vote_quiz.is_publish=1  and permission_type LIKE '%1%' and vote_quiz.from <= '".date("Y-m-d")."' and vote_quiz.to >= '".date("Y-m-d")."' 
	                    and Token not in(select q_token from vote_result where user_id ='".$this->session->userdata('id')."')  ")->result();  ?>
            <?php  if(!empty($query_vote)){ ?>
            <li id=""><a href="<?php echo site_url('student/cpanel/vote'); ?>"
                    class="fas fa-calendar-alt"><?php echo lang('am_poll');?></a></li>
            <?php  } ?>

            <?php } ?>
            <!--/////////////-->

            <?php  if($query['ApiDbname']=="ksiscs"){  ?>
            <?php 
                        $query_vote=$this->db->query("select * from vote_quiz where vote_quiz.is_publish=1  and permission_type LIKE '%1%' and vote_quiz.from <= '".date("Y-m-d")."' and vote_quiz.to >= '".date("Y-m-d")."' 
	                    and Token not in(select q_token from vote_result where user_id ='".$this->session->userdata('id')."')  ")->result();  ?>
            <?php  if(!empty($query_vote)){ ?>
            <li id="poll"><a href="#" class="fas fa-marker"><?php echo lang('co_poll');?></a>
                <ul>
                    <?php
                            
                            if($get_subject_header!=0){
                                foreach($get_subject_header as $row){
                                $ClassSubName = $row->ClassSubName;
                                $ClassSubID = $row->ClassSubID;
                                $SRowLevelID = $row->SRowLevelID;
                                ?>
                    <li id="poll_<?php echo $ClassSubID;?>"><a
                            href="<?php echo site_url('student/cpanel/vote/'.$ClassSubID); ?>"><?php echo $ClassSubName ;?></a>
                    </li>
                    <?php }}?>
                </ul>
            </li>
            <?php }} ?>
            <!--///////////////-->


            <?php  if($query['ApiDbname']=="ksiscs"){  ?>
            <li id=""><a href="<?php echo site_url('student/cpanel/certificate_card'); ?>" class="fas fa-calendar-alt">
                    شهادة الدورة</a></li>
            <?php } ?>
            <?php } ?>
        </ul>
        <!-- // Main Menu -->
    </div>
    <!-- Page Wraper -->
    <div class="page-wraper">
        <!-- Header -->
        <div class="tornado-header primary hidden-print">
            <div class="container-fluid">
                <!-- Search Box -->
                <div class="search-box form-ui small" style="width: fit-content !important;">
                    <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']?>" alt=""
                        style="width: 44px;">
                    <?php
                             $SchoolName = '' ;
                            			  
                            			   if($this->session->userdata('language') == 'english'){ 
                            			       $Name= 'SchoolNameEn' ;
                            			       
                            			   }else{
                            			          $Name= 'SchoolName' ; 
                            			       }
                            $QueryGetSchoolName = $this->db->query("SELECT school_details.".$Name." as SchoolName FROM school_details  WHERE ID = '".$this->session->userdata('SchoolID')."' ")->row_array();
                            if(sizeof($QueryGetSchoolName) > 0 ){$SchoolName = $QueryGetSchoolName['SchoolName'];}
                            ?>
                    <?= $SchoolName ;   ?>
                    <!--    <input type="text" placeholder="اكتب هنا ماتريد البحث عنة">-->
                    <!--    <button class="btn square search-btn fal fa-search"></button>-->
                    <!-- Responsive Toggle -->
                    <!--    <button class="parent-toggle fal fa-search hidden-m-up btn square small primary"></button>-->
                </div>

                <br>
                <!-- Action Buttons -->
                <div class="action-btns action-bt">
                    <!-- Button -->
                    <!--<a href="<?php echo site_url('student/ask_teacher/ask_header/'.$ClassSubID); ?>" class="icon-btn fas fa-user-tie"><?php echo lang('am_ask_qus_teacher');?> </a>-->
                    <!-- Button -->
                    <!--<a href="#" class="icon-btn fas fa-bell">الاشعارات</a>-->
                    <!-- Button -->
                    <?php
                      if($query['messages']=="1"){  
                            $CI               = get_instance();
                            $CI->load->model('general_message_model');
                            $mess_data        = $CI->general_message_model->count_new_messages();
                            $count_message    = $mess_data ; 
                            $count_complaint  = $CI->general_message_model->count_new_complaint();
                            $count_suggestion = $CI->general_message_model->count_new_suggestion();
                            ?>
                    <a href="<?=site_url('chatting_new/conversation/index/0')?>" class="icon-btn fas fa-envelope"
                        id="message_count" data-notifications="<?php  echo $count_message;?>"><?php echo lang('am_new_message');?></a>
                    <a href="<?=site_url('chatting_new/conversation/index/1')?>" class="icon-btn fas fa-fire"
                        data-notifications1="<?php  echo $count_complaint;?>"><?php echo lang('Complaint');?></a>
                    <a href="<?=site_url('chatting_new/conversation/index/2')?>" class="icon-btn fas fa-handshake"
                        data-notifications1="<?php  echo $count_suggestion;?>"><?php echo lang('Suggestion');?></a>
                    <!-- Button -->
                    <?php
                                                $id =  $this->session->userdata('id');
                                                if ($query['ApiDbname'] == "SchoolAccExpert") { ?>
                    <a style="color:white !important" target="blank"
                        href='https://chat.<?= $_SERVER['HTTP_HOST']; ?>/api/login?id=<?php echo $id; ?>'
                        class="dropdown-toggle action-bt">
                        <i class="fa fa-comment"></i>
                    </a>
                    <?php } ?>
                    <?php } ?>
                    <?php $this->session->set_userdata('previous_page', uri_string()); ?>

                    <?php if($this->session->userdata('language') != 'arabic'): ?>
                    <a href="<?php echo site_url('home/home/set_lang/L/2'); ?>" class="icon-btn fas fa-language">AR</a>
                    <?php else: ?>
                    <a href="<?php echo site_url('home/home/set_lang/L/1'); ?>" class="icon-btn fas fa-language">EN</a>
                    <?php endif; ?>
                    <!-- Button -->
                    <a href="<?php echo site_url('home/login/log_out') ?>"
                        class="icon-btn fas fa-sign-out-alt"><?php echo lang( 'br_logout') ?></a>

                </div>

                <!-- // Action Buttons -->
            </div>

        </div>

        <style>
        .tornado-header.primary {
            <?php echo $query['home_color'] ?>
        }

        @media print {
            html {
                overflow: visible !important;
            }

            #print {
                width: 100vw;
            }

            .hidden-print {
                display: none !important;
            }
        }
        </style>



        <script type="text/javascript">
           
            var data = {
                "classId": <?=$this->session->userdata('classId')?>,
                "SemesterDate": <?=$this->session->userdata('currentSemesterID')?>,
                "rowLevelId": <?=$this->session->userdata('rowLevelId')?>,
                "schoolId": <?=$this->session->userdata('SchoolID')?>,
                "studentId": <?=$this->session->userdata('id')?>
            };
            
            function load_unseen_msg() {
            
            $.ajax({
    url: "https://chat.lms.esol.com.sa/student/notfication?apikey=chat.<?echo $_SERVER['SERVER_NAME'];?>",
    method: "GET",
    cache: false,
    data: data,
    success: function(response) {
        for (var key in response) {
            if (response.hasOwnProperty(key) && response[key].total_count != 0) {
                $('#' + key).attr('data-notifis', response[key].total_count);

                var countPerSubject = response[key].count_per_subject;
                for (var subjectId in countPerSubject) {
                    if (countPerSubject.hasOwnProperty(subjectId)) {
                        $('#' + key + '_' + subjectId).attr('data-notifis', countPerSubject[subjectId]);
                    }
                }
            }
        }
    },
    error: function(xhr, status, error) {
        console.error("An error occurred: " + error);
    }
});}
        load_unseen_msg();
        </script>
        <!--<script>-->
        <!--       setInterval(function () {-->
        <!--                $('.action-bt').load(location.href + ' .action-bt');-->
        <!--            }, 2000);-->
        <!--</script>-->
        <?php 
 if($query['ApiDbname']=="SchoolAccGheras"){ ?>
        <script>
        $(document).ready(function() {
            window.intervalID = setInterval(function() {
                window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
            }, 2700000);
        });
        $(document).click(function() {
            clearInterval(window.intervalID);
            window.intervalID = setInterval(function() {
                window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
            }, 2700000);

        });
        </script>
        <?php }else{ ?>
        <script>
        $(document).ready(function() {
            window.intervalID = setInterval(function() {
                window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
            }, 25200000);
        });
        $(document).click(function() {
            clearInterval(window.intervalID);
            window.intervalID = setInterval(function() {
                window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
            }, 25200000);

        });
        </script>
        <?php } ?>

        <script src="https://js.pusher.com/3.2/pusher.min.js"></script>

        <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('ea4bc3db1b4e7745bd8a', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('test');
        channel.bind('event', function(data) {
            load_unseen_msg();
            get_messages_count();
        });
        </script>

        <script>
        function get_messages_count() {
            $.ajax({
                url: "<?= site_url('chatting/conversation/count') ?>",
                    method: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#message_count').attr("data-notifications", data['count_message']);
                        console.log(data['count_message']);

                    }



                    // setTimeout(load_unseen_msg,2000);
                });}

         <?php 
         $get_zoom = $CI->setting_model->getUserGroup();
         if (is_array($get_zoom)) {
                foreach ($get_zoom as $Key => $group) { ?>
                    <script>
                        var channelname = "<?echo $_SERVER['SERVER_NAME'];?>Zoom<?php echo $group->ZoomPremissionID; ?>";
                        var channel = pusher.subscribe(channelname);
                        channel.bind('AddZoom', function (data) {
                        Swal.fire({
                            icon: 'info',
                            title: data['title'],
                            text: data['message'],
                            showCancelButton: false,
                            confirmButtonText: 'موافق',
                            reverseButtons: true
                        }).then((result) => {
                            //
                        

                    });
                    </script>
            <?php } } ?>

        <script>
            var channelname = "<? echo $_SERVER['SERVER_NAME'] . 'Class' . $get_subject_header[0]->ClassID. '-' . $get_subject_header[0]->SRowLevelID . '-'. $this->session->userdata('SchoolID'); ?>";
            var userchannel = "<? echo $_SERVER['SERVER_NAME'] . 'User' . $this->session->userdata('id'); ?>";
            var channel = pusher.subscribe(channelname);
            var userchannel = pusher.subscribe(userchannel);
            channel.bind('CreateExam', function (data) {
                            load_unseen_msg();
                Swal.fire({
                    icon: 'info',
                    title: 'إخطار بإضافة اختبار جديد',
                    text: data,
                    showCancelButton: false,
                    confirmButtonText: 'موافق',
                    reverseButtons: true
                }).then((result) => {
                    //
                });

            });


            channel.bind('CreateLesson', function (data) {
                            load_unseen_msg();
                Swal.fire({
                    icon: 'info',
                    title: 'إخطار بإضافة درس جديد',
                    text: data,
                    showCancelButton: false,
                    confirmButtonText: 'موافق',
                    reverseButtons: true
                }).then((result) => {
                    //
                });

            });

            channel.bind('CreateClericalHomeWork', function (data) {
                            load_unseen_msg();
                Swal.fire({
                    icon: 'info',
                    title: 'إخطار بإضافة وأجب تحريري جديد',
                    text: data,
                    showCancelButton: false,
                    confirmButtonText: 'موافق',
                    reverseButtons: true
                }).then((result) => {
                    //
                });

            });

            channel.bind('CreateWorksheet', function (data) {
                            load_unseen_msg();
                Swal.fire({
                    icon: 'info',
                    title: 'إخطار بإضافة ورقة عمل جديدة',
                    text: data,
                    showCancelButton: false,
                    confirmButtonText: 'موافق',
                    reverseButtons: true
                }).then((result) => {
                    //
                });

            });
            channel.bind('CreateAssignment', function (data) {
                            load_unseen_msg();
                Swal.fire({
                    icon: 'info',
                    title: 'إخطار بإضافة وأجب إلكتروني جديد',
                    text: data,
                    showCancelButton: false,
                    confirmButtonText: 'موافق',
                    reverseButtons: true
                }).then((result) => {
                    //
                });

            });

            userchannel.bind('askTeacher', function (data) {
                            load_unseen_msg();
                Swal.fire({
                    icon: 'info',
                    title: 'إخطار بالرد على استفسارك',
                    text: data,
                    showCancelButton: false,
                    confirmButtonText: 'موافق',
                    reverseButtons: true
                }).then((result) => {
                    //
                });

            });


        </script>

        <?
       if($this->session->flashdata('first_view')){ 
        ?>
            <script>  
            $('body').fireworks();
            Swal.fire('تبارك الله', 'وصلت إلى مستوى أعلى من النقاط ... واصل التقدم', 'success').then((result) => {
                if (result.value) {
                    location.reload();    
                    $('body').fireworks('destroy');

                }
            });
            </script>
        <?php
        }
        ?>
        <?php } ?>

        <script>


        var pusher = new Pusher('ea4bc3db1b4e7745bd8a', {
    cluster: 'mt1'
});
        var CloseExamchannelName = "<?=$_SERVER['SERVER_NAME'] . 'User'.$this->session->userdata('id')?>"

        var CloseExamchannel = pusher.subscribe(CloseExamchannelName);
        CloseExamchannel.bind('closeExam', function(data) {
            var examId = data.examID;
            var button = $('[data-examid="' + examId + '"]');
            
            if(button.length) {
                button.attr('disabled', 'disabled');
                button.removeAttr('href');
            }

    //         if(window.location.href.indexOf("student/answer_exam/show_exam") !== -1) {
    //     window.location.href = "<php echo site_url('student/cpanel/main_page'); ?>";
    // }
        });
  </script>
