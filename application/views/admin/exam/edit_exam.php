

<div class="clearfix"></div>

<div class="content margin-top-none container-page">  
  <div class="col-lg-12">
    <div class="block-st text-right">
       

<?php	
	foreach($add_exam_ID as $row){
	  $exam_ID                   = $row->ID;
	}
 ?>
<div class="sec-title">
<h2><?php echo lang('Ask_question'); ?></h2>
</div>
 <div class="clearfix"></div>
 <a class="btn btn-success" href="<?php echo site_url('/emp/question/add_question/'.$exam_ID.''); ?>"><?php echo lang('yes'); ?></a>
 <a class="btn btn-danger" href="<?php echo site_url('/emp/exam'); ?>"><?php echo lang('no'); ?></a>

 
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>