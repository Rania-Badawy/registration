 <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>exam/exam.css">
 

<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
    theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg",
    theme_advanced_buttons3 : "",
    theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    plugins : 'asciimath,asciisvg,table,inlinepopups,media',
   
    AScgiloc : 'http://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'http://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
}); 


$(document).ready(function() {
	$('.btn-success').hide();
	$('.btn-danger').hide();$('#am_lis_exam').show();
    $("#txt_Degree").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
 
  $("#num_student").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });

 

 
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	 $("#errorMessage").hide();
 	 $("#emp_add_question").hide();

 
 	 
 
	    
});
 </script>
<div class="modal modal_st fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="clearfix"></div>
          <div class="modal-body">
             <div class="form-group col-lg-7 padd_left_none">
                <label class="control-label col-lg-12"><?php echo lang('Description'); ?></label>
                <div class="col-lg-12 padd_left_none">
                <textarea  name="txt_del" style="height:35px" dir="rtl" class="form-control" id="txt_del" ></textarea>
                <input type="hidden" id="del_type" value="0" />
                <input type="hidden" id="del_id" value="0" />
                </div>
               
               
            </div>
            </div>
          <div class="clearfix"></div>
            <div class="modal-footer">
             <div class="col-lg-12">
<button type="button" data-dismiss="modal" id="btnAdddel" class="btn btn-success pull-left"><?php echo lang('am_save');?></button>
             </div>
            </div>
        </div>
      </div>
    </div>
 
    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">

 <div class="sec-title">	
    <h2>نموذج الاجابة </h2>
    </div>

    

<div class="clearfix"></div> 
 
 <div id="showExam"></div>
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
            <script> 
		var add_exam_ID       = '<?php echo $test_ID ;?>'; 
 							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/exam_new_emp/show_exam_admin') ?>",
								data    :{add_exam_ID :add_exam_ID} ,
								cache   : false,
								success : function(html)
										{     $("#txt_exam_ID").val(add_exam_ID);
											  $('#showExam').html(html) ;
 										}
							   });</script>
            
                <input type="hidden" id="txt_exam_ID" value="<?php echo $test_ID;?>" name="txt_exam_ID" />
          <input type="hidden" name="txt_test_ID"  id="txt_test_ID" value="<?php echo $test_ID;?>" >
 <input type="hidden" name="add_exam_ID"  id="add_exam_ID" value="<?php echo $test_ID;?>" >
 <div id="showEditExam">
 
  </div>
     <div class="clearfix"></div>
   
        
     <div class="clearfix"></div>  
     
 <div id="emp_add_question"  >
   <?php include('emp_add_question.php');?>
 </div>
     <div class="clearfix"></div>
     <div class="clearfix"></div>
 <div id="showAddQuestion"></div>
 <div id="showQuestions">
 <?php 
         if($question!=0){ 
		 	foreach($question as $row){
				$questions_types_ID =$row->questions_types_ID;
                $questions_content_ID      = $row->questions_content_ID;
			 
					 ?>
					 <script>
 						txt_test_ID = $("#txt_test_ID").val(); 
						q_type_id = '<?php echo $questions_types_ID;?>'; 
						questions_content_ID = '<?php echo $questions_content_ID;?>'; 
							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/show_all_question') ?>",
								data    :{txt_test_ID :txt_test_ID , q_type_id : q_type_id , questions_content_ID:questions_content_ID} ,
								cache   : false,
								success : function(html)
										{     
										 $('#showQuestions').append(html) ;	
	$('.btn-success').hide();
	$('.btn-danger').hide();$('#am_lis_exam').show();				
 										}
							   });
                     </script>
					 <?php
					 
				}
		 
		 }
  ?>
 </div>
  </div>
  
     <div class="clearfix"></div>
  </div>
    <div class="clearfix"></div> 
  </div>

 
<script type="text/javascript">
	function Create_answers (){ 
			var str = tinyMCE.get('txt_question').getContent(); 
			var data              = {str : str } ;  
	

			 $.ajax({
				type: "POST",
				url: '<?php echo site_url('emp/question/post_correct_answer'); ?>',
				data: data,
				success:function(html)
							{
								$("#correct_answer_div").html(html).show();	
	$('.btn-success').hide();
	$('.btn-danger').hide();$('#am_lis_exam').show();				
							}
				});
	}
	 </script>
 