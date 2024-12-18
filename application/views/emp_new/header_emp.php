<?php 
$CI                  = get_instance();

$css_cpanel       =$CI->session->userdata('css_cpanel');?>

<?php   $js_cpanel      = $CI->session->userdata('js_cpanel');
	    $lang           = $CI->session->userdata('language');	   
	    $UID            = $CI->session->userdata('id');
 	   ?>

 <?php $query=$this->db->query("select * from setting")->row_array(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl" style="--primary-color: <?php echo $query['primary-color'];?>;--primary-hover:<?php echo $query['hover_color'];?>">
    <head>
        <!-- Required Meta Tags -->
        <meta name="language" content="ar">
        <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?= lang('description')?>">
        <meta name="keywords" content="<?= lang('keywords')?>">
        <meta name="author" content="<?= lang('author')?>">
        <?php $query1=$this->db->query("select Name from contact where ID =".$this->session->userdata('id')."")->row_array(); ?>
        <title><?php echo $query1['Name']?></title>
        <!-- Other Meta Tags -->
        <!--<meta name="robots" content="index, follow" />-->
        <!--<meta name="copyright" content="Sitename Goes Here">-->
        
		<link rel="shortcut icon" type="image/png"  href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']?>">
        <!-- Required CSS Files -->
        <link href="<?php echo base_url(); ?>assets_new/css/fontawsome.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/table_style.css">
           <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/load.css">
         
        <link href="<?php echo base_url(); ?>assets_new/css/select2.min.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']?>" />
        <?php if($this->session->userdata('language') != 'english'){ ?>
        <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado-rtl.css" rel="stylesheet" />
        <?php }else{ ?>
        <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado.css" rel="stylesheet" /> 
        <?php } ?>
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css"/>
        <link href="<?php echo base_url(); ?>assets_new/css/inbox-style.css" rel="stylesheet" />
        <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script>
        <script src="<?php echo base_url(); ?>assets_emp/exam/@wiris/mathtype-generic/wirisplugin-generic.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets_new/js/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/tiny_mce.js"></script>
        <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- tui image editor -->
<style>
    .acc{
   content: attr(data-notifis);
    font-size: 10px;
    line-height: 16px;
    width: 16px;
    height: 16px;
    background: var(--danger-color);
    color: #FFF;
    text-align: center;
    border-radius: 50%;
    position: absolute;
    
    left: 20px;
    }
    .tornado-header.primary{
        <?php echo $query['home_color'] ?>
     }
     .content_new .top_nv_new{
        <?php echo $query['home_color'] ?>
     }
</style>

         <?php if($this->session->userdata('language') != 'english'){ $dir="rtl";} else{$dir="ltr";}?>
        <script type="text/javascript">
        tinyMCE.init({
            mode : "specific_textareas",
            editor_selector : "mceEditor",
            theme : "advanced",
            theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg,,tiny_mce_wiris_formulaEditor,tiny_mce_wiris_formulaEditorChemistry",
            theme_advanced_buttons3 : "",
            theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            plugins : 'asciimath,asciisvg,table,inlinepopups,media,tiny_mce_wiris',
            AScgiloc : 'https://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
            ASdloc : 'https://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
            directionality: 'auto',      
            content_css : "<?php echo base_url()?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
        });
        </script>
    </head>
     <body>
         <?php	   
        $CI                  = get_instance();
        $CI->load->model('admin/setting_model');
        $UID      = $this->session->userdata('id');
        $contact_details = $CI->db->query("select Name,Gender,Number_ID,mail,Address,Phone,Mobile,img,Nationality_ID,User_Name,Password,Name_en from contact where ID=$UID")->row_array();
         $get_api_setting=$CI->setting_model->get_api_setting(); 
        $this->ApiDbname=$get_api_setting[0]->{'ApiDbname'};   
        ?>
        <!-- Layout Wraper -->
        <div class="row no-guuter row-reverse">
            <!-- Sidebar -->
            <div class="fixed-sidebar col-12 mxw-270 white-bg nested-menu hidden-print">
                <!-- Sidebar Toggle -->
                <a href="#" class="btn square parent-toggle far fa-bars sidebar-toggle"></a>
                <!-- Site Logo -->
                <!-- User Info -->
                <div class="user-info tx-align-center" style="margin-top: 31px;">
                    <!-- Avatar -->
                    <?php if(!empty($contact_details['img'])){?>
                    <img  src="<?php echo base_url()?>assets/user_data/<?php echo $contact_details['img'];?>" alt="" class="avatar from-image-final">
                    <?php } else { ?> 
                    <img src="<?php echo base_url(); ?>intro/images/school_logo/man1-avatar.png" alt="" class="avatar from-image-final">
                    <?php } ?>
                    <!-- Username -->
                    <h3><?php echo $this->session->userdata('contact_name')?><a href="<?php echo site_url('contact/contact/edit_contact') ?>" class="btn small circle far fa-edit"></a></h3>
                    <!-- ID -->
                    <span class="small-text gray-color">ID : <?php echo $contact_details['Number_ID'];?></span>
                    <!-- Rating -->
                    <div class="stars gray-color">
                        <i class="fas fa-star warning-color"></i>
                        <i class="fas fa-star warning-color"></i>
                        <i class="fas fa-star warning-color"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <!-- // Rating -->
                </div>
                

            </div>
             <!-- Page Wraper -->
            <div class="page-wraper">
                <!-- Header -->
                <div class="tornado-header primary hidden-print">
                    <div class="container-fluid">
                        <!-- Search Box -->
                         
                        <div class="search-box form-ui small" style="width: fit-content !important;">
                            <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']?>" alt="" style="width: 44px;">
                            
                            
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
                            
                        </div>
                         <?php 
                             $GetStudentID_header = $this->db->query("SELECT DISTINCT contact.ID , contact.Token
    									   FROM student
    									   INNER JOIN contact 
    									   ON student.Contact_ID = contact.ID 
    									   WHERE contact.IsActive = 1 and student.Father_ID = '".$this->session->userdata('id')."'
    									  ")->row_array() ; 	  
    									  
    					    $sonID         = $GetStudentID_header['ID'];
                            $sonToken      = $GetStudentID_header['Token'];
                             ?>
                        <!-- Action Buttons -->
                        <br> 
                         
                        <div class="action-btns action-bt">
                            
                            
                            
                            <?php $this->session->set_userdata('previous_page', uri_string()); ?>
                            
                          
                            <!-- Button -->
                            <a href="<?php echo site_url('home/login/log_out') ?>" class="icon-btn fas fa-sign-out-alt"><?php echo lang( 'br_logout') ?></a>
                             
                        </div>
                        <!-- // Action Buttons -->
                    </div>
                </div>
                <!--<div class="loading_div" id="loadingDiv" ></div>-->

                <style>

                @media print {
                    html {
        overflow: visible !important;
    }               #print { width: 100vw;}
                    .hidden-print {
                        display: none !important;
                  }
                }
                  </style>
<!--<script type="text/javascript">-->
 
<!--    function load_unseen_msg() {-->
<!--                var auto_refresh = setInterval(function () {-->
<!--                $('.action-bt').load(location.href + ' .action-bt');-->
<!--            }, 2000);-->
<!--    }-->
<!--    load_unseen_msg();-->
<!--</script>-->
  <?php $query=$this->db->query("select * from setting")->row_array();
 if($query['ApiDbname']=="SchoolAccGheras"){ ?>
<script>
$(document).ready(function(){
    window.intervalID= setInterval(function(){
    window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
}, 2700000);
});
$(document).click(function () {
    clearInterval(window.intervalID);
    window.intervalID=setInterval(function(){
    window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
}, 2700000);
    
});
</script>
<?php }else{ ?>
<script>
$(document).ready(function(){
    window.intervalID= setInterval(function(){
    window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
}, 25200000);
});
$(document).click(function () {
    clearInterval(window.intervalID);
    window.intervalID=setInterval(function(){
    window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
}, 25200000);
    
});
</script>
<?php } ?>