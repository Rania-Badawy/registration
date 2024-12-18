 

 
 

 <?php
        if(isset($exam_details_edit)){
            foreach($exam_details_edit as $row){
				$Name                = $row->Name;
				$test_ID             = $row->test_ID;
				$Description         = $row->Description;
				$subject_Name_this   = $row->subject_Name;
				$Subject_ID_this     = $row->Subject_ID;
				$time_count          = $row->time_count;
				$row_Name_this       = $row->row_Name;
				$level_Name_this     = $row->level_Name;
				$Name_sms            = $row->Name_sms;				
				$ID_sms              = $row->ID_sms;
				$ID                  = $row->ID;
                }
            }
?>
 
            <div class="form-group col-lg-5">
                <label class="control-label col-lg-4"><div class="error pull-left">*</div> <?php echo lang('Exam_Name'); ?></label>
                <div class="col-lg-8">
                <input class="form-control" type="text" name="txt_exam"  id="txt_exam"  value="<?php echo $Name;?>">
                </div>
                <div class="col-lg-9">
                <div class="error span9" id="error_txt_exam" > </div>
                </div>
            </div>
            
            <div class="form-group col-lg-5">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Subject_Name'); ?></label>
                <div class="col-lg-9">
     <select class="  form-control" name="slct_subject" id="slct_subject" >
         <option value="<?php echo $Subject_ID_this;?>" <?php echo  set_select('slct_subject',$Subject_ID_this); ?>  ><?php echo $subject_Name_this.' - '.$row_Name_this.' - '.$level_Name_this;?></option>
         
        <?php
        if(isset($subjectEmp_details)){
            foreach($subjectEmp_details as $row){
                $subject_ID   = $row->subject_ID;
                $subject_Name = $row->subject_Name;
                $row_Name     = $row->row_Name;
                $level_Name   = $row->level_Name;
                if ($Subject_ID_this!= $subject_ID){?>
				 <option value="<?php echo $subject_ID ?>" <?php echo  set_select('slct_subject',$subject_ID); ?> ><?php echo $subject_Name.' - '.$row_Name.' - '.$level_Name;?></option>
				<?php }
               
                }
            }
        ?>
        </select>                
                </div>
                <div class="col-lg-9">
                <div class="error span9"  id="error_slct_subject"> </div>
                </div>
            </div>
            
            <div class="form-group col-lg-2 padd_right_none padd_left_none">
                <label class="control-label col-lg-5 padd_right_none padd_left_none"><?php echo lang('Exam_Time'); ?></label>
                <div class="col-lg-7 padd_left_none">
           
          <input class="form-control smallWidth" type="text" name="txt_time"  id="txt_time" value="<?php echo $time_count;?>" >                
                </div>
                <div class="col-lg-9">
                <div class="error span9"   id="error_txt_time" >  </div>
                </div>
            </div>
            

<div class="clearfix"></div>

            <div class="form-group col-lg-5">
                <label class="control-label col-lg-4"><div class="error pull-left">*</div> <?php echo lang('Semester'); ?></label>
                <div class="col-lg-8">
                <select class="  form-control" name="slct_Semester" id="slct_Semester" >
         <option value="<?php echo $ID_sms ?>" <?php echo  set_select('slct_Semester',$ID_sms); ?>  ><?php echo $Name_sms; ?></option>
        <?php
        if(isset($GetSemester)){
            foreach($GetSemester as $row){
                $ID_sms_this  = $row->ID;
                $Name_sms = $row->Name;
                 if ($ID_sms_this!= $ID_sms){?>
                <option value="<?php echo $ID_sms_this; ?>" <?php echo  set_select('slct_Semester',$ID_sms_this); ?>  ><?php echo $Name_sms;?></option>
                <?php
				 }
                }
            }
        ?>
        </select> 
                </div>
                <div class="col-lg-9">
                <div class="error span9"  id="error_slct_Semester"  > </div>
                </div>
            </div>


            


            <div class="form-group col-lg-5">
                <label class="control-label col-lg-3"><?php echo lang('Description'); ?></label>
                <div class="col-lg-9">
                  <textarea name="txt_description" style="height:35px"  id="txt_description" class="form-control"> <?php echo strip_tags( $Description);?></textarea>
                </div>
                <div class="col-lg-9">
                <div  class="error span9" id="error_txt_description"  > </div>
                </div>
            </div>

          <div class="form-group col-lg-2 padd_left_none ">
            <button type="button" id="BtnEditExam" class="btn btn-success"><?php echo lang('am_save');?></button>
          </div>
<div class="clearfix"></div>  
 
<script type="text/javascript">
	
$(document).ready(function() {
 	    $("#BtnEditExam").click(function(e) {
			 
		var slct_Semester       = $("#slct_Semester").val();
		var slct_subject  = $("#slct_subject").val(); 
		var txt_exam  = $("#txt_exam").val(); 
		var txt_time  = $("#txt_time").val(); 
		var txt_description  = $("#txt_description").val();  
 		var txt_test_ID  = $("#txt_test_ID").val(); 
		
	var data  = {  txt_time :  txt_time, slct_Semester :  slct_Semester,  slct_subject :  slct_subject , txt_exam : txt_exam, txt_description : txt_description ,txt_test_ID:txt_test_ID };
 
		$.ajax({
				type    : "POST",
				url     : "<?php echo site_url('emp/exam_new/edit_exam') ?>",
				data    : data,
				cache   : false,
				beforeSend : function(){}, 
				success : function(html)
				{  
					if(html.stp == 0 )
					{ 
					    $("#error_slct_Semester").html(html.slct_Semester);
						$("#error_slct_subject").html(html.slct_subject);
						$("#error_txt_exam").html(html.txt_exam);
						$("#error_txt_time").html(html.txt_time); 
 					}
					else if(html.stp == 1 )
					        { 
							$("#showEditExam").empty();
							add_exam_ID = html.add_exam_ID;
							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/exam_new/show_exam') ?>",
								data    :{add_exam_ID :add_exam_ID} ,
								cache   : false,
								success : function(html)
										{ 
										      $('#showExam').show();
											  $('#showExam').html(html) ;
 										}
							   });
  					        } 
					else if(html.stp == 2 )
					        { 
							$("#errorMessage").show();
  					        } 
				},
				error: function(jqXHR, exception) {
																	if (jqXHR.status === 0) {
																		alert('Not connect.\n Verify Network.');
																	} else if (jqXHR.status == 404) {
																		alert('Requested page not found. [404]');
																	} else if (jqXHR.status == 500) {
																		alert('Internal Server Error [500].');
																	} else if (exception === 'parsererror') {
																		alert('Requested JSON parse failed.');
																	} else if (exception === 'timeout') {
																		alert('Time out error.');
																	} else if (exception === 'abort') {
																		alert('Ajax request aborted.');
																	} else {
																		alert('Uncaught Error.\n' + jqXHR.responseText);
																	}
																}
		 }); /////END AJAX
    }); /////BTN CLICK
	   
});
</script>