  
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
				$degree_difficulty = $row->degree_difficulty;
				$count_Choices =1;
				
			}
                ?>
                <div id="question_<?php echo $questions_content_ID;?>">
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
											   $('#question_name').html('<?php echo    $question_Name  ;?>') ;
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

                <div class="sec-title">	 
                <h2> <?php echo $question_Name;?></h2>
                 <a href="#" onclick="delete_q('<?php echo $questions_content_ID;?>');" class="btn btn-danger pull-left btn_exam_tool btn_exam_tool1"><i class="fa fa-trash"></i>  <?php echo lang('am_delete');?></a>
            <a href="#" onclick="edit_q('<?php echo $questions_content_ID;?>');" class="btn btn-success pull-left btn_exam_tool btn_exam_tool2" ><i class="fa fa-edit"></i> <?php echo lang('am_edit');?></a>
			    </div>
       
  
 <style>
 #txt_question_toolbargroup span table{
	 width:43% !important;
	 float:right !important;
	 padding-bottom:5px;
	 }
 </style>    
			
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
  <div class="col-lg-6">
 		   
                         <div class="col-lg-9">

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
						 
						 <?php
						 }else if($answer_txt==lang('right_answer')&&$Answer_correct==0){?> 
                 <button class="btn btn-default btn-lg ask_btn" id="right_answer">
                  <?php echo lang("right_answer"); ?>
                 </button>     
 				 <?php	 }   else if($answer_txt==lang('wrong_answer')&&$Answer_correct==1){?>
						
                 <button class="btn btn-danger btn-lg ask_btn" id="wrong_answer">
                  <?php echo lang("wrong_answer"); ?>
                 </button>  
			 <?php   }else if($answer_txt==lang('wrong_answer')&&$Answer_correct==0){?>
						
                 <button class="btn btn-default btn-lg ask_btn" id="wrong_answer">
                  <?php echo lang("wrong_answer"); ?>
                 </button> <?php }?>
             
        
             <?php
            } 
        ?>   
              </div>        
                  
            </div>  
            
            <input type="hidden" name="num_Choices" id="num_Choices" value="<?php  echo $count_Choices;?>" />
 			<input type="hidden" name="num_checkbox" id="num_checkbox" value="1" />
               <input type="hidden" name="txt_q_ID" id="txt_q_ID" value="<?php echo $questions_content_ID;?>"/>
               
              
            <div class="clearfix"></div>


    <div class="clearfix"></div>
</div>
    <div class="clearfix"></div>
</div>
<?php }?>
</div>