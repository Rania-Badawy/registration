 <script type="text/javascript">
 

$(document).ready(function() {
	 $("#wrong_answer").click(function(e) {
 		 if($("#wrong_answer").hasClass('btn-danger')){
			 $("#wrong_answer").removeClass('btn-danger');
			 $("#wrong_answer").addClass('btn-default');
			 $("#right_answer").removeClass('btn-default');
			 $("#right_answer").addClass('btn-success');  
			 $("#false_txt").val(0);
			 $("#true_txt").val(1);
			 }
		 else if(!$("#wrong_answer").hasClass('btn-danger')){
			 $("#wrong_answer").removeClass('btn-default');
			 $("#wrong_answer").addClass('btn-danger');
			 $("#right_answer").removeClass('btn-success'); 
			 $("#right_answer").addClass('btn-default');
			 $("#false_txt").val(1);
			 $("#true_txt").val(0);
			 }
	 });
	 $("#right_answer").click(function(e) {
 		 if($("#right_answer").hasClass('btn-success')){
			 $("#right_answer").removeClass('btn-success');
			 $("#right_aswer").addClass('btn-default'); 
			 $("#wrong_answer").removeClass('btn-default');
			 $("#wrong_answer").addClass('btn-danger');
			 $("#false_txt").val(1);
			 $("#true_txt").val(0); 
			 }
		  else if(!$("#right_answer").hasClass('btn-success')){
			 $("#right_answer").removeClass('btn-default');
			 $("#right_answer").addClass('btn-success');  
			 $("#wrong_answer").removeClass('btn-danger');
			 $("#wrong_answer").addClass('btn-default');
			 $("#false_txt").val(0);
			 $("#true_txt").val(1);
			 }
	 });
	 $("#BtnAddAns").click(function(e) { 
			 
			var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
  			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
			 var false_txt = $("#false_txt").val();
  			 var true_txt = $("#true_txt").val();
			  var txt_exam_ID= $("#txt_exam_ID").val();
			 
		 if(txt_question!=""&&txt_Degree>0 ){
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach   , false_txt : false_txt , true_txt : true_txt, txt_Tquestion_ID : txt_Tquestion_ID , txt_exam_ID:txt_exam_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#emp_add_question").hide() ;
 											  $('#showAddQuestion').empty() ;
											   $('#question_name').html('') ;
											   $('#txt_Tquestion_ID').val(0) ;
										
 											  $('#showQuestions').append(html) ;
											  
  										}
							   });  
		 }
		  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); } else{$( "#error_txt_question" ).html( "" ); }
		  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; } 
	});
 
});
</script>
 


 
 
        <?php
        if(isset($name_question)){
            foreach($name_question as $row){
                $question_ID   = $row->ID;
                $question_Name = $row->Name;
				$count_Choices =1;
                ?>
            
				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $question_ID;?>"/> 
				<input type="hidden" name="true_txt" id="true_txt" value="1"/> 
				<input type="hidden" name="false_txt" id="false_txt" value="0"/> 
                 <div class="clearfix"></div>                    
     

              <div id="question_div" ></div>    

<div class="clearfix"></div>
          <div class="ask-st">
            <?php /*?><div class="form-group col-lg-2">
            
                <label class="control-label col-lg-3"></label>
                <div class="col-lg-4">
                
                  <div class="radio radio-success">
                <input type="radio" name="answer_radio" checked="checked" value="1" id="RadioGroup1_0" />
                <label></label>
                  </div>
                </div>
                
            </div><?php */?>

            <div class="col-lg-6">
               
                <div class="col-lg-9">
                  <button class="btn btn-default  btn-lg ask_btn" id="wrong_answer">
                  <?php echo lang("wrong_answer"); ?>
                 </button>
                 <button class="btn btn-success btn-lg ask_btn" id="right_answer">
                  <?php echo lang("right_answer"); ?>
                 </button>     
              </div>              
               <?php /*?> <input type="text" name="txt_answer_one" class="form-control full" readonly="readonly" style="float:none;clear:both;"  id="txt_answer_one"  value="<?php echo lang('right_answer'); ?>" ><?php */?>
               
              <?php /*?>  <div class="col-lg-9">
                <div class="error errorText"><?php echo form_error('txt_answer_one') ?></div>
                </div><?php */?>
            </div>
         <div class="col-lg-6">
            <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save"></i> <?php echo lang('am_save');?></button>
          </div>       
<div class="clearfix"></div>      
        
            <?php /*?><div class="form-group col-lg-2">
                <label class="control-label col-lg-3"></label>
                <div class="col-lg-4">
                  <div class="radio radio-success">
                 <input type="radio" name="answer_radio" value="2" id="RadioGroup1_1" />
				 <label></label>
                  </div>
                </div>
            </div><?php */?>

            <?php /*?><div class="form-group col-lg-6">
                <div class="col-lg-9">
                 <input type="text" class="form-control full" name="txt_answer_two" readonly="readonly" id="txt_answer_two"  value="<?php echo lang('wrong_answer'); ?>" >
                </div>
                <div class="col-lg-9">
                <div class="error errorText"><?php echo form_error('txt_answer_two') ?></div>
                </div>
            </div><?php */?>


</div>

<div class="clearfix"></div>  
      
                       
              
                <?php
                }
            }
        ?><input type="hidden" name="txt_exam_ID" id="txt_exam_ID" value="<?php echo $exam_ID;?>"/>
        
      
<div class="clearfix"></div>  
  