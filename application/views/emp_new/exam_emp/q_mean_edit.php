 <script type="text/javascript">
 

$(document).ready(function() {
 	 $("#BtnAddAns").click(function(e) { 
			 
			 var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
  			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
			 var txt_answer = $("#txt_answer").val();
			 var txt_answer_ID = $("#txt_answer_ID").val();
			 var txt_question_ID = $("#txt_question_ID").val();
			 
			 
		 if(txt_question!=""&&txt_Degree>0&&txt_answer!="" &&txt_question_ID>0){
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/update_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach   , txt_answer : txt_answer , txt_Tquestion_ID : txt_Tquestion_ID ,txt_answer_ID:txt_answer_ID , txt_question_ID : txt_question_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#emp_add_question").hide() ;
 											  $('#showAddQuestion').empty() ;
											   $('#question_name').html('') ;
											   $('#txt_Tquestion_ID').val(0) ;
										
 											  $('#question_'+txt_question_ID).remove() ;
 											  $('#showQuestions').append(html) ;
											  
  										}
							   });  }
		  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); } else{$( "#error_txt_question" ).html( "" ); }
		  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; } 
		  if(txt_answer!=""){$( "#error_txt_answer" ).html( "" );} else{$( "#error_txt_answer" ).html( "يجب ادخال اجابة " ) ; } 
	});
 
});
</script>
 
<style>

.controls iframe {
	width:100% !important;
	height:100% !important;
	}
</style>
    <div class="clearfix"></div>
 

 <div class="ask-st">
 <div class="col-lg-12">
        <div id="collapseDVR3" class="panel-collapse collapse in">
 
 
        <?php 
        if(isset($item_question)){
            foreach($item_question as $row){
                $questions_content_ID      = $row->questions_content_ID;
                $question_Name      = $row->Name;
				$Question           = $row->Question;
				$Degree             = $row->Degree;
				$attach             = $row->Q_attach;
				$questions_types_ID = $row->questions_types_ID;
				$Answer             = $row->Answer;
				$answers_ID         = $row->answers_ID;
				$youtube_script = $row->youtube_script;
				$degree_difficulty = $row->degree_difficulty;
				$count_Choices =1;
				
			}
                ?>
           
 <div class="clearfix"></div>     <!-- Question Area  Start -->
<div class="sec-title">	
       <h2 dir="rtl"><?php echo $question_Name;?> - <?php echo $question_Type;?></h2>
</div>
      <div class="clearfix"></div>
        
             
            
<script>

			 var txt_question = tinyMCE.get('txt_question').setContent('<?php echo $question?>'); 
			 $('input[name="difficult_degree"]:checked').val('<?php echo $degree_difficulty?>');
			 var txt_Degree = $("#txt_Degree").val('<?php echo $Degree?>');
			 var txt_attach = $("#txt_attach").val('<?php echo $attach?>');
  			 $( "#div_img" ).html('<div id="imgcon"><a href="'+<?php echo $attach?>+'" target="_blank"  >تحميل</a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
</script>    

              <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><?php echo lang('answer'); ?></label>
                <div class="col-lg-9">
                   <input type="text" class="form-control full" name="txt_answer" id="txt_answer"  value="<?php echo $Answer;?>">
                     <input type="hidden" name="txt_answer_ID" id="txt_answer_ID" value="<?php echo $answers_ID;?>"/>
                </div>
                <div class="col-lg-9">
                <div class="error errorText" id="error_txt_answer" ></div>
                 
                </div>
            </div>
            

 <div class="clearfix"></div>   
              
            <div class="alert alert-info text-right">
             	<strong><?php echo lang('complete_answer_format'); ?></strong>
             </div>
             

                   
   <div class="clearfix"></div>          
          <?php
            }
        ?>
             
               <input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>
             
               <input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $questions_types_ID;?>"/>
   <div class="clearfix"></div>  

          <div class="form-group">
            <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><?php echo lang('am_save');?></button>
          </div> 
          <div class="clearfix"></div>     
 
</div>
 <div class="clearfix"></div>     
</div>
 <div class="clearfix"></div>     
</div>
 <div class="clearfix"></div>    