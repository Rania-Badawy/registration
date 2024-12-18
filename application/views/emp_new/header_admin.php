<?php 
 $css_cpanel=$this->session->userdata('css_cpanel');?>

 <?php $js_cpanel=$this->session->userdata('js_cpanel');	  
 $lang          = $this->session->userdata('language');
 $Name          = 'Name_Ar' ;
 $JobTitleName  = lang('br_emp');
 if($this->session->userdata('language') == 'english'){$Name = 'Name_En' ;} 
 $CI                  = get_instance();
 $Lang           = $CI->session->userdata('language');
 $query=$this->db->query("select * from setting")->row_array();
 $querySchoolData=json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $query['ApiDbname'] . "/GetAllSchools"));
 
 ?>
 <!DOCTYPE html>

 <head>
     <html style="--primary-color: <?php echo $query['primary-color'];?>;--primary-hover:<?php echo $query['hover_color'];?>;--header-color:<?php echo $query['home_color']?>;--main-color2: <?php echo $query['main-color2'];?>;--main-color: <?php echo $query['main-color'];?>;">


     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

     <title><?php echo $this->session->userdata('contact_name') ?></title>


     <link href="<?php echo base_url(); ?>assets/css/cpanel_admin.css" rel="stylesheet">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">


     <meta name="keywords" content="school, soft ray, softray,<?php echo'سوفت راي, برنامج المدارس, المدرسة, المدارس';
?>" />

     <!-- Bootstrap -->
     <link href="<?php echo base_url(); ?>assets/new/css/bootstrap.min.css" rel="stylesheet">

     <!-- style -->
     <link href="<?php echo base_url(); ?>assets/new/css/style.css" rel="stylesheet">

     <?php  
        if($this->session->userdata('language') == 'english'){ ?>
     <link href="<?php echo base_url(); ?>assets/new/css/ltr.css" rel="stylesheet">
     <?php }else{ ?>
     <!-- Bootstrap rtl -->
     <link href="<?php echo base_url(); ?>assets/new/css/rtl.css" rel="stylesheet">
     <?php }
    ?>
     <!-- animate -->
     <link href="<?php echo base_url(); ?>assets/new/css/animate.min.css" rel="stylesheet">

     <!-- font-awesome -->
     <link href="<?php echo base_url(); ?>assets/new/css/font-awesome.css" rel="stylesheet">

     <!-- font-awesome-animation -->
     <link href="<?php echo base_url(); ?>assets/new/css/font-awesome-animation.css" rel="stylesheet">

     <!-- bootstrap-dropdownhover -->
     <?php /*?>
     <link href="<?php echo base_url(); ?>assets/new/css/bootstrap-dropdownhover.css" rel="stylesheet"> <?php */?>

     <!-- bootstrap-select -->
     <link href="<?php echo base_url(); ?>assets/new/css/bootstrap-select.css" rel="stylesheet">

     <!-- bootstrap-checkbox -->
     <?php /*?>
     <link href="<?php echo base_url(); ?>assets/new/css/build.css" rel="stylesheet"> <?php */?>

     <!-- fancybox -->
     <link href="<?php echo base_url(); ?>assets/new/fancybox-master/jquery.fancybox.min.css" rel="stylesheet" />
     <?php if($query['ApiDbname'] == 'SchoolAccElinjaz'){?>
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
     <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
     <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
     <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

     <style>
        .dropdown-menu li:hover,
        .dropdown-menu li a:hover,
        .bootstrap-select.btn-group .dropdown-menu>.active>a,
        .bootstrap-select.btn-group .dropdown-menu>.active>a:focus,
        .bootstrap-select.btn-group .dropdown-menu>.active>a:hover,
        .nav.navbar-nav .open>.dropdown-menu li:hover,
        .content_new .top_nv_new ul li:hover{
            background: var(--primary-color) !important;
        }
        .tornado-select .options-list li:not(:first-child):hover{
            background: var(--primary-color);
            color: #fff !important;
        }
        .dropdown-menu li:hover a{
            color: #fff !important;
        }
     .content_new .top_nv_new {
         <?php echo $query['home_color'] ?>
     }

     body {
         overflow-x: hidden;
         overflow-y: auto;
     }

     .nav.navbar-nav .dropdown-menu {
         right: 0;
     }

     .nav.navbar-nav .open>.dropdown-menu {
         display: flex;
         width: 500px;
         flex-wrap: wrap;
         justify-content: space-between;
         direction: rtl;
     }

     .nav.navbar-nav .open>.dropdown-menu li {
         width: 50%;
     }

     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(11) .dropdown-menu {
         left: 0;
     }

     @media screen and (min-width: 1201px) and (max-width: 1345px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(11) .dropdown-menu {
             right: 0 !important;
         }
     }

     @media screen and (min-width: 1346px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(11) .dropdown-menu {
             left: 0 !important;
         }
     }

     @media screen and (min-width: 1445px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(12) .dropdown-menu {
             left: 0;
         }
     }

     @media screen and (min-width: 1555px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(13) .dropdown-menu {
             left: 0;
         }
     }

     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(10) .dropdown-menu,
     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(9) .dropdown-menu,
     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(8) .dropdown-menu {
         left: 0;
     }
     </style>
     <?php if($this->session->userdata('language') == 'english'){ ?>
     <style>
     .nav.navbar-nav .dropdown-menu {
         left: 0 !important;
         right: unset !important;
     }

     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(11) .dropdown-menu,
     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(10) .dropdown-menu,
     .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(9) .dropdown-menu {
         right: 0 !important;
         left: unset !important;
     }

     @media screen and (min-width: 1201px) and (max-width: 1321px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(11) .dropdown-menu {
             left: 0 !important;
             right: unset !important;
         }
     }

     @media screen and (min-width: 1392px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(12) .dropdown-menu {
             right: 0 !important;
             left: unset !important;
         }
     }

     @media screen and (min-width: 1495px) {
         .nav.navbar-nav .dropdown.rtl-dr-d:nth-of-type(13) .dropdown-menu {
             right: 0 !important;
             left: unset !important;
         }
     }

     .navbar .dropdown-menu li a {
         white-space: break-spaces;
         line-height: 1.25;
     }
     </style>
     <?php } ?>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/new/js/jquery-2.1.1.js"></script>
     <script src="<?php echo base_url(); ?>assets/new/js/star-rating.js" type="text/javascript"></script>
     <style>
     @media screen and (min-width:1226px) and (max-width:1329px) {
         .stdC ul {
             right: 0 !important;
         }

         .users ul {
             left: 0 !important;
             right: unset !important;
         }
     }

     @media screen and (min-width:1357px) and (max-width:1670px) {

         .stdC ul,
         .users ul {
             left: 0 !important;
             right: unset !important;
         }

     }

     @media screen and (min-width: 1256px) and (max-width: 1395px) {
         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             right: 0 !important;
         }

         .navbar-nav .dropdown.rtl-dr-d .columns-2 {
             right: 0 !important;
         }
     }

     @media screen and (min-width: 1396px) and (max-width: 1492px) {
         .navbar-nav .dropdown.rtl-dr-d .columns-2 {
             right: 0 !important;
         }

         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             right: 0 !important;
         }
     }

     @media screen and (min-width: 1493px) and (max-width: 1644px) {

         .navbar-nav .dropdown.rtl-dr-d .columns-2,
         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             left: 0 !important;
         }

         .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
             right: 0 !important;
         }
     }

     @media screen and (min-width:1512px) and (max-width:1619px) {
         .navbar-nav .dropdown.rtl-dr-d .columns-2 {
             right: 0 !important;
             left: unset !important;
         }
     }

     @media screen and (min-width: 1645px) {

         .navbar-nav .dropdown.rtl-dr-d .columns-2,
         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             left: 0 !important;
         }

         .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
             right: 0 !important;
         }
     }
     </style>
     <?php if($this->session->userdata('language') == 'english'){ ?>
     <style>
     @media screen and (min-width:1201px) and (max-width:1329px) {
         .stdC ul {
             right: 0 !important;
             left: unset !important;
         }

         .users ul {
             left: 0 !important;
             right: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             left: 0 !important;
             right: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d .columns-2 {
             left: 0 !important;
             right: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
             left: 0 !important;
             right: unset !important;
         }
     }

     @media screen and (min-width: 1256px) and (max-width: 1395px) {
         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             left: 0 !important;
             right: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d .columns-2 {
             left: 0 !important;
             right: unset !important;
         }
     }

     @media screen and (min-width: 1396px) and (max-width: 1492px) {
         .navbar-nav .dropdown.rtl-dr-d .columns-2 {
             left: 0 !important;
             right: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             right: 0 !important;
             left: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
             left: 0 !important;
             right: unset !important;
         }
     }

     @media screen and (min-width: 1493px) and (max-width: 1644px) {

         .navbar-nav .dropdown.rtl-dr-d .columns-2,
         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             right: 0 !important;
             left: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
             left: 0 !important;
             right: unset !important;
         }
     }

     @media screen and (min-width: 1645px) {

         .navbar-nav .dropdown.rtl-dr-d .columns-2,
         .navbar-nav .dropdown.rtl-dr-d .columns-3 {
             left: 0 !important;
             right: unset !important;
         }

         .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
             left: 0 !important;
             right: unset !important;
         }
     </style>
     <?php } ?>
     <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
     <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">-->
     <!--<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->
     <!--<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>-->
     <!--<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>-->

 </head>


 <body>
     <div class="content_new white">

         <div style="background: <?php echo $query['home_color'];?>;--primary-hover:<?php echo $query['hover_color'];?>"
             class="top_nv_new">
             <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                 <div class="nav-logo text-center sm-p-left pull-right">
                     <?php $query=$this->db->query("select * from setting")->row_array(); ?>
                     <a class="navbar-brand" href="">
                         <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']?>"
                             alt="">
                     </a>
                 </div>
                 <ul class="nav navbar-nav nav_top w-auto pull-right">
                     <li class="dropdown dropdown-big" data-toggle="tooltip" data-placement="left"
                         title="<?php echo lang('br_inside_home') ?>">
                         <a href="<?php echo site_url('emp/cpanel') ?>">
                             <i class="fa fa-home"></i>
                         </a>
                     </li>
                     <li class="dropdown pull-right user-data" data-toggle="tooltip" data-placement="left"
                         title="<?php echo $this->session->userdata('contact_name') ?>">

                         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-user"></i>
                             <b class="caret"></b>
                         </a>

                         <!-- Dropdown menu -->

                         <ul class="dropdown-menu">

                             <li class="padd_ri">

                                 <a target="_blank" href="<?php echo site_url('contact/contact/edit_contact') ?>">

                                     <?php echo lang( 'br_edit_profile') ?>

                                     <i class="fa fa-spotify"></i>
                                 </a>

                             </li>

                             <li class="padd_ri">

                                 <a href="<?php echo site_url('home/login/log_out') ?>">

                                     <?php echo lang( 'br_logout') ?>

                                     <i class="fa fa-spotify"></i>

                                 </a>

                             </li>


                         </ul>

                     </li>


                     <?php $this->session->set_userdata('previous_page', uri_string()); ?>

                     <?php if($lang != 'arabic'): ?>


                     <li class="dropdown dropdown-big">

                         <a class="lang_in_st" data-toggle="tooltip" data-placement="left" title="AR"
                             href="<?php echo site_url('home/home/set_lang/L/2'); ?>">
                             <i class="fa fa-language"></i>




                         </a>

                     </li>
                     <?php else: ?>
                     <li class="dropdown dropdown-big">

                         <a class="lang_in_st" data-toggle="tooltip" data-placement="left" title="EN"
                             href="<?php echo site_url('home/home/set_lang/L/1'); ?>">
                             <i class="fa fa-language"></i>




                         </a>

                     </li>
                     <?php endif; ?>

                        <?php if($query['messages']==1 ){ ?>
                   
                     <li class="dropdown dropdown-big messages-dd leftonmobile" id="message_header"
                         data-toggle="tooltip" data-placement="left" title="<?php echo lang('am_new_message');?>">
                         <?php
						$CI                  = get_instance();
							 	 $CI->load->model('general_message_model');
                                    $mess_data = $CI->general_message_model->count_new_messages();
                                    $count_message=  $mess_data ; 
					?>

                         <a style="color:white !important" target="_blank"
                             href="<?=site_url('chatting_new/conversation/index/0')?>"
                             class="dropdown-toggle action-bt">

                             <i class="fa fa-envelope"></i>

                             <span class="badge  "><?php  echo $count_message;?></span>

                         </a>

                     </li>

                     <?php
                                                $id =  $this->session->userdata('id');
                                                if ($query['ApiDbname'] == "SchoolAccExpert") { ?>
                     <li class="dropdown dropdown-big">
                         <a style="color:white !important" target="blank"
                             href='https://chat.<?= $_SERVER['HTTP_HOST']; ?>/api/login?id=<?php echo $id; ?>'
                             class="dropdown-toggle action-bt">
                             <i class="fa fa-comment"></i>
                         </a>
                     </li>
                     <?php } ?>
                     <?php } ?>
                    
                     <li class="dropdown dropdown-big">
                         <a href="http://www.gmail.com/" class="lang_in_st" style=" padding: 13px 5px !important;">
                             <img src="<?php echo base_url(); ?>assets/images/gmail.png" style="width:20px;" />
                         </a>
                     </li>

                     <li class="se-st-22">
                         <?php
				  
				  if(sizeof($querySchoolData) > 0 )
			{
				?>
                         <select id="SchoolData" onChange="chang_school(this.value);" class="selecte_emp_father">
                             <?php 
				foreach($querySchoolData as $Key=>$QuerySchoolDate)
				{
					 $GetBranches    = get_branches();
                                    $school_per     = explode(",",$GetBranches);
									if (in_array($QuerySchoolDate->SchoolId, $school_per)) {
					?>
                             <option value="<?=  $QuerySchoolDate->SchoolId  ?>"
                                 <?php if($this->session->userdata('SchoolID') == $QuerySchoolDate->SchoolId ){echo 'selected' ;} ?>>
                                 <?= $QuerySchoolDate->SchoolName  ?>
                             </option>
                             <?php 
				}}
				?>
                         </select>
                         <script>
                         function chang_school(SchoolID) {
                             window.location = "<?= site_url('admin/cpanel/chang_school'); ?>/" + SchoolID;
                         }
                         </script>
                         <?php 
			}
			 ?>
                     </li>



                 </ul>

             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                 <ul class="nav navbar-nav nav_top pull-left new-ul" style="margin-top: 10px;">

                     
                     <?php
           $SchoolName = '' ;
           $QueryGetSchoolName = $this->db->query("SELECT SchoolName  FROM school_details  WHERE ID = '".$this->session->userdata('SchoolID')."' ")->row_array();
          if(sizeof($QueryGetSchoolName) > 0 ){$SchoolName = $QueryGetSchoolName['SchoolName'];}
           ?>
                     <li class="se-st-22">
                         <?= $SchoolName ;   ?>
                     </li>
                     <style>
                     .nav_top {
                         width: 100%;
                     }

                     .nav_top .se-st-22 {
                         background: #ffffff;
                         line-height: 30px;
                         margin-right: 2px;
                         padding: 5px 10px;
                         text-align: right;
                         font-family: unset;

                     }

                     .se-st-22 .form-control {
                         text-align: center
                     }
                     </style>

                 </ul>

             </div>

         </div>
         <!--//////// begining of header	-->
         <?php
  


  $query_sidebar = $this->db->query("SELECT permission_page.CatName ,permission_page.CatNum , permission_page.Icon
                                    FROM permission_page
                                	INNER JOIN group_page ON permission_page.ID = group_page.PageID 
                                	WHERE group_page.GroupID = '".$this->session->userdata('GroupID')."'  
                                    and permission_page.IsActive=1 and permission_page.active_system=1
                                	GROUP BY permission_page.CatNum ORDER BY permission_page.CatNum ASC
                                    ")->result();
	
	$querySubCat = $this->db->query("SELECT permission_page.PageUrl ,permission_page.PageName,permission_page.CatNum
     FROM permission_page
	 INNER JOIN group_page ON permission_page.ID = group_page.PageID 
	 WHERE group_page.GroupID = '".$this->session->userdata('GroupID')."' and permission_page.IsActive=1 and permission_page.active_system=1
	
    ")->result();

		?>

         <div class="clearfix"></div>
         <div class="navbar navbar-default" id="custom-bootstrap-menu" role="navigation">
             <div class="container-fluid">
                 <div class="navbar-header">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="sr-only">Toggle navigation</span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                     </button>
                 </div>
                 <div class="collapse navbar-collapse">
                     <ul class="nav navbar-nav" style="padding: 0">
                         <?php
					if(sizeof($query_sidebar)>0)
					{
					  foreach($query_sidebar as $Key=>$Cat)
					  {
                        $NameSpaceID = $this->db->query("SELECT NameSpaceID FROM permission_request WHERE permission_request.EmpID	= '".$this->session->userdata('id')."' ")->row_array()['NameSpaceID'];
                        if(!($this->session->userdata('GroupID')==98 && $NameSpaceID <= 0 && $Cat->CatNum ==7 ) ){
					   
					          ?>
                         <li class="dropdown rtl-dr-d">
                             <a class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown"
                                 href="#"><?php echo lang($Cat->CatName );?> <i class="fa fa-spotify"></i></a>

                             <ul class="dropdown-menu ">
                                 <?php if(sizeof($querySubCat)>0)
                    					{
                    					  foreach($querySubCat as $Key=>$SubCat)
                    					   { 
                    					     if($Cat->CatNum==$SubCat->CatNum){
                    					  ?>
                                 <?php 
                    					   if((substr($SubCat->PageUrl, 0, 12 ) === "emp/requests")||(substr($SubCat->PageUrl, 0, 25 ) === "chatting_new/conversation")){?>
                                 <li><a target="_blank"
                                         href="<?php echo site_url($SubCat->PageUrl ) ?>"><?php echo lang($SubCat->PageName );?>
                                         <i class="fa fa-spotify"></i></a></li>
                                 <?php }else{ ?>
                                 <li><a href="<?php echo site_url($SubCat->PageUrl ) ?>"><?php echo lang($SubCat->PageName );?>
                                         <i class="fa fa-spotify"></i></a></li>
                                 <?php } } }}?>
                             </ul>
                         </li>
                         <?php
					  
					  }	}}?>
                        

                     </ul>

                 </div>
             </div>
         </div>

         <style>
         .navbar-default-bg-new2-emp .navbar-nav-bottom>div>ul>li {
             padding: 0;
         }

         .navbar-nav-bottom>.row>ul>li>a {
             color: rgba(31, 31, 31, 1) !important;
             padding: 10px 13px !important;
         }

         .navbar-nav-bottom>.row>ul>li>a i {
             width: auto !important;
             float: none !important;
             font-size: 14px !important;
             color: rgba(31, 31, 31, 1) !important;
         }

         .navbar-default-bg-new .navbar-nav-st {
             float: right;
             width: 100%;
         }

         .rating-container .empty-stars {
             color: #fff;
         }

         .rating-xl {
             font-size: 1.89em;
             margin-top: 5px;
         }

         @media (min-width: 768px) {
             .navbar-default-bg-new2-emp .navbar-nav-bottom>div>ul>li {
                 float: right;
             }

         }
         </style>


         <?php $query=$this->db->query("select * from setting")->row_array();
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
             }, 21600000);
         });
         $(document).click(function() {
             clearInterval(window.intervalID);
             window.intervalID = setInterval(function() {
                 window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
             }, 21600000);

         });
         </script>
         <?php } ?>

         <script>
         if (window.history.replaceState) {
             window.history.replaceState(null, null, window.location.href);
         }
         </script>