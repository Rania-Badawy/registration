 
   
  <p class="form-group"><?php if($create_msg!=""){echo $create_msg; }else{?></p>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>exam/exam.css">
<script type ="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />

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
   
    AScgiloc : 'https://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'https://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
}); 


$(document).ready(function() {
     
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

 
  $("#btnAddExam").click(function(e) {
      
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
   
    AScgiloc : 'https://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'https://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
}); 

		var txt_description  = tinyMCE.get('txt_description').getContent();
		var slct_Semester       = $("#slct_Semester").val();
		var slct_subject  = $("#slct_subject").val(); 
		var slct_lesson  = $("#slct_lesson").val(); 
 		var slct_class = []; 
$('#slct_class :selected').each(function(i, selected){ 
  slct_class[i] = $(selected).val(); 
}); 
		var txt_exam  = $("#txt_exam").val(); 
		var txt_time  = $("#txt_time").val(); 
	
		var Date_from  = $("#Date_from").val(); 
		var Date_to  = $("#Date_to").val(); 
		var num_student  = $("#num_student").val();
		var Time_from  = $("#Time_from").val();
		var Time_to  = $("#Time_to").val();
		
		var timeDateFrom = Date_from + ' ' + Time_from;
		var timeDateTo = Date_to + ' ' + Time_to;
		
 		var data  = { slct_lesson :slct_lesson,num_student :  num_student ,  Date_to : timeDateTo  , Date_from :  timeDateFrom , txt_time :  txt_time, slct_Semester :  slct_Semester,  slct_subject :  slct_subject , txt_exam : txt_exam, txt_description : txt_description, slct_class : slct_class.join()};
		$.ajax({
				type    : "POST",
				url     : "<?php echo site_url('emp/exam_new_emp/add_exam') ?>",
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
						$("#error_slct_class").html(html.slct_class); 
 					}
					else if(html.stp == 1 )
					        { 
							$("#addExam").remove();
							
							add_exam_ID = html.add_exam_ID;
						$("#txt_test_ID").val(add_exam_ID); 
							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/exam_new_emp/show_exam') ?>",
								data    :{add_exam_ID :add_exam_ID} ,
								cache   : false,
								success : function(html)
										{     $("#txt_exam_ID").val(add_exam_ID);
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
function add_question(q_type_id,q_name){
	
	if($('#showExam').css('display')=='block'&&$('#showExam').html()!=""){
	if($('#showAddQuestion').html()==""){
		var txt_test_ID       = $("#txt_test_ID").val(); 
		
 							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/show_question') ?>",
								data    :{txt_test_ID :txt_test_ID , q_type_id : q_type_id} ,
								cache   : false,
								success : function(html)
										{
											$( "#div_img" ).empty();
											$("#txt_attach").val('');
											 tinyMCE.get('txt_question').setContent('');
											 if(q_type_id!=7){ 
 	 										$("#emp_add_question").show() ;
											 }else{
												 
 	 										$("#emp_add_question").hide() ;
												 }
 											$('#showAddQuestion').html(html) ;
											$('#question_name').html(q_name) ;
											$('#txt_Tquestion_ID').val(q_type_id) ;
											$("body, html").animate({
												scrollTop: $("#emp_add_question").position().top
											});											 

 										}
							   }); 
	}else{
		alert('<?php echo lang('alert1'); ?>');

		}}else{

		alert('<?php echo lang('alert2'); ?>');

		}
	} 
</script>
<input type="hidden" id="txt_exam_ID" value="0" name="txt_exam_ID" />
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
    <h2><?php  echo lang('Add_Exam');?> </h2>
    <a class="btn btn-success pull-left" href="<?php echo site_url('emp/exam_new_emp/index'); ?>"><?php  echo lang('am_lis_exam');?></a>
   </div>

    
          <input type="hidden" name="txt_test_ID"  id="txt_test_ID" value="" >

<div class="clearfix"></div> 
<div id="errorMessage" class="alert alert-danger"><?php echo lang('am_op_error');?></div>
<div id="addExam">
	<div class="col-lg-6">
		<div class="row">
<div class="form-group col-lg-6">
                <label class="control-label col-lg-12"><span class="error">*</span> <?php echo lang('Exam_Name'); ?></label>
                <div class="col-lg-12">
                <input type="text" name="txt_exam"  class="form-control"  id="txt_exam"  >
                </div>
                <div class="col-lg-12">
                <div class="error" id="error_txt_exam" > </div>
                </div>
            </div> 
            <div class="form-group col-lg-6">
                <label class="control-label col-lg-12"><span class="error">*</span> <?php echo lang('Subject_Name'); ?></label>
                <div class="col-lg-12">
 <select name="slct_subject"  id="slct_subject" class="selectpicker form-control" >
         <option value="0"  ><?php echo lang('Select_Subject'); ?></option>
        <?php /*
        if(isset($subjectEmp_details)){
			$subjectEmpIDSession = $this->session->userdata('subjectEmpIDSession');
			if(!is_array($subjectEmpIDSession)){
			$classIDSession      = $this->session->userdata('classIDSession');
            foreach($subjectEmp_details as $row){
                $subject_ID   = $row->subject_ID;
                $subject_Name = $row->subject_Name;
                $row_Name     = $row->row_Name;
                $level_Name   = $row->level_Name;
                $SubEmpID   = $row->SubEmpID;
                ?>
                <option value="<?php echo $SubEmpID ?>" <?php  if($subjectEmpIDSession==$SubEmpID){?>  selected="selected" <?php }?>  <?php echo  set_select('slct_subject',$SubEmpID); ?>  ><?php echo $subject_Name;?></option>
                <?php
                }
            }else{
            foreach($subjectEmp_details as $row){
                $subject_ID   = $row->subject_ID;
                $subject_Name = $row->subject_Name;
                $row_Name     = $row->row_Name;
                $level_Name   = $row->level_Name;
                $SubEmpID   = $row->SubEmpID;
				if(in_array($SubEmpID,$subjectEmpIDSession)){
                ?>
                <option value="<?php echo $SubEmpID ?>" <?php echo  set_select('slct_subject',$SubEmpID); ?>  ><?php echo $subject_Name  ;?></option>
                <?php
                }
            } 
			}
			}*/?>
			 <?php if(sizeof($all_subject) > 0 )
                        {
                            foreach($all_subject as $Sub)
                            {
                                if($SubjectI[0]!=""){
                                if(in_array($Sub->subject_ID ,$SubjectI )) {
                                ?>
                                <option value="<?= $Sub->subject_ID ?>"  <?php if($subject == $Sub->subject_ID){echo "selected";} ?> ><?= $Sub->subject_Name ?></option>
                           
                           <?php }}else{?>
                                <option value="<?= $Sub->subject_ID ?>"  <?php if($subject == $Sub->subject_ID){echo "selected";} ?> ><?= $Sub->subject_Name ?></option>
                          <?php }
                          
                            }
                        } ?>
        </select>                
                </div>
                <div class="col-lg-12">
                <div class="error" id="error_slct_subject" > </div>
                </div>
            </div>
		

            <div class="form-group col-lg-6 hidden">
                <label class="control-label col-lg-3"><?php echo 'عدد مرات حل الطالب'; ?></label>
                <div class="col-lg-9">
                <input type="text" class="form-control" value="0" name="num_student" id="num_student"  >
                </div>
                <div class="col-lg-9">
                <div class="error"> </div>
                </div>
            </div>
            
			<div class="form-group col-lg-6 hidden">
							<label class="control-label col-lg-12"><span class="error">*</span> <?php echo lang('Semester'); ?></label>
							<div class="col-lg-12">
							 <select class="selectpicker form-control" name="slct_Semester"  id="slct_Semester" >
					 <option value="0"  ><?php echo lang('Select_Semester'); ?></option>
						<?php
						if(isset($GetSemester)){
							foreach($GetSemester as $key=>$row){
								$ID_sms  = $row->ID;
								$Name_sms = $row->Name;
								?>
								<option value="<?php echo $ID_sms ?>"  <?php if($key==0){echo 'selected';} echo  set_select('slct_Semester',$ID_sms); ?>  ><?php echo $Name_sms;?></option>
								<?php
								}
							}
						?>

						</select>
							</div>
							<div class="col-lg-12">
							<div class="error" id="error_slct_Semester"><?php echo form_error('slct_Semester') ?></div>
							</div>
						</div>
		
			<div class="form-group col-lg-6 ">
                <label class="control-label col-lg-12"><?php echo lang('date_time') ; ?></label>
         </div>
         <div class="clearfix"></div>
         
            <script>
            $(function(){     
                  var d = new Date(),        
                      h = d.getHours(),
                      m = d.getMinutes();
                      s = d.getSeconds();
                  if(h < 10) h = '0' + h; 
                  if(m < 10) m = '0' + m; 
                  if(s < 10) s = '0' + s; 
                  $('#Time_from').attr({'value': h + ':' + m+':' + s}); 
                  $('#Time_to').attr({'value': h + ':' + m+':' + s}); 
                   
                });
            </script>

             <div class="form-group col-lg-6 ">
                <label class="control-label col-lg-12"><?php echo lang('am_from'); ?></label>
                <div class="col-lg-6">
                <input type="text" class="form-control datepicker" autocomplete="off" name="Date_from" id="Date_from" placeholder="<?php echo lang('from'); ?>"    value="<?php echo date("Y-m-d")?>"/>
                </div> 
                 <div class=" col-lg-6  " dir="ltr">
                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                    <input type="text" class="form-control" name="Time_from" id="Time_from" value="00:00">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>


                    </div>
             </div>
            <div class="form-group col-lg-6">
                <label class="control-label col-lg-12"><?php echo lang('am_to'); ?></label>
                <div class="col-lg-6">
                <input type="text" class="form-control datepicker" autocomplete="off" name="Date_to" id="Date_to" placeholder="<?php echo lang('to'); ?>"    value="2021-11-30"/>
                </div>
                <div class="col-lg-6" dir="ltr">
                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                    <input type="text" class="form-control" name="Time_to" id="Time_to" value="00:00">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                </div>
            </div>
<div class="form-group col-lg-6">
						<label class="control-label col-lg-12"><?php echo lang('Exam_Time2'); ?></label>
						<div class="col-lg-12 ">
						<input class="form-control" type="text" name="txt_time"  id="txt_time" >
						</div>
						<div class="col-lg-7">
						<div class="error" id="error_txt_time" ><?php echo form_error('txt_time') ?></div>
						</div>
					</div>

            <div id="class_dropdown_div ">
  <?php
        if(isset($subjectEmp_details)){
			$subjectEmpIDSession = $this->session->userdata('subjectEmpIDSession');
		      if(is_numeric($subjectEmpIDSession)){
				 $get_classes= $this->exam_new_emp_model->get_classes ($subjectEmpIDSession ); 
                   ?>
				  <div class="form-group col-lg-6 hidden">
                <label class="control-label col-lg-12"><span class="error">*</span> <?php echo lang('br_class'); ?></label>
                <div class="col-lg-12">
 <select name="slct_class" id="slct_class" multiple class="selectpicker form-control" >
        <?php
          if( is_array($get_classes)){
             foreach($get_classes as $row){
                $className   = $row->Name; 
                $classID   = $row->ID;
                ?>
                <option value="<?php echo $classID ?>"   <?php echo  set_select('slct_class',$classID); ?>  ><?php echo $className ; ?></option>
             <?php   }   } ?> 
			   
        </select>                
                </div>
                <div class="col-lg-12">
                <div class="error" id="error_slct_class" > </div>
                </div>
            </div>
				  <?php   }                                               
 			}?>
            </div>
            
            
            
            
            

            <div id="class_dropdown_div ">
  
				  <div class="form-group col-lg-6 hidden">
                <label class="control-label col-lg-12"><span class="error">*</span> <?php echo lang('er_lessons'); ?></label>
                <div class="col-lg-12">
 <select name="slct_class" id="slct_lesson"   class="selectpicker form-control" >
        <?php
          if( is_array($lessonsTitles)){
             foreach($lessonsTitles as $row){
                       $LessonID 	 = $row->LessonID ;

                            $LessonToken = $row->LessonToken ; 

							$LessonTitle = $row->LessonTitle ;
                ?>
                <option value="<?php echo $LessonID ?>" <?php if($this->session->userdata('lessonID')==$LessonID ){?>selected<?php }?>   <?php echo  set_select('slct_lesson',$LessonID); ?>  ><?php echo $LessonTitle ; ?></option>
             <?php   }   } ?> 
			   
        </select>                
                </div>
                <div class="col-lg-12">
                <div class="error" id="error_slct_lesson" > </div>
                </div>
            </div>
				  
            </div>
            
             <?php /*
			<div class="form-group col-lg-6">
						<label class="control-label col-lg-12"><?php echo lang('Exam_Time'); ?></label>
						<div class="col-lg-12 ">
						<input class="form-control" type="text" name="txt_time"  id="txt_time" >
						</div>
						<div class="col-lg-7">
						<div class="error" id="error_txt_time" ><?php echo form_error('txt_time') ?></div>
						</div>
					</div> */?>
				</div>
			</div>
	
	
	<div class="col-lg-6">
		<div class="row">
            
            <div class="form-group">
                <label class="control-label col-lg-12"><?php echo lang('Description'); ?></label>
                <div class="col-lg-12 padd_left_none">
                <textarea  name="txt_description" style="height:35px" dir="rtl" class="form-control" id="txt_description" ></textarea>
                </div>
                <div class="col-lg-12">
                <div class="error" id="error_txt_description"> </div>
                </div>
            </div>
						
		</div>
	</div>


<div class="clearfix"></div>


            

<?php
}//end if create_msg
?>
          <div class="form-group">
            <button type="button" id="btnAddExam" class="btn btn-success"><?php echo lang('am_save');?></button>
            
          </div>
     </div>
     <div class="form-group">
         <div id="showExam"></div>
         <div id="showEditExam"></div>
         <div class="clearfix"></div>
         <div class="col-lg-12 exam-st">
         	<div class="row">
        		 <h4><?=lang('am_Please_select_question');?></h4>
        
        		 <div class="clearfix"></div>     
        			 <ul class="list-inline">
        			   <?php 
        			if(isset($Type_question)){ 
        				foreach($Type_question as $row){
        					$Type_question_ID   = $row->ID;
        					$Type_question_Name = $row->Name;
        					?>
        					<li><a onclick="add_question('<?php echo $Type_question_ID;?>','<?php echo $Type_question_Name;?>');" href="javascript:void(0)">
        						<span><?php echo $Type_question_Name;?></span>
        					</a></li> 
        					<?php
        					}
        				}
        			?>
        			 </ul>
         </div>
        </div>        
         <div class="clearfix"></div>  
     </div>
 <div id="emp_add_question"  >
   <?php include('emp_add_question.php');?>
 </div>
     <div class="clearfix"></div>
	 
 <div id="showAddQuestion"></div>
 <div id="showQuestions"></div>
  
  <div class="clearfix"></div>
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
							}
				});
	}
	 </script>

 
<script type="text/javascript">
$(document).ready(function () {
   	 /* $('#slct_class').selectpicker("refresh");
$( "#slct_subject" ).change(function() {
         var data              = {config_emp : this.value } ;  
 			 $.ajax({
				type: "POST",
				url: '<?php echo site_url('emp/exam_new_emp/get_classes'); ?>',
				data: data,
				success:function(html)
							{
								$("#class_dropdown_div").html(html).show();
                                                                $('#slct_class').selectpicker("refresh");
							}
				}); 
     });*/
    });
			
	 
	 </script>
      
<script>
$(document).ready(function () {

$(".datepicker.dropdown-menu").on("blur", function(e) { $(this).datepicker("hide"); }); 
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('#Date_from').datepicker({
  format: "yyyy-mm-dd", 
  onRender: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate());
    checkout.setValue(newDate);
  }
  checkin.hide();
  //$('#dpd2')[0].focus();
}).data('datepicker');
var checkout = $('#Date_to').datepicker({
  format: "yyyy-mm-dd", 
  onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');
 $("#Date_from ~ .datepicker").hide();
 $("#Date_to ~ .datepicker").hide();

});
</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new/clockpicker/bootstrap-clockpicker.min.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url(); ?>assets/new/clockpicker/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>