<style type="text/css" >.error {width:auto;}.errorText {float:none;clear:both; }</style>
 
 <script type="text/javascript">
function Create_complete(){
 	tinyMCE.get('txt_question').execCommand('insertHTML', false, ' ## ');
	} 

$(document).ready(function() {
 	 $("#BtnAddAns").click(function(e) { 
			 
			var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
  			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
			 var num_answers = $("#num_answers").val();
			  var txt_exam_ID= $("#txt_exam_ID").val();
			 var answer_txt = new Array();
			 var count=0;
  			while(num_answers>0){ 
 			  answer_txt[count] = $("#answer_txt_"+num_answers).val();
 				num_answers--;
				count++;
				}
			 
			 var num_answers = $("#num_answers").val();
		 if(txt_question!=""&&txt_Degree>0&&num_answers>0){
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach   , num_answers : num_answers , answer_txt : answer_txt, txt_Tquestion_ID : txt_Tquestion_ID , txt_exam_ID:txt_exam_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#emp_add_question").hide() ;
 											  $('#showAddQuestion').empty() ;
											   $('#question_name').html('') ;
											   $('#txt_Tquestion_ID').val(0) ;
										
  											  $('#showQuestions').append(html) ;
											  
  										}
							   });  }					  
		  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); } else{$( "#error_txt_question" ).html( "" ); }
		  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; } 
		  if(num_answers>0){$( "#error_num_answers" ).html( "" );} else{$( "#error_num_answers" ).html( "يجب ادخال اجابة " ) ; } 
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
 <div class="form-group col-lg-6 text-right"> 
              <a class="btn btn-warning" onclick="Create_answers();"  herf="#" name="Create_answers" id="Create_answers" ><?php echo lang('Create_Correct_Answers'); ?></a>
              
              <a class="btn btn-info " onclick="Create_complete();"  herf="#" name="Create_answers" id="Create_answers" >اضافة مكان اجابه فى السؤال</a>
              </div>
  <div class="form-group col-lg-6">
            <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save"></i> <?php echo lang('am_save');?></button>
          </div>
          
             
<div class="clearfix"></div>              
             
            
             
             <div class="col-lg-12">
             <div id="correct_answer_div" dir="rtl">
             <input type="hidden" id="num_answers" name="num_answers" value="0" />
             </div>
             </div>
             <div id="Choices_Div"></div>
   		
<div class="clearfix"></div>
                <div class="col-lg-9">
                <div class="error errorText" id="error_num_answers" ></div>
                 
                </div>
<div class="clearfix"></div> <div class="col-lg-12">
            <div class="alert alert-info" dir="rtl">
             	<strong><?php echo lang('how_complete') ?>.</strong>
                <br/>
             	<strong><?php echo lang('complete_answer_format'); ?>.</strong>
             </div>
          </div> 
<div class="clearfix"></div>            
           
<div class="clearfix"></div>                


            
                   
</div>
   
<div class="clearfix"></div>               
            
            
            
            <input type="hidden" name="num_Choices" id="num_Choices" value="<?php  echo $count_Choices;?>" />
 			<input type="hidden" name="num_checkbox" id="num_checkbox" value="1" />
                <?php
                }
            }
        ?><input type="hidden" name="txt_exam_ID" id="txt_exam_ID" value="<?php echo $exam_ID;?>"/>
        
         
          
<div class="clearfix"></div>  
   