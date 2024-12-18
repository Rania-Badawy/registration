

    <!DOCTYPE html>

    <html>

    <head>

        <title>
            <?php echo $this->session->userdata('contact_name').'&nbsp;'.$NameFather ?>
        </title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">

        <meta name="keywords" content="school, soft ray, softray, سوفت راي, برنامج المدارس, المدرسة, المدارس" />

        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/new/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap rtl -->
        <link href="<?php echo base_url(); ?>assets/new/css/rtl.css" rel="stylesheet">

        <!-- style -->
        <link href="<?php echo base_url(); ?>assets/new/css/style.css" rel="stylesheet">

        <!-- animate -->
        <link href="<?php echo base_url(); ?>assets/new/css/animate.min.css" rel="stylesheet">

        <!-- font-awesome -->
        <link href="<?php echo base_url(); ?>assets/new/css/font-awesome.css" rel="stylesheet">

        <!-- font-awesome-animation -->
        <link href="<?php echo base_url(); ?>assets/new/css/font-awesome-animation.css" rel="stylesheet">

        <!-- bootstrap-dropdownhover -->
        <link href="<?php echo base_url(); ?>assets/new/css/bootstrap-dropdownhover.css" rel="stylesheet">

        <!-- bootstrap-select -->
        <link href="<?php echo base_url(); ?>assets/new/css/bootstrap-select.css" rel="stylesheet">

        <!-- bootstrap-checkbox -->
        <link href="<?php echo base_url(); ?>assets/new/css/build.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/new/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/new/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/new/js/star-rating.js" type="text/javascript"></script>

    </head>

    <body>

        <div class="warper-ds">
            <div id="wrapper">
                <div class="overlay"></div>

                <nav class="navbar navbar-inverse navbar-fixed-top"  id="sidebar-wrapper" role="navigation">
                    <ul class="nav sidebar-nav">

                        <?php /*?>
                            <li>
                                <a href="" class="faa-parent animated-hover">
                                    <i class="fa fa-home faa-float"></i>
                                    <div class="clearfix"></div>
                                    <span><?php echo lang('br_inside_home') ?></span>
                                </a>
                            </li>
                            

                                <li>
                                    <a href="<?php echo site_url('student/class_table'); ?>" class="faa-parent animated-hover">
                                        <i class="fa fa-table faa-float"></i>
                                        <span><?php echo lang('br_class_table_t'); ?></span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo site_url('student/class_table/plan_week'); ?>" class="faa-parent animated-hover">
                                        <i class="fa fa-calendar faa-float"></i>
                                        <span><?php echo lang('br_plan_week'); ?></span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                        <i class="fa fa-envelope faa-float"></i>
                                        <b class="caret"></b>
                                        <span><?php echo lang('am_mailbox');?> </span>
                                    </a>
                                    <ul class="dropdown-menu ">
                                        <li>
                                            <a href="<?php echo site_url('student/message') ?>">
                                                <?php echo lang('am_new_message');?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('student/message/show_incoming_messages') ?>">
                                                <?php echo lang('am_incoming_messages');?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('student/message/show_sent_message') ?>">
                                                <?php echo lang('am_outgoing_messages');?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="<?php echo site_url('student/room_educational'); ?>" class="faa-parent animated-hover">
                                        <i class="fa fa-television faa-float"></i>
                                        <span><?php echo lang('br_room');?></span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                        <i class="fa fa-university faa-float"></i>
                                        <b class="caret"></b>
                                        <span><?php echo lang('br_e_library'); ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('student/e_library'); ?>">
                                                <?php echo lang('er_MethodSubjects'); ?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('student/e_library/NMSubjects'); ?>">
                                                <?php echo lang('er_NonMethodSubjects'); ?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                        <i class="fa fa-th-large faa-float"></i>
                                        <b class="caret"></b>

                                        <span><?php echo lang('am_models');?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('model/model/model_list')?>">
                                                <?php echo lang('am_models_list');?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('model/model/my_model_list') ?>">
                                                <?php echo lang('am_my_models_list');?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown" href="#">
                                        <i class="fa fa-list-alt faa-float"></i>
                                        <b class="caret"></b>
                                        <span><?php echo lang( 'er_Forum');?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('student/forum') ?>">
                                                <?php echo lang( 'er_Forum');?> <i class="fa fa-spotify"></i></a>
                                        </li>
                                    </ul>
                                </li>
<?php */?>
                    </ul>
                    <!--/.navbar-collapse-->
                </nav>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                
<?php /*?>       <div class="emp_tools">
		  <a href="#">
		  <i><span></span><span></span><span></span></i>
		  <div class="clearfix"></div> 
		  	<?=lang('am_Teacher_Tools');?> 
		  </a>
	   </div> <?php */?>
		   
	<style>
	.nav_top .se-st-22 {
			padding: 9px 10px;
		}
	</style>
                <div class="content_new white">

                    <div class="top_nv_new">
                       
        
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		   <?php $query=$this->db->query("select * from setting")->row_array();?>
           <div class="nav-logo  text-center sm-p-left pull-right">  
				 <a class="navbar-brand" href="#">
				   <img src="https://lms.esol.com.sa/intro/images/school_logo/<?php echo $query['Logo']?>" />
				 </a>   
		   </div>
		   <?php /*?>
    <ul class="nav navbar-nav heddin-dds nav_top w-auto pull-right" style="display:none">  
               <!--------------------------اسم المدرسة --------------------------------------------->
			   <?php
			   $SchoolName = '' ;
			   $QueryGetSchoolName = $this->db->query("SELECT SchoolName  FROM school_details  WHERE ID = '".$this->session->userdata('SchoolID')."' ")->row_array();
			  if(sizeof($QueryGetSchoolName) > 0 ){$SchoolName = $QueryGetSchoolName['SchoolName'];}
			   ?>
               <li class="se-st-22" >
                  <?= $SchoolName ;   ?>
               </li>
      
               
            <!--------------------------اسم المدرسة --------------------------------------------->
		<li>
			
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
		</li>
	</ul> */?>
    <ul class="nav navbar-nav nav_top w-auto pull-left">  
              
				<li class="dropdown pull-right user-data" data-toggle="tooltip" data-placement="right" title="<?php echo $this->session->userdata('contact_name') ?>">

					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<b class="caret"></b>
					</a>

					<!-- Dropdown menu -->
<style>
    .pull-right>.dropdown-menu {
        left: 0 !important;
        right: auto !important;
    }
</style>
					<ul class="dropdown-menu ">
<?php /*?>     
						<li class="padd_ri">

							<a href="<?php echo site_url('contact/contact/edit_contact') ?>">

								<?php echo lang( 'br_edit_profile') ?>

									<i class="fa fa-spotify"></i>
							</a>

						</li><?php */?>

						<li class="padd_ri">

							<a href="<?php echo site_url('home/login/log_out') ?>">

								<?php echo lang( 'br_logout') ?>

									<i class="fa fa-spotify"></i>

							</a>

						</li>

					</ul>

				</li>
<?php /*?>

				<li class="dropdown pull-right user-data" data-toggle="tooltip" data-placement="left" title="<?php echo lang('br_inside_home') ?>">
					<a href="<?php echo site_url('student/cpanel') ?>">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li class="dropdown pull-right user-data" data-toggle="tooltip" data-placement="left" title="<?php echo lang('Notifications') ?>">
					<?php  $this->load->view('notification_header'); ?>
				</li>

				<!-- Upload to server link. Class "dropdown-big" creates big dropdown -->

				<?php $this->session->set_userdata('previous_page', uri_string()); ?>

					<?php if($lang != 'arabic'): ?>
						<li class="dropdown dropdown-big">

							<a class="lang_in_st" data-toggle="tooltip" data-placement="left" title="AR" href="<?php echo site_url('home/home/set_lang/L/1'); ?>">
								<i class="fa fa-language"></i>

							</a>

						</li>
						<?php else: ?>
							<li class="dropdown dropdown-big">

								<a class="lang_in_st" data-toggle="tooltip" data-placement="left" title="EN" href="<?php echo site_url('home/home/set_lang/L/2'); ?>">
									<i class="fa fa-language"></i>

								</a>

							</li>
							<?php endif; ?>

								<!-- Message button with number of latest messages count-->
								<script>
									setInterval(function() {
										$.ajax({
											type: "POST",
											url: "<?php echo site_url('student/message/message_header') ?>",
											data: {},
											cache: false,
											success: function(html) {
												$('#message_header').html(html);
											}
										});
									}, 3000);
								</script>
								<li class="dropdown dropdown-big messages-dd leftonmobile" id="message_header" data-toggle="tooltip" data-placement="left" title="<?php echo lang('am_new_message');?>">
									<?php
		$CI                  = get_instance();
		$CI->load->model('student/message_model');
		$mess_data = $CI->message_model->show_incoming_messages_new($CI->session->userdata('language')); 
		if($mess_data!=0){$count_message= count($mess_data);}else{$count_message= 0;}
	?>
										<a data-toggle="dropdown" href="#" class="dropdown-toggle">

											<i class="fa fa-envelope-o"></i>

											<span class="badge"> <?php echo $count_message;?></span>

										</a>
										<?php if($count_message!=0){?>
											<ul class="dropdown-menu">

												<li class="dropdown-header padless">

													<!-- Heading - h5 -->

													<h5>

					<i class="fa fa-envelope-alt"></i><?php echo lang('am_message');?></h5>

													<!-- Use hr tag to add border -->

												</li>
												<?php
				function Cut($string, $max_length){
				 $string=strip_tags($string);
				if (strlen($string) > $max_length){
				$string = substr($string, 0, $max_length);
				$pos = strrpos($string, " ");
				if($pos === false) {
				return substr($string, 0, $max_length)."...";
				}

				return substr($string, 0, $pos)."...";
				}else{
				return $string;
				}
				}
				$CI                  = get_instance();
				$CI->load->model('student/message_model');
				$mess_data = $CI->message_model->show_incoming_messages_new($CI->session->userdata('language'));
				foreach($mess_data as $key=>$item){
					$title           =$item->title;
					$toID            =$item->toID;
					$fromID            =$item->fromID;
					$message         =$item->message;
					$message_id      =$item->message_ID;
					$Date            =$item->Date;
			?>
													<li>
														<!-- List item heading h6 -->
														<h6>
				   <a href="<?php echo site_url('student/message/show_incoming_messages_id/'.$message_id) ?>"><?php echo $title?></a>
				</h6>
														<!-- List item para -->
														<p>
															<?php echo Cut($message,80)?>
														</p>
													</li>
													<?php }?>
														<li>
															<div class="drop-foot">
																<a href="<?php echo site_url('student/message/show_incoming_messages') ?>">مشاهدة الكل</a>
															</div>
														</li>

											</ul>
											<?php }?>
								</li>
								<!-- Members button with number of latest members count -->

								<li class="dropdown dropdown-big">
									<a href="http://www.gmail.com/" class="lang_in_st" style=" padding: 13px 5px !important;">
	<img src="<?php echo base_url(); ?>assets/images/gmail.png" style="width:20px;" />
	</a>
								</li>

									<?php /*?>
										<li class="gift-count pull-left">
											<img src="<?php echo base_url(); ?>assets/new/images/gift.png" alt="//" />
											<div class="arrow_box">
												25
											</div>
										</li>
										<li class="rating-co pull-left">
											<input id="input-21c" value="0" type="number" class="rating" min=0 max=10 step=1 data-size="xl" data-stars="10">
										</li>
										<?php */?>

			</ul>
      </div>
 <?php /*?>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <ul class="nav navbar-nav nav_top pull-left new-ul">
   			<li class="gift-ds">
				   <a href="#">
				   	<b class="badge">25</b>
					   <img src="<?php echo base_url(); ?>assets/new/images/gift-new.png" />
				   </a>
   			</li>
			<li class="rating">
		  		<h4>المستوي</h4>
			  <input type="radio" id="star10" name="rating" value="10" /><label for="star10" title="Rocks!">5 stars</label>
			  <input type="radio" id="star9" name="rating" value="9" /><label for="star9" title="Rocks!">4 stars</label>
			  <input type="radio" id="star8" name="rating" value="8" /><label for="star8" title="Pretty good">3 stars</label>
			  <input type="radio" id="star7" name="rating" value="7" /><label for="star7" title="Pretty good">2 stars</label>
			  <input type="radio" checked id="star6" name="rating" value="6" /><label for="star6" title="Meh">1 star</label>
			  <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Meh">5 stars</label>
			  <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Kinda bad">4 stars</label>
			  <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Kinda bad">3 stars</label>
			  <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Sucks big tim">2 stars</label>
			  <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
			</li>    	
          </ul>
      </div>
      
    <a role="button" class="btn btn-p-a" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
	  	<i class="fa fa-bars"></i>
	</a>

	<?php */?>
	</div>

	
    <div class="clearfix"></div>
     <?php /*?>
<div class="navbar navbar-default" id="custom-bootstrap-menu" style="margin-bottom:0 !important" role="navigation">
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
                <li>
                    <a href="<?php echo site_url('student/message') ?>">
                        <i class="fa fa-spotify"></i> <?php echo lang('am_new_message');?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('student/message/show_incoming_messages') ?>">
                       <i class="fa fa-spotify"></i> <?php echo lang('am_incoming_messages');?> </a>
                </li>
                <li>
                    <a href="<?php echo site_url('student/message/show_sent_message') ?>">
                       <i class="fa fa-spotify"></i> <?php echo lang('am_outgoing_messages');?> </a>
                </li>
            </ul>
        </div>    
    </div> 
</div>
	<?php */?>
<div class="collapse in collapsing-ds heddin-dds" style="display:none" id="collapseExample">
     <div class="content margin-top-none container-page">  
			<nav class="navbar navbar-default navbar-default-bg-new navbar-default-bg-new2-emp" role="navigation">
	    <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	        </button>


	    </div>
			<div class="collapse navbar-collapse navbar-nav-bottom-edit navbar-nav-bottom" id="bs-example-navbar-collapse-2">
          <div class="row"> 
	        <ul class="nav navbar-nav">

                                        <li>
                                            <div class="dropdown icon-link icon-link-search">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dLabel">

                                                    <?php if($get_subject_header!=0){
 				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID = $row->ClassSubID;
					$SRowLevelID = $row->SRowLevelID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/lessons/get_lessons_header/'.$ClassSubID.'/'.$SRowLevelID); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>

                                                        <?php }}?>
                                                </ul>
                                            </div>
                                            <div class="dropdown pull-right">
                                                <a id="dLabel" href="#">
                                                    <div class="clearfix"></div> 
											<span><?php echo lang('er_lessons');?> </span>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown icon-link icon-link-plus">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dLabel">

                                                    <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/e_library/index/'.$ClassSubID); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>
                                                        <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                </ul>
                                            </div>
                                            <div class="dropdown pull-right">
                                                <a id="dLabel" href="#">
                                                    <div class="clearfix"></div>
                                                    <span><?php echo lang('br_e_library');?> </span>
                                                </a>
                                            </div>

                                        </li>

                                        <li>
                                            <div class="dropdown icon-link icon-link-plus">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                    <?php if($get_subject_header!=0){ 
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/ask_teacher/ask_header/'.$ClassSubID.'/0'); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>
                                                        <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                </ul>

                                            </div>
                                            <div class="dropdown icon-link icon-link-plus">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-plus-circle"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                    <?php if($get_subject_header!=0){ 
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/ask_teacher/ask_header/'.$ClassSubID.'/'.$ClassSubID); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>
                                                        <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                </ul>
                                            </div>
                                            <div class="dropdown pull-right">
                                                <a id="dLabel" href="#" style="cursor:text">
                                                    <div class="clearfix"></div>
                                                    <span><?php echo lang('am_ask_qus_teacher');?> </span>
                                                </a>
                                            </div>

                                        </li>

                                        <li>
                                            <div class="dropdown icon-link icon-link-plus">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                    <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/clerical_homework/homework_header/'.$ClassSubID); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>
                                                        <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                </ul>
                                            </div>
                                            <div class="dropdown pull-right">
                                                <a id="dLabel" href="#">
                                                    <div class="clearfix"></div>
                                                    <span><?php echo lang('am_clerical_homework');?> </span>
                                                </a>
                                            </div>

                                        </li>

                                        <li>
                                            <div class="dropdown icon-link icon-link-plus">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                    <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/answer_homework/answer_homework_header/'.$ClassSubID); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>
                                                        <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                </ul>
                                            </div>
                                            <div class="dropdown pull-right">
                                                <a id="dLabel" href="#">
                                                    <div class="clearfix"></div>
                                                    <span><?php echo lang('am_homework');?> </span>
                                                </a>

                                        </li>

                                        <li>
                                            <div class="dropdown icon-link icon-link-plus">
                                                <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                    <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                        <li>
                                                            <a href="<?php echo site_url('student/answer_exam/answer_exam_header/'.$ClassSubID); ?>">
                                                                <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                        </li>
                                                        <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                </ul>
                                            </div>
                                            <div class="dropdown pull-right">
                                                <a id="dLabel" href="#">
                                                    <div class="clearfix"></div>
                                                    <span><?php echo lang('Exams');?> </span>
                                                </a>

                                            </div>
                                        </li>

                                        <?php /*?>
                                            <li>
                                                <div class="dropdown icon-link icon-link-plus">
                                                    <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-search"></i>
                                                    </a>

                                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                        <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                            <li>
                                                                <a href="<?php echo site_url('student/answer_exercise/answer_exam_header/'.$ClassSubID); ?>">
                                                                    <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                            </li>
                                                            <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                    </ul>
                                                </div>
                                                <div class="dropdown pull-right">
                                                    <a id="dLabel" href="#">
                                                        <div class="clearfix"></div>
                                                        <span>التدريبات</span>
                                                    </a>

                                                </div>
                                            </li>
                                            <?php */?>
                                                <?php /*?>
                                                    <li>
                                                        <div class="dropdown icon-link icon-link-plus">
                                                            <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-search"></i>
                                                            </a>

                                                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                                <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					$ClassSubID   = $row->ClassSubID;
					?>
                                                                    <li>
                                                                        <a href="<?php echo site_url('student/answer_competitions/answer_exam_header/'.$ClassSubID); ?>">
                                                                            <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                                    </li>
                                                                    <?php }}else{
					echo '<li><p>'.lang('br_p_add_sub').'</p></li>';
					}?>
                                                            </ul>
                                                        </div>
                                                        <div class="dropdown pull-right">
                                                            <a id="dLabel" href="#">
                                                                <div class="clearfix"></div>
                                                                <span>المسابقات </span>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <?php */?>
                                                        <?php /*?>
                                                            <li>
                                                                <a href="#" class="faa-parent animated-hover">
                                                                    <div class="clearfix"></div>
                                                                    <span><?php echo lang('br_eval_teacher');?> </span>
                                                                </a>

                                                                <div class="dropdown icon-link icon-link-search">
                                                                    <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>

                                                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                                        <?php if($get_subject_header!=0){
				foreach($get_subject_header as $row){
					$ClassSubName = $row->ClassSubName;
					?>
                                                                            <li>
                                                                                <a href="<?php echo site_url('student/evaluation_teacher'); ?>">
                                                                                    <?php echo $ClassSubName ;?> <i class="fa fa-spotify"></i></a>
                                                                            </li>
                                                                            <?php }}?>
                                                                    </ul>
                                                                </div>

                                                            </li>
                                                            <?php */?>

                                                                <?php /*?>
                                                                    <li>
                                                                        <a href="" class="faa-parent animated-hover">
                                                                            <i class="fa fa-home faa-float"></i>
                                                                            <div class="clearfix"></div>
                                                                            <span><?php echo lang('br_inside_home') ?></span>
                                                                        </a>
                                                                    </li>
                                                                    <?php */?>
                                                                        <?php /*?>
                                                                            <li>
                                                                                <a href="<?php echo site_url('student/class_table'); ?>" class="faa-parent animated-hover">
                                                                                    <i class="fa fa-table faa-float"></i>
                                                                                    <div class="clearfix"></div>
                                                                                    <span><?php echo lang('br_class_table_t'); ?></span>
                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a href="<?php echo site_url('student/class_table/plan_week'); ?>" class="faa-parent animated-hover">
                                                                                    <i class="fa fa-calendar faa-float"></i>
                                                                                    <div class="clearfix"></div>
                                                                                    <span><?php echo lang('br_plan_week'); ?></span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="dropdown">
                                                                                <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                                                                    <i class="fa fa-envelope-o faa-float"></i>
                                                                                    <div class="clearfix"></div>
                                                                                    <span><?php echo lang('am_mailbox');?> </span>
                                                                                    <b class="caret"></b> </a>
                                                                                <ul class="dropdown-menu ">
                                                                                    <li class="border-none">
                                                                                        <a class="btn btn-danger" href="<?php echo site_url('student/message') ?>">
                                                                                            <?php echo lang('am_new_message');?>
                                                                                        </a>
                                                                                    </li>
                                                                                    <div class="clearfix"></div>
                                                                                    <span class="nav-title"><?php echo lang('am_mailbox');?></span>
                                                                                    <div class="clearfix"></div>
                                                                                    <li>
                                                                                        <a href="<?php echo site_url('student/message/show_incoming_messages') ?>">
                                                                                            <?php echo lang('am_incoming_messages');?> <i class="fa fa-spotify"></i></a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="<?php echo site_url('student/message/show_sent_message') ?>">
                                                                                            <?php echo lang('am_outgoing_messages');?> <i class="fa fa-spotify"></i></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>

                                                                            <li>
                                                                                <a href="<?php echo site_url('student/room_educational'); ?>" class="faa-parent animated-hover">
                                                                                    <i class="fa fa-desktop faa-float"></i>
                                                                                    <div class="clearfix"></div>
                                                                                    <span><?php echo lang('br_room');?></span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="dropdown">
                                                                                <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                                                                    <i class="fa fa-th-large faa-float"></i>
                                                                                    <div class="clearfix"></div>
                                                                                    <span><?php echo lang('am_models');?></span>
                                                                                    <b class="caret"></b>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li>
                                                                                        <a href="<?php echo site_url('model/model/model_list')?>">
                                                                                            <?php echo lang('am_models_list');?> <i class="fa fa-spotify"></i></a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="<?php echo site_url('model/model/my_model_list') ?>">
                                                                                            <?php echo lang('am_my_models_list');?> <i class="fa fa-spotify"></i></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li class="dropdown">
                                                                                <a class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown" href="#">
                                                                                    <i class="fa fa-columns faa-float"></i>
                                                                                    <div class="clearfix"></div>
                                                                                    <span><?php echo lang( 'er_Forum');?></span>
                                                                                    <b class="caret"></b>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li>
                                                                                        <a href="<?php echo site_url('student/forum') ?>">
                                                                                            <?php echo lang( 'er_Forum');?> <i class="fa fa-spotify"></i></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <?php */?>
                                    </ul>
                                    </div>
                                </div>
                                <!--/.navbar-collapse-->
                        </nav>

                        </div>
                    </div>

</div>

<style>
    .heddin-dds {
        display:none !important
    }    
</style>
                <!-- content -->
                    <!--/.navbar-->
                    <div class="clearfix"></div>

