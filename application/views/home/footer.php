 
  <div class="clearfix"></div>   
<footer>
    	<div class="widget-footer">
        	<div class="">
        		<div class="row"> 
        		<div class="col-md-2 col-lg-2"></div>
        		  
                    <div class="col-lg-6 col-md-6">
                    	<div class="row">
                    	     <?php   if(($this->ApiDbname  != "SchoolAccNonBisha")  ){ ?>
                        	<div class="col-md-6 col-sm-4 wow fadeIn" data-wow-duration=".4s" data-wow-delay=".3s">
                                <div class="sidebar-head"><span><a style='text-decoration:none;' class="text-color color-hover" href="#"><?php echo lang('am_teachers_good');?></a></span></div>
                                <ul class="category">
                                    <?php if($get_teacher_good!=0){
				   		foreach($get_teacher_good as $item){
				   		     $ImagePath = base_url().'upload/'.$item->ImagePath;
				   		    $Title  =$item->Title;
				   ?>
                  <li>
                  <a href="<?=$ImagePath?>" data-featherlight="image" >
                  <img width="50" height="50" src="<?=$ImagePath?>" />
                  <?=$Title?>
                  </a>   
				  <?php  echo $item;?>
                  </li>
               <?php }}else{?>
				 <li><?php  echo lang('am_not_exist');?></li>   
			   <?php  }?>
                                </ul>
                                    <div class="clearfix"></div>
                        	</div>
                        	<?php } ?>
                            <div class="col-md-6 col-lg-6 col-sm-12 wow fadeIn important-links" data-wow-duration=".6s" data-wow-delay=".6s">
                                <div class="sidebar-head"><span><a style='text-decoration:none;' class="text-color color-hover" href="#"><?php echo lang('am_important_links');?></a></span></div>
                                <div class="">
                                    <ul class="sidebar-post">
                                       <?php
			    if($important_links!=0){
				    foreach($important_links as $item){
						$script =$item->script;
						$Title  =$item->Title;
				   ?>
                  <li><a href="<?php echo $script;?>"><?php echo $Title;?></a></li>
               <?php }}else{?><li><?php echo lang('am_not_exist');?></li><?php }?>
                                    </ul>
                                </div>
                        </div>
                                    <div class="clearfix"></div>
                        </div>
                    </div> 
                   
                    <div class="col-lg-4  col-md-4 wow fadeIn" data-wow-duration=".8s" data-wow-delay=".9s">
                    	<div class="footer-dark">
                            <div class="text-footer">
                                <div class="sidebar-head"><span><a style='text-decoration:none;' class="text-color color-hover" href="#"><?php echo lang('am_students_good');?></a></span></div>
<!--                                <ul class="last-category">-->
<!--                                     <php if($get_students_good!=0){-->
<!--				   		foreach($get_students_good as $key=>$item){-->
<!--				   		    $Title=$item->Title;-->
<!--				   		    $pic =$item->ImagePath;-->
<!--if($key<6){-->
<!--				   ?>-->
<!--                  <li>-->
<!--                  <a href="<?php echo base_url(); ?>upload/<?php echo $pic; ?>" data-featherlight="image" >-->
<!--                  <img width="50" height="50" src="<?php echo base_url(); ?>upload/<?php echo $pic; ?>" />-->
<!--                  </a> -->
<!--				  <php  echo $Title;?>-->
<!--                  </li>-->
<!--               <php }}}else{?>-->
<!--				 <li><php  echo lang('am_not_exist');?></li>   -->
<!--			   <php  }?>-->
<!--                                </ul>-->
        <div class="cd-testimonials-wrapper cd-container">
            <ul class="cd-testimonials cd-testimonials_st">
                     <?php 
                     if($get_students_good!=0){
				   		foreach($get_students_good as $key=>$item){
				   		    
 				   ?>
                  <li>
                  <?php 
                      if(file_exists('./upload/'.$item->ImagePath)&&$item->ImagePath!=""){
                        $ImagePath = base_url().'upload/'.$item->ImagePath;
                  ?>
                     <a href="<?= $ImagePath; ?>"  data-featherlight="image">
                        <img src="<?= $ImagePath; ?>" style=" min-height:400px ;">
                         </a> 
                  <?php } ?>

                  
				  <?php  echo $item->Title;?>
                  </li>
               <?php  }}else{?>
				 <li><?php  echo lang('am_not_exist');?></li>   
			   <?php  }?>
			   
            </ul>
        </div>
                                    <div class="clearfix"></div>
                                
                                
                                <div class="social-icons footer">
                                    <ul>
                                        <li><a target="_blank" class="color-hover" href="<?php  if($link_facebook!=0){extract($link_facebook);echo $script;}else {echo'#';}?>"><i class="fa fa-facebook"></i></a></li>
                                        <li><a target="_blank" class="color-hover" href="<?php  if($link_twitter!=0){extract($link_twitter);echo $script;}else {echo'#';}?>"><i class="fa fa-twitter"></i></a></li>
                                        <li><a target="_blank" class="color-hover" href="<?php  if($youtube_link!=0){extract($youtube_link);echo $script;}else {echo'#';}?>"><i class="fa fa-youtube"></i></a></li>
                                        <li><a target="_blank" class="color-hover" href="<?php  if($link_instagram!=0){extract($link_instagram);echo $script;}else {echo'#';}?>"><i class="fa fa-instagram"></i></a></li>
                                        <li><a target="_blank" class="color-hover" href="<?php  if($link_google!=0){extract($link_google);echo $script;}else {echo'#';}?>"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <!--	<div class="footer-inner wow fadeIn" data-wow-duration=".8s" data-wow-delay=".9s">-->
    <!--    	<div class="container text-center">-->
 			<!--	<p><a href="#">الرئيسية</a> | <a href="#">الرؤية</a> | <a href="#">طلاب</a> | <a href="#">اتصل بنا</a></p>-->
				<!--<div class="rights"><?php echo lang('ra_All rights reserved to the company'); ?>   <a href="#"><?php echo lang('ra_expert solution'); ?></a></div>-->
    <!--        </div>-->
    <!--    </div>-->
    </footer>
 <a href="#0" class="cd-top"><i class="fa fa-arrow-up"></i></a>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 
 
    <script src="<?php echo base_url(); ?>js/jquery.chocolat.js"></script>
    <script src="<?php echo base_url(); ?>js/owl.carousel.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js/wow.min.js"></script>
	<script>new WOW().init();</script>
    <script src="<?php echo base_url(); ?>js/bootstrap-dropdownhover.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.flexslider-min.js"></script>
    <script src="<?php echo base_url(); ?>js/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<!-- scripts -->
    <script src="<?php echo base_url(); ?>js/particles.min.js"></script>
    <script src="<?php echo base_url(); ?>js/app.js"></script>
    <script src="<?php echo base_url(); ?>js/scripts.js" ></script>
 <!-- Resource jQuery -->
   
  </body>
</html>