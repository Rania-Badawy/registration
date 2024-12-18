   
<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script>
<script type="text/javascript">
var AMTcgiloc = "http://www.imathas.com/cgi-bin/mimetex.cgi";  		//change me
</script>
<style>
.list-group-item {
	margin-bottom:4px;
	}
</style>

 <?php
         if(isset($exam_details_edit)){ 
            foreach($exam_details_edit as $row){
				$Name                = $row->Name;
				$test_ID             = $row->test_ID;
				$Description         = $row->Description;
				$subject_Name_this   = $row->subject_Name;
				$Subject_ID_this     = $row->Subject_ID;
				$time_count          = $row->time_count; 	
				$date_from            = $row->date_from;		
				$date_to            = $row->date_to; 
				$ID                  = $row->ID;
                 }
            }
?>
 
 
 <ul class="list-group" dir="rtl">
 <div class="col-lg-6">
  <li class="list-group-item"><?php echo lang('Exam_Name'); ?> : <?php echo $Name;?></li>
  </div>
 <div class="col-lg-6">
  <li class="list-group-item"><?php echo lang('Subject_Name'); ?> : <?php echo $subject_Name_this ;?>  </li>
  </div>
 
 <div class="col-lg-6">
  <li class="list-group-item"><?php echo lang('Time'); ?> : <?php echo $time_count / 60 ;?>  دقيقة </li>
         </div>
 <div class="col-lg-6">
  <li class="list-group-item"><?php echo lang('date_exam'); ?> : يبداء الاختبار من  <?php echo $date_from."<br>ينتهى الاختبار فى  : ".$date_to ;	?></li>
         </div>
 <div class="col-lg-6">
  <li class="list-group-item"><?php echo lang('Description'); ?> :  <?php echo strip_tags( $Description);?> </li> 
         </div> 
</ul>


          <div class="form-group col-lg-12 text-left ">
            <button type="button" id="show_edit" class="btn btn-success"><?php echo lang('am_edit');?></button>
          </div>
<div class="clearfix"></div>  
 <script type="text/javascript">
	
$(document).ready(function() {
 	    $("#show_edit").click(function(e) {
			 
		var txt_test_ID       = $("#txt_test_ID").val(); 
  							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/exam_new_emp/set_exam') ?>",
								data    :{txt_test_ID :txt_test_ID} ,
								cache   : false,
								success : function(html)
										{
											  $('#showExam').hide() ;
											  $('#showEditExam').html(html) ;
 										}
							   }); 
    }); /////BTN CLICK
});
</script>
