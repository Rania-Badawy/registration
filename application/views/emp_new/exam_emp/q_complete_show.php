 
        <?php
        if(isset($item_question)){  
            foreach($item_question as $row)
			{
            	$question_Name 	  = $row->test_Name;
				$question_Type 	  = $row->Name;
				$questions_types_ID = $row->questions_types_ID;
				$question 		  = $row->Question ;
				$questions_content_ID	  = $row->questions_content_ID ; 
				$Degree   		  = $row->Degree;
				
				$attach             = $row->Q_attach;
				$youtube_script = $row->youtube_script;
				$degree_difficulty = $row->degree_difficulty;
				
				$count_Choices 	  = 1;
			} 
                 ?><div id="question_<?php echo $questions_content_ID;?>">

<style>

.controls iframe {
	width:100% !important;
	height:100% !important;
	}
</style>
                     <script type="text/javascript"> 
				  $(document).ready(function() {
				  $("body, html").animate({
						 scrollTop: $("#question_"+<?php echo $questions_content_ID;?>).position().top
						 });	
				 });
function delete_q(txt_q_ID){
	  
 			  $.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/del_qui') ?>",
								data    :{txt_q_ID:txt_q_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#question_"+txt_q_ID).hide() ; 
											  
  										}
			   }); 
	 }
function edit_q(txt_q_ID){
	  
 			  $.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/show_edit_question') ?>",
								data    :{txt_q_ID:txt_q_ID} ,
								cache   : false,
								success : function(html)
										{
											
 	 											 $("#question_"+txt_q_ID).hide() ; 
 	 											 $("#emp_add_question").show() ;
 											   $('#showAddQuestion').html(html) ;
											   $('#question_name').html('<?php echo    $question_Type  ;?>') ;
											   $('#txt_Tquestion_ID').val('<?php echo    $questions_types_ID  ;?>') ;
											    $("body, html").animate({
						scrollTop: $("#emp_add_question").position().top
						 });	
  										}
			   }); 
	 }
</script>
    <div class="clearfix"></div>


 <div class="block-st q-st">
 
        <div id="collapseDVR3" class="panel-collapse collapse in">
  

<!-- Question Area  Start -->
<div class="sec-title">	
       <h2 dir="rtl"><?php echo $question_Type;?>  </h2>
        <a href="#" onclick="delete_q('<?php echo $questions_content_ID;?>');" class="btn btn-danger pull-left btn_exam_tool btn_exam_tool1"><i class="fa fa-trash"></i>  <?php echo lang('am_delete');?></a>
            <a href="#" onclick="edit_q('<?php echo $questions_content_ID;?>');" class="btn btn-success pull-left btn_exam_tool btn_exam_tool2" ><i class="fa fa-edit"></i> <?php echo lang('am_edit');?></a>
</div>
      <div class="clearfix"></div>
        
   
			  	<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $questions_types_ID;?>"/>
				<input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>
 <div class="clearfix"></div>                    
            <div class="form-group col-lg-12">
                <label class="control-label col-lg-1"><div class="error pull-left" >*</div> <?php echo lang('question'); ?></label>
                <div class="col-lg-11 text-right">
                	<label class="control-label">
					<?php echo $question;?>
                    </label>    
                            
                </div>
                 
            </div>

             

          
            <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><?php echo lang('Degree'); ?></label>
                <div class="col-lg-9 text-right">
                <label class="control-label">
                   <?php echo $Degree; ?>
                </label>
                </div>
            </div>


      
     <?php   if($attach!=""&&file_exists("upload/".$attach)){?>               
            <div class="form-group col-lg-6"  >
                <label class="control-label col-lg-2"><?php echo lang('attach');?>  </label>
               
                <div class="col-lg-2">
          
     <a class="btn btn-success" href="<?php echo base_url()?>upload/<?php echo $attach;?>"  target="_blank" >
	 <i class="fa fa-download"></i>  <?php echo lang('am_download');?></a>      
                </div>
                 
            </div><?php }?>  
<div class="clearfix"></div>


            <div class="form-group col-lg-6" style="display:none">
                <label class="control-label col-lg-3"><?php echo lang('youtube_script'); ?></label>
                <div class="form-group col-lg-9">
                <input type="text" class="form-control"  name="youtube_script"  id="youtube_script"  style="float:none;clear:both;"  value=""  >
               </div>
                <div class="col-lg-12 form-group text-center">
                <?php echo $youtube_script;?>
                </div>
                <div class="col-lg-9">
                 <div class="error errorText" ><?php echo form_error('youtube_script') ?></div>
                </div>
                
                
            </div>
<div class="clearfix"></div>
 
             <div id="correct_answer_div" >
             
             
              <?php 
				echo '<div class="clearfix"></div><div class="form-group col-lg-12" dir="rtl">';
			    $str = strip_tags($question);
				$txt_answers_pieces = explode("##", $str);
				$array_count = count($str);
				$index_answer = strrpos($str,'##');
				$count_index_answer =0;
				$num_all_ans = 0;
				$count_Answer =1;
				if($index_answer>=0 ){
					echo '<label class="control-label " >'.$txt_answers_pieces[$count_index_answer].'</label>';
					$count_index_answer++;
					}
				$count_Str = substr_count($str, '##');
			    foreach($item_question as $row){
                $Answer = strip_tags($row->Answer);
				
				?>
                <label class="control-label ">
                 <?php echo $Answer;?>
                </label>
                <div class="col-lg-9">
                <div class="error errorText" id="error_ans" style="display:none"><?php echo lang('complete_answer_not_write');?></div>
                </div>
				<?php
				if($count_index_answer<=count($txt_answers_pieces)-1){
                echo '<label class="control-label " ></label><label class="control-label">'.$txt_answers_pieces[$count_index_answer].'</label>';
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
   			
            
     
                
          
             <?php
            }
        ?> 
               <input type="hidden" name="txt_q_ID" id="txt_q_ID" value="<?php echo $questions_content_ID;?>"/>
               
               

           
          <div class="clearfix"></div>   

                   
            </div> 
            
            
  
                     
          
  
          

 <div class="clearfix"></div>   
</div>