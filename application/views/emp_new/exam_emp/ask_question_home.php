
    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">


<?php	
	foreach($add_exam_ID as $row){
	  $exam_ID                   = $row->ID;
	}
 ?>
 <div class="sec-title">	
    <h2> <?php echo lang('Ask_question'); ?></h2>

 <a class="btn btn-success pull-left" href="<?php echo site_url('/emp/question/add_question/'.$exam_ID.''); ?>"><?php echo lang('yes'); ?></a>
 <a class="btn btn-success pull-left" href="<?php echo site_url('/emp/homework'); ?>"><?php echo lang('no'); ?></a>
   </div>




  </div>
     <div class="clearfix"></div>
  </div>
    <div class="clearfix"></div> 
  </div>
