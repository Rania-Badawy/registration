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
                 ?> 
<div id="question_<?php echo $questions_content_ID;?>">

<script type="text/javascript" >
$( document ).ready(function() 
{	
	/* Add New Choice */ 
    $("#add_Choice").click(function(e) 
	{ 
		$('#loadingDiv').show();
		
		var num_Choices = parseInt($("#num_Choices").val());
		document.getElementById('num_Choices').value=num_Choices;
		var oldValue = num_Choices-1;
		var value_Choices=new Array(); 
		
		if(oldValue>2)
		{
			var countValue = 3;
			var count_array =0;
			while(countValue<=oldValue)
			{
				var txt_Choices = 'txt_Choices'+countValue;
				value_Choices[count_array] = document.getElementById(txt_Choices).value;
				countValue++;
				count_array++;
			}
		}
	
		document.getElementById('Choices_Div').innerHTML +='<div class="form-group col-lg-10"><li><input type="text" name="txt_Choices'+num_Choices+'" class="form-control" onkeyup="show_slct();" id="txt_Choices'+num_Choices+'" /></li></div>' ;
		
		if(oldValue>2)
		{
			document.getElementById('num_Choices').value=num_Choices+1;
			var countValue = 3;
			var count_array =0;
			while(countValue<=oldValue)
			{
				var txt_Choices = 'txt_Choices'+countValue;
				 document.getElementById(txt_Choices).value=value_Choices[count_array];
				countValue++;
				count_array++;
			}
		}
		
		$('#loadingDiv').hide();
	});
	
	
	/* Update Choices to choose Correct */
	$("#slct_Correct_Answer").click(function(e) 
	{	
		var Correct_Answer  ='<select id="slct_Correct_Answer" class="selectpicker form-control" name="slct_Correct_Answer">';
		count_select=1;
		var num_Choices = parseInt($("#num_Choices").val());
		
		while(count_select<num_Choices)
		{
			 var all_txt = "#txt_Choices"+count_select;
			  var choice_txt = $(all_txt).val();
			  
			  Correct_Answer +='<option value="'+choice_txt+'">'+choice_txt+'</option>';
			  count_select++;
		}	
		Correct_Answer +='</select>';	
		$('#Correct_Answer').html('');
		document.getElementById('Correct_Answer').innerHTML = Correct_Answer  ;
		});
	
	
		
});
function show_slct(){
		var Correct_Answer  ='<select id="slct_Correct_Answer" class="selectpicker form-control" name="slct_Correct_Answer">';
		count_select=1;
		var num_Choices = parseInt($("#num_Choices").val());
		
		while(count_select<num_Choices)
		{
			 var all_txt = "#txt_Choices"+count_select;
			  var choice_txt = $(all_txt).val();
			  
			  Correct_Answer +='<option value="'+choice_txt+'">'+choice_txt+'</option>';
			  count_select++;
		}	
		Correct_Answer +='</select>';	
		$('#Correct_Answer').html('');
		document.getElementById('Correct_Answer').innerHTML = Correct_Answer  ;
	
	}
</script>
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
       <h2 dir="rtl"><?php echo $question_Name;?> - <?php echo $question_Type;?></h2> 
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
 
              <?php   if($attach!=""){if(file_exists("upload/".$attach)){?>               
            <div class="form-group col-lg-6"  >
                <label class="control-label col-lg-2"><?php echo lang('attach');?> </label>
               
                <div class="col-lg-2">
          
     <a class="btn btn-success" href="<?php echo base_url()?>upload/<?php echo $attach;?>"  target="_blank" >
	 <i class="fa fa-download"></i>  <?php echo lang('am_download');?></a>
              
                </div>
                 
            </div><?php } }?>  
<div class="clearfix"></div>
            <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><?php echo lang('Choices'); ?></label>
                <div class="col-lg-7">
                <ul style="direction:rtl;list-style:none;margin:0px;padding:0px;" >
                	<div>
                    <?php 
                        foreach($item_question as $key=>$row)
                        {
                    ?>
                       
                            <?php $AnswerID = $row->answers_ID  ;
                                  $Answer   = $row->Answer  ;
				$Answer_correct = $row->Answer_correct; ?>
                            
                            
                             <li class="<?php if($Answer_correct==1){?> check_div <?php }else{?> non_answer <?php }?> check_div_static check_div_static2" style="padding-right:15px;">
                             <div class="count-nom<?php if($Answer_correct==1){?> count-nom_co <?php }?>">
                              <?php echo $key+1;?>
                             </div>
                              <div>
                                     <?php echo $Answer ;?> <!-- Answer -->
                              </div>      
                              
                                   
									<?php if($count_Choices<=2){?> <?php }?>
                                <div class="clearfix"></div>
                            </li>
                            
                            <div class="error"><?php echo form_error('txt_Choices'.$count_Choices.'') ?></div>
                            
                      
                     
					<?php		
                    $count_Choices++;
                        
                        }
                	?>
                    	
                        <div id="Choices_Div"></div> <!-- Input Txt Here -->
                    </div>
                   	
                  <input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_types_ID;?>"/>  
            		
                    <div id="loadingDiv" style="display:none;" ><img src="<?php echo base_url()?>/images/loading.gif"/></div> 
                     <input type="hidden" name="num_Choices" id="num_Choices" value="<?php  echo $count_Choices;?>" />
                </ul>
                </div><?php /*?>
                <div class="col-lg-2">
                <div id="Correct_Answer" class="controls span9" > <!-- Select Option Here -->
          	 <a class="btn btn-success"  herf="#"  name="add_Choice" id="add_Choice" ><?php echo lang('add_Choice'); ?></a>
</div>
                </div><?php */?>
           
         <?php
         }
        ?>                
            </div>
         
                           <input type="hidden" name="txt_q_ID" id="txt_q_ID" value="<?php echo $questions_content_ID;?>"/>

             

          
<!-- Answers Area End -->     <div class="clearfix"></div>  
 


     <div class="clearfix"></div>  
</div>

     <div class="clearfix"></div>  
</div>
</div>