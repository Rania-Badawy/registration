      <?php 
        if(isset($item_question)){
            foreach($item_question as $row){
                $questions_content_ID      = $row->questions_content_ID;
                $question_Name      = $row->Name;
				$question           = $row->Question;
				$Degree             = $row->Degree;
				$attach             = $row->Q_attach;
				$questions_types_ID = $row->questions_types_ID;
				$youtube_script = $row->youtube_script;
				$count_Choices =1;
				
			}
                ?>  
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
  			 var txt_question_ID = $("#txt_question_ID").val();
			 var num_answers = $("#num_answers").val();
			 var answer_txt = new Array();
			 var count=0;
  			while(num_answers>0){ 
 			  answer_txt[count] = $("#answer_txt_"+num_answers).val();
 				num_answers--;
				count++;
				}
			 
			 var num_answers = $("#num_answers").val();
		 if(txt_question!=""&&txt_Degree>0&&num_answers>0&&txt_question_ID>0){
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach   , num_answers : num_answers , answer_txt : answer_txt, txt_Tquestion_ID : txt_Tquestion_ID,txt_question_ID:txt_question_ID} ,
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
		  if(num_answers>0){$( "#error_num_answers" ).html( "" );} else{$( "#error_num_answers" ).html( "يجب ادخال اجابة " ) ; } 
	});
 
});
</script>
<script type="text/javascript">
 
$( document ).ready(function() {
	    $("#Create_answers").click(function(e) {
			 var str          = tinyMCE.get('txt_question').getContent();
			
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
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">
  <div class="form-group col-lg-6 text-right"> 
              <a class="btn btn-warning" onclick="Create_answers();"  herf="#" name="Create_answers" id="Create_answers" ><?php echo lang('Create_Correct_Answers'); ?></a>
              
              <a class="btn btn-info " onclick="Create_complete();"  herf="#" name="Create_answers" id="Create_answers" >اضافة مكان اجابه فى السؤال</a>
              </div>
        <div id="collapseDVR3" class="panel-collapse collapse in">
 
  
               
				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $questions_types_ID;?>"/>
				<input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>
 
<div class="clearfix"></div>  
            
 <div class="clearfix"></div>   
            
              
             
             <div id="correct_answer_div" >
             
             
              <?php 
			  	echo ' <div class="sec-title"><h2>'.lang('Correct_Answers').'</h2></div><div class="clearfix"></div>';
				echo '<div class="clearfix"></div><div class="form-group col-lg-6">';
			    $str = strip_tags($question);
				$txt_answers_pieces = explode("##", $str);
				$array_count = count($str);
				$index_answer = strrpos($str,'##');
				$count_index_answer =0;
				$num_all_ans = 0;
				$count_Answer =1;
				if($index_answer>=0 ){
					echo '<label class="control-label col-lg-3" >'.$txt_answers_pieces[$count_index_answer].'</label>';
					$count_index_answer++;
					}
				$count_Str = substr_count($str, '##');
			    foreach($item_question as $row){
                $Answer = strip_tags($row->Answer);
				
				?>
                <div class="col-lg-9">
                <input type="text" class="form-control" id="answer_txt_<?php echo $count_Answer?>" name="answer_txt_<?php echo $count_Answer?>" value="<?php echo $Answer;?>" />
                </div>
                <div class="col-lg-9">
                <div class="error errorText" id="error_ans" style="display:none"><?php echo lang('complete_answer_not_write');?></div>
                </div>
				<?php
				if($count_index_answer<=count($txt_answers_pieces)-1){
                echo '<label class="control-label col-lg-3" ></label><label class="col-lg-9">'.$txt_answers_pieces[$count_index_answer].'</label>';
				}
                $count_index_answer++;
                $count_Answer++;
				$num_all_ans++;
                } ?> 
            <input type="hidden" id="old_text" name="old_text" value="<?php echo strip_tags($question);?>" />
             <input type="hidden" id="num_answers" name="num_answers" value="<?php echo $num_all_ans;?>" />
            <input type="hidden" id="count_Answer" name="count_Answer" value="<?php echo $count_Answer;?>" />
             </div>
             </div>
            
             
            <div id="loadingDiv" style="display:none;" ><img src="<?php echo base_url()?>/images/loading.gif" /></div>
   			
         
                

                   
            </div> 
            
            
  
                     
          
            
             <?php
            }
        ?>
            
            <input type="hidden" name="num_Choices" id="num_Choices" value="<?php  echo $count_Choices;?>" />
 			<input type="hidden" name="num_checkbox" id="num_checkbox" value="1" />
               <input type="hidden" name="txt_q_ID" id="txt_q_ID" value="<?php echo $edit_question_ID;?>"/>
               
  <div class="clearfix"></div> 
                <div class="col-lg-9">
                <div class="error errorText" id="error_num_answers" ></div>
                 
                </div>

  <div class="clearfix"></div> 
          <div class="col-lg-12 form-group">
            <button type="button" id="BtnAddAns" class="btn btn-success"><?php echo lang('am_save');?></button>
          </div> 
          <div class="clearf<div class="col-lg-12">
            <div class="alert alert-info" dir="rtl">
             	<strong><?php echo lang('how_complete') ?>.</strong>
                <br/>
             	<strong><?php echo lang('complete_answer_format'); ?>.</strong>
             </div>
          </div>ix"></div>   
           
  <div class="clearfix"></div> 
    </div>       
 </div>
  <div class="clearfix"></div>   
</div>
 <div class="clearfix"></div>   
</div>
