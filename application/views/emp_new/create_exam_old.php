<div class="loading_div" id="loadingDiv" ></div>
<?php	   
$CI = get_instance();
$lang = $CI->session->userdata('language'); 
$dir = 'rtl';
if($lang != 'arabic'){
 $dir = 'ltr';
};
?>
<style>
    label{
        text-align: center;
    }
</style>
    <!-- Page Head -->
                <div class="page-head blue container-fluid pt30" style="margin-bottom: auto;">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="<?php echo site_url('emp/cpanel'); ?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
                         <a style="color:blue;"> <?php if($type==1) { echo lang('Add_homework') ; } elseif($type==0){ echo lang('Add_Exam') ; }; ?> </a>
                    </div>
                    <!-- Title -->
                   
                </div>
                <!-- // Page Head -->
                  <?php if($this->session->flashdata('msg')){?>
                             <div class="alert danger tx-align-center"><?php echo $this->session->flashdata('msg');?> </div> 
                             <?php } ?>
                <form  method="post" action="<?php echo site_url('emp/exam_new/add_exam/'.$rowlevelid."/".$subjectid."/".$type."/".$test_id); ?>" >
                 
                <!-- Page Content -->
                <div class="padding-all-20 mb0">
                    <div class="container form-ui">
                        <!-- Grid -->
                        <div class="row">
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php if($type==1) { echo lang('homework_Name');} elseif($type==0){ echo lang('Exam_Name') ; }  ?> </label>
                                <input type="text" name="txt_exam" id="txt_exam" value="<?= $test_data['Name'];?>">
                            </div>
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('Subject_Name'); ?> </label>
                                <select name="slct_subject"  id="slct_subject"  >
                                 <?php
       
                                     foreach($subjectEmp_details as $row){
                                       $subject_ID   = $row->subject_ID;
                                       $subject_Name = $row->subject_Name;
                                       $row_Name     = $row->row_Name;
                                       $level_Name   = $row->level_Name;
                                       $SubEmpID     = $row->SubEmpID;
                                       $R_L_ID       = $row->R_L_ID;
				                     
                                ?>
                                 <option value="<?php echo $SubEmpID ?>" <?php  if($R_L_ID==$rowlevelid && $subject_ID==$subjectid)echo 'selected' ; ?>  ><?php echo $subject_Name.' - '.$row_Name.' - '.$level_Name;?></option>
                               <?php }?>
                            </select>                
                            </div>
                             <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('Semester'); ?> </label>
                                <select  name="slct_Semester"  id="slct_Semester" required>
					              <option value=""  ><?php echo lang('Select_Semester'); ?></option>
						            <?php
						              if(isset($GetSemester)){
							            foreach($GetSemester as $row){
								            $ID_sms  = $row->ID;
								            $Name_sms = $row->Name;
								            ?>
								<option value="<?php echo $ID_sms ?>" <?php  if($ID_sms==$test_data['config_semester_ID'] )echo 'selected' ; ?>><?php echo $Name_sms;?></option>
								<?php } } ?>
						      </select>
                            </div>
                            <!-- Form Control -->
                            <div class="col-6 col-m-3 col-l-3">
                                <label for="" class="mb10 strong-weight"><?php echo lang('am_from'); ?> </label>
                                <input type="datetime-local" name="Date_from" id="dateEditor" value="<?php if($test_data['date_from']){echo date("Y-m-d\TH:i:s", strtotime($test_data['date_from']));}?>"  required>
                            </div>
                           
                             <!-- Form Control -->
                            <div class="col-6 col-m-3 col-l-3">
                                <label for="" class="mb10 strong-weight"><?php echo lang('am_to'); ?> </label>
                                <input type="datetime-local" name="Date_to" id="dateEditor" value="<?php if($test_data['date_to']){echo date("Y-m-d\TH:i:s", strtotime($test_data['date_to']));} ?>"  required>
                            </div>
                            
                             <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('er_lessons'); ?></label>
                                 <select name="slct_lesson" id="slct_lesson"  >
                                   <option value="0"><?php echo lang('am_Choose_lesson'); ?> </option>
                                     <?php
                                       if( is_array($lessonsTitles)){
                                          foreach($lessonsTitles as $row){
                                                    $LessonID 	 = $row->LessonID ;
							                        $LessonTitle = $row->LessonTitle ;
                                             ?>
                                             <option value="<?php echo $LessonID ?>" <?php  if($LessonID==$test_data['lessonID'] )echo 'selected' ; ?>><?php echo $LessonTitle ; ?></option>
                                          <?php   }   } ?> 
			   
                                     </select>       
                            </div>
                              <!-- Form Control -->
                            <div class="col-6 col-m-4 col-l-2">
                                <label for="" class="mb10 strong-weight"><?php echo lang('Exam_Time2'); ?></label>
                                <input type="number" name="txt_time"  id="txt_time"  min="0"  max="999" value="<?php echo ($test_data['time_count']/60);?>" required>
                            </div>
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('br_class'); ?></label>
                                <select name="slct_class[]" id="slct_class" multiple class="manual select_2" >
                                    <option value="0"> </option>
                                   <?php
                                     if( is_array($get_classes)){
                                        foreach($get_classes as $val){
                                           $className   = $val->Name; 
                                           $classID     = $val->ID; 
                                           $class_test  =explode("," ,$test_data['classID'])
                                           ?>
                                  <option value="<?php echo $classID ?>" <?php if (in_array($classID, $class_test)) { echo 'selected';  } ?>><?php echo $className ; ?></option>
                                        <?php   }   } ?>
                                   </select> 
                            </div>
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('am_students'); ?></label>
                                <input type="hidden" id="RowLevel" value="<?php echo $rowlevelid ;?>" />
                                <select name="slct_student[]" id="slct_student" multiple class="manual select_2"  > 
                                   <option value="0"> </option>
                                   <?php
                                        foreach($exam_student as $val){
                                           $studentName   = $val->Name; 
                                           $studentID     = $val->ID; 
                                           $student_test  =explode("," ,$test_data['Students'])
                                           ?>
                                  <option value="<?php echo $studentID ?>" <?php if (in_array($studentID, $student_test)) { echo 'selected';  } ?>><?php echo $studentName ; ?></option>
                                        <?php   } ?>
                                </select> 
                            </div>
                           
                            <!-- Form Control -->
                            <div class="col-6 col-m-4 col-l-2">
                                <label for="" class="mb10 strong-weight"><?php echo lang('br_active'); ?> </label>
                                <input type="checkbox"  name="IsActive"  id="IsActive" <?php if ($test_data['IsActive'] == 1) {  echo 'checked'; }?> value="1"  >
                            </div>
                            <!-- Button -->
                            <div class="col-6 col-m-4 col-l-2" style="margin-top: 29px">
                                <?php if($test_id>0){ ?>
                                 <button class="btn blue-bg block-lvl"><?php echo lang('br_edit');?></button>
                                 <?php }else { ?>
                                <button class="btn blue-bg block-lvl"><?php echo lang('am_save');?></button>
                                <?php } ?>
                            </div>
                            
                        </div>
                        </form>
                        <!-- Grid -->
                        <!-- Questions Buttons -->
                        <?php if($test_id>0){
                        $abc=array(
                                '0'=>'orange2-bg',
                                '1'=>'green2-bg',
                                '2'=>'pink-bg',
                                '3'=>'green-water-bg',
                                '4'=>'blue-bg ',
                                '5'=>'dark'
                                );?>
                         <h4 style="color: #025e77;"><?=lang('am_Please_select_question');?></h4>
                         <br>
                        <ul class="reset-block flexbox mb15 ">
                             <?php 
					              foreach($Type_question as $color => $row){
						                   $Type_question_ID   = $row->ID;
						                   $Type_question_Name = $row->Name;
						              ?>
						              <li class="me10">
						                  <a class="btn <?php echo $abc[$color];?>" data-modal="add_question-<?= $Type_question_ID ?>"  href="#">
							              <span><?php echo $Type_question_Name;?></span>
						              </a></li> 
						              <li>
						              <div class="modal-box" id="add_question-<?= $Type_question_ID ?>" >
                            
                                            <form class="modal-content mxw-1000 form-ui overflow" action="<?php echo site_url('emp/exam_new/add_exam_question/'.$Type_question_ID."/".$test_id); ?>" method="post" <?php if($Type_question_ID==7){?> style="width:min-content !important;"<?php } ?>>
                                                <!-- Headline -->
                                                <h2 class="modal-head primary-bg" <?php if($Type_question_ID==7) {?>style="width:700px;"<?php }?>><?php echo $Type_question_Name;?>    
                                                    <button class="close-modal fas fa-times-circle"></button>
                                                </h2>
                                                <!-- Content -->
                                                <div class="modal-body qscroll">
                                                    <!-- Grid -->
                                                <div class="row">
                                                        <!-- Control Label -->
                                                       
                                                    <div class="col-12 col-s-6">
                                                            <label for="" class="strong-weight"> <?php if($Type_question_ID!=7) { echo lang('question'); }else{echo lang('note');}?></label>
                                                            <textarea class="mceEditor" name="txt_question" id="txt_question<?= $Type_question_ID ?>"  <?php if($Type_question_ID==7) {?>style="width:650px;"<?php }else {?>style="width:610px;"<?php }?>></textarea>
                                                    </div>
                                                   
                                                    <div class="row" style="padding: 15px;">
                    							    <div class="col-4 col-s-3 ">
                    							      <label class="control-radio">
                    								    <?php echo lang('am_easy'); ?>
                    							       <input type="radio"  name="difficult_degree"  value="1" checked="checked" style="width: 20%;" />
                    							      </label>
                    							    </div>
                    							    <div class="col-4 col-s-3 ">
                    							      <label class="control-radio">
                    								    <?php echo lang('am_average'); ?>
                    								    <input type="radio"  name="difficult_degree" value="2" style="width: 20%;" /> 	
                    							      </label>	                 
                    							   </div>                
                    							   <div class="col-4 col-s-3 ">
                    							     <label class="control-radio">
                    								   <?php echo lang('am_difficult'); ?>
                    								  <input type="radio" name="difficult_degree" value="3"  style="width: 20%;"/>	
                    							     </label>
                    							  </div>   
                    							  <div class="col-4 col-s-3 ">
                    							    <label class="control-radio">
                    								    <?php echo lang('Degree'); ?>
                    									<input type="number" name="txt_Degree" value="0.5" min="0.5" style="float:none;clear:both;width: -webkit-fill-available;"  id="txt_Degree"  step="0.5" >
                    							    </label>
                    							  </div> 
                                                 
                                                <label class="col-2 align-self-center mb15" <?php if($Type_question_ID==7){ ?> style="display:none"<?php } ?>><?php echo lang('am_attach'); ?></label>
                                                    <div class="col-7 col-s-0">
                                                        <div class="file-input" data-btn="upload" <?php if($Type_question_ID==7){ ?> style="display:none"<?php } ?>>
                                                        <input type="file" id="fileUpload<?= $Type_question_ID ?>">
                                                        <input name ="hidImg" id ="hidImg<?= $Type_question_ID ?>" type="hidden" value="" />
                                                      
                                                    </div>
                                                    </div>
                                                    <div class="col-2 col-s-3 " <?php if($Type_question_ID==7){ ?> style="display:none"<?php } ?>>
                                                        <a href="#" class="btn purble-bg" onclick="alert('mp4 | mp3 | wav | aif | aiff | ogg | MP3 | MP4 | jpeg | png | jpg | gif | pdf | doc | docx | txt | ppt | xlsx | pptx');return false;"> <?php echo lang('Allowed_file_types') ?> </a>
                                                    </div>
                                               
                                                </div>
                                              <?php 
                                              if($Type_question_ID==1){ ?>
                                             <div class="form-repeater col-12" style="width: -webkit-fill-available;">
                                                            <label for="" class="mb10 strong-weight"><?php echo lang('Choices'); ?></label>
                                                            <!-- Repeater Item -->
                                                            <div class="repeater-item" style="width: -webkit-fill-available;">
                                                                <!-- Controls to Repeate -->
                                                                <div class="controls-wrap row" style="width: -webkit-fill-available;">
                                                                    <div class="col-12 col-m-8">
                                                                        <input type="text" name="txt_Choices[]"  >
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <input type="radio" name="slct_Correct_Answer[]" class="chk" value="1" >
                                                                        <span> <?php echo lang('Correct_Answer'); ?></span>
                                                                    </label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <a href="#" class="fas fa-plus add-item"></a>
                                                                </div>
                                                                <!-- Repeater Button -->
                                                            </div>
                                                            <!-- // Repeater Item -->
                                                </div>
                                                         <?php 
                                              }elseif($Type_question_ID==2){ ?>
                                              <div class="form-repeater" style="width: -webkit-fill-available;">
                                                            <label for="" class="mb10 strong-weight"><?php echo lang('Choices'); ?></label>
                                                            <!-- Repeater Item -->
                                                            <div class="repeater-item" style="width: -webkit-fill-available;">
                                                                <!-- Controls to Repeate -->
                                                                <div class="controls-wrap row" style="width: -webkit-fill-available;">
                                                                    <div class="col-12 col-m-8">
                                                                        <input type="text" name="txt_multi_Choices[]"  >
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="slct_multi_Correct_Answer[]" class="chk" value="1"  >
                                                                        <span> <?php echo lang('Correct_Answer'); ?></span>
                                                                    </label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <a href="#" class="fas fa-plus add-item"></a>
                                                                </div>
                                                                <!-- Repeater Button -->
                                                            </div>
                                                            <!-- // Repeater Item -->
                                                </div>
                                                        
                                            <?php }elseif($Type_question_ID==3){ ?>
                                            <div class="col-lg-9">
                                                 <a type="button" class="btn info" id="right_answer"><?php echo lang("right_answer"); ?></a> 
                                                 <a type="button" class="btn default" id="wrong_answer"><?php echo lang("wrong_answer"); ?></a>
                                                 <input type="hidden" name="true_txt" id="true_txt" value="1"/> 
                				                 <input type="hidden" name="false_txt" id="false_txt" value="0"/> 
                                            </div>         
                                            <?php }elseif($Type_question_ID==4) {?>
                                                    <br>
                                                    <a type="button" class="btn btn info " onclick="Create_complete();"  herf="#" name="Create_complete" id="Create_complete" >  <?php echo lang('Add_Place_Correct_Answers'); ?>  </a>
                                                     <div class="form-repeater" style="width: -webkit-fill-available;">
                                                            <label for="" class="mb10 strong-weight"><?php echo lang('answer'); ?></label>
                                                            <div class="repeater-item" style="width: -webkit-fill-available;">
                                                                <div class="controls-wrap row" style="width: -webkit-fill-available;">
                                                                    <div class="col-12 col-m-8">
                                                                        <input type="text" name="txt_answer[]"  >
                                                                    </div>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <a href="#" type="button" class="btn btn warning add-item" style="width: auto"><?php echo lang('Create_Correct_Answers'); ?></a>
                                            
                                                                </div>
                                                                <!-- Repeater Button -->
                                                            </div>
                                                            <!-- // Repeater Item -->
                                                        </div>
                                                <div class="alert alert-info" dir="rtl">
                             	                    <strong><?php echo lang('how_complete') ?>.</strong>
                                                    <br/>
                             	                    <strong><?php echo lang('complete_answer_format1'); ?>.</strong>
                                                </div>
                                            <?php }elseif($Type_question_ID==7) {?>
                                                       
                                             <div class="form-group col-lg-12">
                  	                               <div class="form-repeater" style="width: -webkit-fill-available;">
                                                        <div class="repeater-item" style="width: -webkit-fill-available;">
                                                            <div class="col-12 col-m-5">
                                                                 <label for="" class="mb10 strong-weight"><?php echo lang('question'); ?></label>
                  	                                            <textarea  name="txt_match_question[]" cols="120" rows="50" ></textarea>
                  	                                        </div>
                  	                                        &nbsp;<br><br><br>====
                  	                                        <div class="col-12 col-m-5">
                  	                                            <label for="" class="mb10 strong-weight"><?php echo lang('answer'); ?></label>
                  	                                            <textarea  name="txt_match_answer[]" cols="120" rows="50"></textarea>
                  	                                       </div>
                  	                                       &nbsp;&nbsp;&nbsp;&nbsp;
                  	                                       
                  	                                            <a href="#" class="fas fa-plus add-item cl" ></a>
                  	                                       
                  	                               </div>
                  	                               </div>
                                           </div>
                                           <?php } ?>
                                                        <!-- // Form Control -->
                                                    </div>
                                                     <!-- // Grid -->
                                                </div>
                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                     <button class="btn miw-120 small danger outline close-modal"><?= lang('Close') ?></button>
                                                    <button class="btn miw-120 small info" type="submit" ><?php echo lang('br_save') ?></button>
                                                   
                                                </div>
                                          <input  type="hidden" id="rowlevelid"         name="rowlevelid"         value="<?= $rowlevelid ;?>"/> 
				                          <input type="hidden"  id="subjectid"          name="subjectid"          value="<?= $subjectid ;?>"/> 
				                          <input type="hidden"  id="type"               name="type"               value="<?= $type ;?>"/> 
				                          <input type="hidden"  id="Type_question_ID"   name="Type_question_ID"   value="<?= $Type_question_ID ;?>"/> 
			
                                            </form>
                                            
                                            <!--// Container -->
                                </div>
						 </li>
<script>
 $("#loadingDiv").hide();
 function ScrollDown(){
        var elmnt = document.getElementsByClassName("qscroll")[0];
        var h = elmnt.scrollHeight+1000;
        $('.qscroll').animate({scrollTop: h}, 10);
    }
document.addEventListener('DOMContentLoaded', event => { "use strict";
    //====> Check for Tornado <====//
    if (window.Tornado) {
        "use strict";
        //====> Repeater Order <====//
        Tornado.getElements('.repeater-item:first-of-type').forEach(repeater_item => {
            //====> Repeater Data <====//
             
            let item_order = 0;

            //====> Set First Item <====//
            repeater_item.setAttribute('data-order', item_order);
           // Tornado.getElement('.repeater-item .editor').setAttribute('id', item_order);
            //====> When Add Newn <====//
            Tornado.liveEvent(repeater_item.querySelector('.add-item'), 'click', event => {
                item_order = item_order+1;
                let new_item = repeater_item.parentNode.querySelector('.repeater-item:last-child');
                    new_item.setAttribute('data-order', item_order);
                    ScrollDown();  
                    //let new_item1 = repeater_item.parentNode.querySelector('.repeater-item:last-child .editor');
                   //  new_item1.setAttribute('class', 'editor');
            });
            
        });
        ScrollDown();    
        //====> Time Loop for Checkboxes <====//
        Tornado.liveEvent('.repeater-item .chk', 'click', event => {
            //====> Get the Targets Wraper <====//
            let target_wraper = Tornado.parentsUntil(event.target, '.repeater-item'),
                //====> Check The Current Target Order <====//
                target_order = target_wraper.getAttribute('data-order');
            //====> Set the Order to the Currect Answer <====//
            target_wraper.querySelector('.chk').setAttribute('value', target_order);
        });
        
        Tornado.liveEvent('.repeater-item .cl', 'click', event => {
            tinymce.execCommand('mceToggleEditor', false, '0');
            let new_item1 = Tornado.getElement('.repeater-item:last-child .editor');
                  //   new_item1.toggle();
           // tinyMCE.get(".editor").toggle();
          // tinymce.toggle(".editor");
          //  $("iframe").contents().find("body").removeAttr("contenteditable");
            // tinymce.remove('#0');
            // tinymce.activeEditor.destroy();
           //  tinymce.remove();
             window.tinymce.dom.Event.domLoaded = true;
            //====> Get the Targets Wraper <====//
            //let target_wraper = Tornado.parentsUntil(event.target, '.repeater-item'),
                //====> Check The Current Target Order <====//
               // target_order = target_wraper.getAttribute('data-order');
            //====> Set the Order to the Currect Answer <====//
           // target_wraper.querySelector('.chk').setAttribute('value', target_order);
        });
    }
});

         /*===========================================================upload file*/
    	 $('#fileUpload<?= $Type_question_ID ?>').change(function(e) {
                  $("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload<?= $Type_question_ID ?>')[0].files, function(i, file) {data.append('file', file);});
								$.ajax({
										url: '<?php echo site_url('emp/exam_new/up_ax') ?>',
										data: data,
										cache: false,
										contentType: false,
										processData: false,
										type: 'POST',
										beforeSend : function()
										{
											
										},  
										success: function(data){
											$("#loadingDiv").hide();
											if(data.msg_type == 0 )
											{
											   $("#msgUpload").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{
												var newImg = data.base+'upload/'+data.img;
												var hidImg       = $("#hidImg<?= $Type_question_ID ?>").val(data.img);
												$( "#div_img" ).append('<div id="imgcon"><a href="'+newImg+'" ><?php echo lang('am_download');?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
                });

            function delImgUp(){$("#imgcon").remove()}
</script>
                            <?php    }  ?>
                            
                      </ul>
                      
                      <?php    }  ?>
                   
                
       <div id="exam_show"  >
   <?php include('exam_show.php');?>
 </div>

 <script type="text/javascript">
            $(document).ready(function () {
              $("#loadingDiv").hide();
               function clearColumns(ColumnsArray){
           $(ColumnsArray).each(function(){
                $(this).empty();
                $(this).append('<option value="0"> </option>')
            });
        }
        
        function drawColumn(columnID,columnString,columnName){
            columnnameID = "#"+columnName;
            $.each(data, function(key, value) {
                  $('select[name="'+columnName+'"]').append('<option value="'+ columnID +'">'+ columnString + '</option>');
              });
            $(columnnameID).prop("disabled", false);
                          
        }
          $('select[name="slct_class[]"]').on('change', function() {
              var stateID = $(this).val();
              var RowLevel = $("#RowLevel").val();
              if(stateID) {
                  $.ajax({ 
                      url: '<?php echo site_url();?>' + '/emp/Exam_new/get_student/'+ stateID + '/' + RowLevel ,
                      type: "GET",
                      dataType: "json",
                      success:function(data) {
                          $('select[name="slct_student[]"]').empty();
                           $.each(data, function(key, value3) {
                               $('select[name="slct_student[]"]').append('<option value="'+ value3.StudentID +'">'+ value3.StudentName +'</option>');
                                
                               });
                               
              
                              $("#slct_student[]").prop("disabled", false);
                      }
                  });
              }
          });
          
          
     
});
</script>
<script>
    /*========================================== question correct*/
           $("#wrong_answer").click(function(e) {

		  if(!$("#wrong_answer").hasClass('btn danger')){

			 $("#wrong_answer").removeClass('btn default');

			 $("#wrong_answer").addClass('btn danger');

			 $("#right_answer").removeClass('btn info'); 

			 $("#right_answer").addClass('btn default');

			 $("#false_txt").val(1);

			 $("#true_txt").val(0);

			 }

	 });

	 $("#right_answer").click(function(e) {

		   if(!$("#right_answer").hasClass('btn info')){

			 $("#right_answer").removeClass('btn default');

			 $("#right_answer").addClass('btn info');  

			 $("#wrong_answer").removeClass('btn danger');

			 $("#wrong_answer").addClass('btn default');

			 $("#false_txt").val(0);

			 $("#true_txt").val(1);

			 }

	 });
	 	
</script>
     <script type="text/javascript">
    
	/*==================================== question complete*/	
     
              function Create_complete(){
                 
                 tinyMCE.get('txt_question4').execCommand('insertHTML', false, ' ## ');
              }
	 </script>

<script src="<?php echo base_url(); ?>assets_emp/js/tornado.min.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/@wiris/mathtype-generic/wirisplugin-generic.js"></script>