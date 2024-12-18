 

	   <style type="text/css" >.error {width:auto;}.errorText {float:none;clear:both; }</style>
 
 <script type="text/javascript">
 

$(document).ready(function() {
 	 $("#BtnAddAns").click(function(e) { 
			 
			 var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
  			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
			 var txt_answer = $("#txt_answer").val();
			  var txt_exam_ID= $("#txt_exam_ID").val();
			 
		 if(txt_question!=""&&txt_Degree>0&&txt_answer!="" ){
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach   , txt_answer : txt_answer , txt_Tquestion_ID : txt_Tquestion_ID, txt_exam_ID:txt_exam_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#emp_add_question").hide() ;
 											  $('#showAddQuestion').empty() ;
											   $('#question_name').html('') ;
											   $('#txt_Tquestion_ID').val(0) ;
										
 											  $('#showQuestions').append(html) ;
											  
  										}
							   });   }
		  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); } else{$( "#error_txt_question" ).html( "" ); }
		  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; } 
		  if(txt_answer!=""){$( "#error_txt_answer" ).html( "" );} else{$( "#error_txt_answer" ).html( "يجب ادخال اجابة " ) ; } 
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

              <div id="question_div" ></div>                   

    
 
  <div class="clearfix"></div>
         <div class="ask-st">
         
         <div class="form-group col-lg-12">
            <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save"></i> <?php echo lang('am_save');?></button>
          </div>    
             
            <div class="col-lg-12">
                 <div class="alert alert-info" dir="rtl">
             	<strong><?php echo lang('complete_answer_format'); ?>.</strong>
                 </div>
            </div>     
   
<div class="clearfix"></div> 
<div class="form-group col-lg-6">
<label class="control-labe col-lg-3" for="inputEmail"><?php echo lang('answer'); ?> </label>
<div class="col-lg-9">
<input type="text" class="form-control full" name="txt_answer" id="txt_answer"  value="" >
</div>
           
                <div class="col-lg-9">
                <div class="error errorText" id="error_txt_answer" ></div>
                 
                </div>
</div>

  <div class="clearfix"></div> 
  </div>

             
          
                <?php
                }
            }
        ?><input type="hidden" name="txt_exam_ID" id="txt_exam_ID" value="<?php echo $exam_ID;?>"/>

          
  <div class="clearfix"></div> 

 