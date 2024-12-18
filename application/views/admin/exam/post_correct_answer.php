<?php if($create_msg!=""){echo $create_msg; }else{?>

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

			 

		var slct_Semester       = $("#slct_Semester").val();

		var slct_subject  = $("#slct_subject").val(); 

		var txt_exam  = $("#txt_exam").val(); 

		var txt_time  = $("#txt_time").val(); 

		var txt_description  = $("#txt_description").val(); 

		var Date_from  = $("#Date_from").val(); 

		var Date_to  = $("#Date_to").val(); 

		var num_student  = $("#num_student").val(); 

		

 		var data  = { num_student :  num_student , Date_to :  Date_to , Date_from :  Date_from , txt_time :  txt_time, slct_Semester :  slct_Semester,  slct_subject :  slct_subject , txt_exam : txt_exam, txt_description : txt_description};

		$.ajax({

				type    : "POST",

				url     : "<?php echo site_url('emp/exam_new/add_exam') ?>",

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

							$("#addExam").remove();

							

							add_exam_ID = html.add_exam_ID;

						$("#txt_test_ID").val(add_exam_ID); 

							$.ajax({

								type    : "POST",

								url     : "<?php echo site_url('emp/exam_new/show_exam') ?>",

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

				error: function(jqXHR, exception) {alert('ss');

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

		alert('يجب حفظ السؤال المختار او حذفه قبل إضافة سؤال آخر');

		}}else{

		alert('يجب حفظ بيانات الاختبار قبل وضع الاسئلة');

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

    <a class="btn btn-success pull-left" href="<?php echo site_url('emp/exam_new/index'); ?>"><?php  echo lang('am_lis_exam');?></a>

   </div>



    

          <input type="hidden" name="txt_test_ID"  id="txt_test_ID" value="" >



<div class="clearfix"></div> 

<div id="errorMessage" class="alert alert-danger"><?php echo lang('am_op_error');?></div>

<div id="addExam">

<div class="form-group col-lg-5">

                <label class="control-label col-lg-4"><div class="error pull-left">*</div> <?php echo lang('Exam_Name'); ?></label>

                <div class="col-lg-8">

                <input type="text" name="txt_exam"  class="form-control"  id="txt_exam"  >

                </div>

                <div class="col-lg-9">

                <div class="error" id="error_txt_exam" > </div>

                </div>

            </div>

            <div class="form-group col-lg-5">

                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Subject_Name'); ?></label>

                <div class="col-lg-9">

 <select name="slct_subject" id="slct_subject" class="selectpicker form-control" >

         <option value="0"  ><?php echo lang('Select_Subject'); ?></option>

        <?php

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

                <option value="<?php echo $SubEmpID ?>" <?php  if($subjectEmpIDSession==$SubEmpID){?>  selected="selected" <?php }?>  <?php echo  set_select('slct_subject',$SubEmpID); ?>  ><?php echo $subject_Name.' - '.$row_Name.' - '.$level_Name;?></option>

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

                <option value="<?php echo $SubEmpID ?>" <?php echo  set_select('slct_subject',$SubEmpID); ?>  ><?php echo $subject_Name.' - '.$row_Name.' - '.$level_Name;?></option>

                <?php

                }

            } 

			}

			}?>

        </select>                

                </div>

                <div class="col-lg-9">

                <div class="error" id="error_slct_subject" > </div>

                </div>

            </div>



<div class="form-group col-lg-2 padd_right_none padd_left_none">

                <label class="control-label col-lg-5 padd_right_none padd_left_none"><?php echo lang('Exam_Time'); ?></label>

                <div class="col-lg-7  padd_left_none">

                <input class="form-control" type="text" name="txt_time"  id="txt_time" >

                </div>

                <div class="col-lg-7">

                <div class="error" id="error_txt_time" ><?php echo form_error('txt_time') ?></div>

                </div>

            </div>

            







<div class="clearfix"></div>

             <div class="form-group col-lg-6 hidden">

                <label class="control-label col-lg-3"><?php echo lang('date_exam'); ?></label>

                <div class="col-lg-4">

                <input type="text" class="form-control"  name="Date_from" id="Date_from" placeholder="<?php echo lang('from'); ?>"  readonly="readonly" value="<?php echo  set_value('Date_from');?>"/>

                </div>

                <div class="col-lg-4">

                <input type="text" class="form-control"  name="Date_to" id="Date_to" placeholder="<?php echo lang('to'); ?>" readonly="readonly"  value="<?php echo  set_value('Date_to');?>"/>

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





<div class="clearfix"></div>



            <div class="form-group col-lg-5">

                <label class="control-label col-lg-4"><div class="error pull-left">*</div> <?php echo lang('Semester'); ?></label>

                <div class="col-lg-8">

                 <select class="selectpicker form-control" name="slct_Semester"  id="slct_Semester" >

         <option value="0"  ><?php echo lang('Select_Semester'); ?></option>

			<?php

            if(isset($GetSemester)){

                foreach($GetSemester as $row){

                    $ID_sms  = $row->ID;

                    $Name_sms = $row->Name;

                    ?>

                    <option value="<?php echo $ID_sms ?>" <?php echo  set_select('slct_Semester',$ID_sms); ?>  ><?php echo $Name_sms;?></option>

                    <?php

                    }

                }

            ?>

            </select>

                </div>

                <div class="col-lg-9">

                <div class="error" id="error_slct_Semester"><?php echo form_error('slct_Semester') ?></div>

                </div>

            </div>





            <div class="form-group col-lg-7 padd_left_none">

                <label class="control-label col-lg-3"><?php echo lang('Description'); ?></label>

                <div class="col-lg-9 padd_left_none">

                <textarea  name="txt_description" style="height:35px" dir="rtl" class="form-control" id="txt_description" ></textarea>

                </div>

                <div class="col-lg-9">

                <div class="error" id="error_txt_description"> </div>

                </div>

            </div>





<?php

}//end if create_msg

?>

          <div class="form-group col-lg-12 padd_left_none">

            <button type="button" id="btnAddExam" class="btn btn-success pull-left"><?php echo lang('am_save');?></button>

          </div>

     <div class="clearfix"></div>

     </div>

 <div id="showExam"></div>

 <div id="showEditExam"></div>

     <div class="clearfix"></div>

     <div class="col-lg-12 exam-st">

     <h4>من فضلك إختر نوع السؤال    </h4>



     <div class="clearfix"></div>     

         <ul class="list-inline">

           <?php 

        if(isset($Type_question)){ 

            foreach($Type_question as $row){

                $Type_question_ID   = $row->ID;

                $Type_question_Name = $row->Name;

                ?>

                <li><a onclick="add_question('<?php echo $Type_question_ID;?>','<?php echo $Type_question_Name;?>');" href="javascript:void(0)">

				<?php echo $Type_question_Name;?>

                </a></li> 

                <?php

                }

            }

        ?>

         </ul>

     </div>

        

     <div class="clearfix"></div>  

     

 <div id="emp_add_question"  >

   <?php include('emp_add_question.php');?>

 </div>

     <div class="clearfix"></div>

     <div class="clearfix"></div>

 <div id="showAddQuestion"></div>

 <div id="showQuestions"></div>

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