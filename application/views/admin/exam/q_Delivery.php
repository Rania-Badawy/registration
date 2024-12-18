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
  			 var txt_question_ID = $("#txt_question_ID").val();
			 var false_txt = $("#false_txt").val();
  			 var true_txt = $("#true_txt").val();
			 
		 if(txt_question!=""&&txt_Degree>0&&txt_question_ID>0 ){
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/update_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach   , false_txt : false_txt , true_txt : true_txt, txt_Tquestion_ID : txt_Tquestion_ID , txt_question_ID:txt_question_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#emp_add_question").hide() ;
 											  $('#showAddQuestion').empty() ;
											   $('#question_name').html('') ;
											   $('#txt_Tquestion_ID').val(0) ;
										$('#question_'+txt_question_ID).remove();
 											  $('#showQuestions').append(html) ;
											  
  										}
							   });   
		 }
		  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); } else{$( "#error_txt_question" ).html( "" ); }
		  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; } 
	});
 
});
</script>
 

    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">
        <div id="collapseDVR3" class="panel-collapse collapse in">
 
 <?php
		if ($this->session->flashdata('result') != ''): 
			echo '<div class="error errorText">'.$this->session->flashdata('result').'</div>'; 
		endif;
        if(isset($item_question)){
            foreach($item_question as $row){
                $questions_content_ID      = $row->questions_content_ID;
                $question_Name      = $row->Name;
				$question           = $row->Question;
				$Degree             = $row->Degree;
				$attach             = $row->Q_attach;
				$questions_types_ID = $row->questions_types_ID;
				$youtube_script = $row->youtube_script;
				$degree_difficulty = $row->degree_difficulty;
				$count_Choices =1;
				
			}
                ?>
                <br/>
                <div class="sec-title">	 
                <h2> <?php echo $question_Name;?></h2>
			    </div>
                
               <input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>
             
               <input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $questions_types_ID;?>"/>
 <?php
 			  foreach($item_question as $row){
				   $answer_txt = $row->Answer;
				   $id_answer = $row->answers_ID;
				   $Answer_correct = $row->Answer_correct;
					 if($answer_txt==lang('right_answer')&&$Answer_correct==1){
						 ?>
               
                 <button class="btn btn-success btn-lg ask_btn" id="right_answer">
                  <?php echo lang("right_answer"); ?>
                 </button>  
						
				<input type="hidden" name="true_txt" id="true_txt" value="1"/> 
 						 <?php
						 }else if($answer_txt==lang('right_answer')&&$Answer_correct==0){?> 
                 <button class="btn btn-default btn-lg ask_btn" id="right_answer">
                  <?php echo lang("right_answer"); ?>
                 </button>     
				<input type="hidden" name="true_txt" id="true_txt" value="0"/> 
 				 <?php	 }   else if($answer_txt==lang('wrong_answer')&&$Answer_correct==1){?>
						
                 <button class="btn btn-danger btn-lg ask_btn" id="wrong_answer">
                  <?php echo lang("wrong_answer"); ?>
                 </button>  
				<input type="hidden" name="false_txt" id="false_txt" value="1"/> 
			 <?php   }else if($answer_txt==lang('wrong_answer')&&$Answer_correct==0){?>
						
                 <button class="btn btn-default btn-lg ask_btn" id="wrong_answer">
                  <?php echo lang("wrong_answer"); ?>
                 </button> 
				<input type="hidden" name="false_txt" id="false_txt" value="0"/> <?php }?>
             
        
             <?php
            } 
        ?>   
             
               
               

          <div class="form-group">
            <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><?php echo lang('am_save');?></button>
          </div> 
            <div class="clearfix"></div>
 
</div>
</div>
    <div class="clearfix"></div>
</div>
    <div class="clearfix"></div>
</div>
   <?php
            } 
        ?>   
             