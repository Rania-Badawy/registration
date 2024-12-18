<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 
<script  src="<?php echo base_url()?>js/jquery.timer.js" ></script>
<style>
.sortable, .sortable_l { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: right; margin-right: 10px; }
.sortable li, .sortable_l li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
.section iframe {width:100% !important;height:100% !important;}
</style>

<script type="text/javascript"> 
$(document).ready(function() { 
	 $('input[name=radioCheck]').on('change', function() {
		   alert($('input[name=radioCheck]:checked').val()); 
		});
     $( "form" ).submit(function( event ){
		var q_count =$("#txt_q_count").val();
		var count_answer = $("#txt_q_one_count_"+q_count).val();
		for (index = 1; index <= count_answer; ++index) {
		idsInOrder = $("#sortable"+index).sortable("toArray");
		$("#all_answer_"+index).val(idsInOrder);
		};
		return true ; 
    });
	var q_count =$("#txt_q_count").val();
	var num_q =$("#txt_q_one_count_"+q_count).val();
	for (index = 1; index <= num_q; ++index) {
			$("#sortable"+index ).sortable({connectWith: "#sortable"+index }).disableSelection();
		}
		
});
</script>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>exam/exam.css"  />
 <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/answers.css"  />
<script type="text/javascript">	
		var count = 0;
		var timer = $.timer(
			function() {
				count++;
				$('.count').val(count);
				/*alert($('.count').val());*/
				if($('.count').val()==$('#txt_time_count').val()){
					alert('end time');
					document.location.href='<?php echo site_url('emp/answer_new_exam/correction_exam'); ?>';
					}
			},
			1000,
			true
		);	
	</script><script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script>
<script type="text/javascript">
var AMTcgiloc = "http://www.imathas.com/cgi-bin/mimetex.cgi";  		//change me
</script>

<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
    theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg",
    theme_advanced_buttons3 : "",
    theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    plugins : 'asciimath,asciisvg,table,inlinepopups,media',
   
    AScgiloc : 'http://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'http://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
});

 
</script>


    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">

<?php

	 function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }
 if($exam_details!=0){ 
 foreach($exam_details as $row){
 	$test_ID            = $row->test_ID ;
	$test_Name          = $row->test_Name ;
 	$test_Description   = $row->test_Description ;
	$time_count         = $row->time_count ;
 }
 ?>
  <div class="sec-title">
 <h2><?php echo $test_Name?></h2>
 <span class="pull-left">  <input type="button" class=" btnSave btn btn-success" value="انهاء" />
</span>
 </div>
 <div class="clearfix"></div>

 		<div class="form-group col-lg-8">
             <label class="col-lg-3 label-control"> <?php echo lang('Description') ;?> </label>  
             <label class="col-lg-9 label-control"><?php echo $test_Description?></label>
         </div>
 <?php if($time_count!=""){?>
 
        <div class="clock_st_co">
             <label class="col-lg-4"> <?php echo lang('Time') ;?></label>  
              <input type="text" id="counter" name="counter" class='count smallWidth clock_st col-lg-4' readonly="readonly"/>  
             <input type="hidden"  id="txt_time_count" name="txt_time_count"  value="<?php echo $time_count*60?>" >
             <label class="col-lg-4"> <?php echo lang('second') ;?></label>
             </div>
             <div class="error"><?php echo form_error('txt_time') ?></div>
 <?php }?>
 <input type="hidden" id="txt_time_count" name="txt_time_count" value="<?php echo $time_count?>"/>
 <input type="hidden" id="txt_test_ID" name="txt_test_ID" value="<?php echo $test_ID?>"/>
  		<div   class="swMain">
 
			<?php
///////////////////////////////start loop for type//////////////
	$q_count=1;
	$old_type='';
	foreach($exam_details as $row){
		$q_ID         = $row->questions_content_ID ;
		$q_types_Name = $row->questions_types_Name ;
		$q_types_ID = $row->questions_types_ID ;
?>

  			<div id="step-<?php echo $q_count?>">
<?php
switch($q_types_ID ){
 case '1':
 ?>
 <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;
	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){			
			$Question = $row->Question ;
			$youtube_script = $row->youtube_script ;
			$Degree = $row->Degree ;
			$attach = $row->Q_attach ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			if($q_one_count!=1){
			?>
            <div class="clearfix"></div>
            <?php }?>
                <div class="clearfix"></div>
<div class="block-st q-st">
		 <input type="hidden" id="txt_q_ID_1_<?php echo $q_one_count?>" name="txt_q_ID_1_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>    
           <div class="sec-title">	
          <h2> <?php echo $q_types_Name ; ?> </h2>
          </div>
           
          <div class="form-group col-lg-12">

  <div class="form-group col-lg-12 padd_right_none">
                <label class="control-label col-lg-1">
				<?php echo lang('question'); ?> 
				</label>
                <label class="control-label col-lg-11 ">
				<?php echo $Question ; ?>dds
                </label>
  </div>                  
                    <div class="clearfix"></div>
       
     
			<?php			
			$ans_one_count=1;
			
			$count_Choices =count($q_answers);
			$start_Choices =1;
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
  		     $Ans_q_ID = $row->questions_content_ID ;
 			 $AnswerID 		  = $row->Answer_ID ;
			 $Answer   		  = $row->Answer ;
			 $Answer_correct  = $row->Answer_correct ;
						 
			if($Ans_q_ID==$q_one_Q_ID){
			?>
          <div id="div_<?php  echo $AnswerID?>" class="check_div_static  check_div_static3  div_<?php  echo $Ans_q_ID?>" > 
                <div class="clearfix"></div>
                <div class="col-lg-1">
                  <div class="checkbox checkbox-success">
                     <input type="checkbox" onchange="chk_one_choose('<?php  echo $Ans_q_ID?>','<?php  echo $AnswerID?>');"   id="slct_Correct_Answer<?php  echo $AnswerID;?>" name="slct_Correct_Answer<?php  echo $Ans_q_ID;?>"    value="0" />
                     <label></label>
                  </div>
                </div>
                <label class="control-label col-lg-7">
                <?php  echo $Answer;?> 
                <input type="hidden" class="form-control" value="<?php  echo $AnswerID;?>"  name="ID_Choices<?php  echo $AnswerID;?>"   id="ID_Choices<?php  echo $AnswerID;?>"  >
                 </label>
                  
                <div class="clearfix"></div>
                </div>    
 		<?php
					
 $start_Choices++;
		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
        <div class="col-lg-6">
         <label class="control-label col-lg-3 padd_right_none" dir="rtl"><?php echo lang('Degree'); ?>: </label>
         <label class="control-label col-lg-3" ><?php echo $Degree ; ?></label>
         </div>
                    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>      
         <div class="col-lg-6">
                <label class="control-label col-lg-3 padd_right_none" > <?php echo lang('attach'); ?> </label>
         <div class="col-lg-9">
                <a class="btn btn-success pull-right" href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a>
        </div>
       </div>
      		<?php }?> 
            <div class="clearfix"></div>
         <div class="col-lg-6">
                     <label class="control-label col-lg-4 padd_right_none"> <?php echo lang('youtube_script'); ?> </label>   
                <div class="col-lg-9"> 
                <?php echo $youtube_script;?>
               </div>
            </div>

         
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>      
           <div class="clearfix"></div>   
      </div>
                <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////
 break;
  case '2':
  ?> 
  <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;

	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){
			$Question = $row->Question ;
			$Degree = $row->Degree ;
			$attach = $row->Q_attach ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			if($q_one_count!=1){
			?>
            <div class="clearfix"></div>
            <?php }?>
            
                <div class="clearfix"></div>
<div class="block-st q-st">
		 <input type="hidden" id="txt_q_ID_2_<?php echo $q_one_count?>" name="txt_q_ID_2_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/><div class="sec-title">	
          <h2>
         <?php echo $q_types_Name ; ?> 
         </h2>
 </div>        
          <div class="form-group col-lg-12">
          
  <div class="form-group col-lg-12 padd_right_none">
                <label class="control-label col-lg-1">
                	<?php echo lang('question'); ?>
                </label>    
                <label class="control-label col-lg-11">
                  <?php echo $Question ; ?>   
                </label>
  </div>                 
                     
                     <div class="clearfix"></div>
                    
               
            <div class="col-lg-7">
			<?php			
			$ans_one_count=1;
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $AnswerID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;  
			if($Ans_q_ID==$q_one_Q_ID){
			?>
            <div id="div_<?php  echo $AnswerID?>" class="check_div_static  check_div_static3  div_<?php  echo $Ans_q_ID?>" > 
                <div class="clearfix"></div>
                <div class="col-lg-1">
                  <div class="checkbox checkbox-success">
                     <input type="checkbox" onchange="chk_choose('<?php  echo $Ans_q_ID?>','<?php  echo $AnswerID?>');"   id="slct_Correct_Answer<?php  echo $AnswerID;?>" name="slct_Correct_Answer<?php  echo $Ans_q_ID;?>"    value="0" />
                     <label></label>
                  </div>
                </div>
                <label class="control-label col-lg-7">
              <?php  echo $Answer;?> 
                <input type="hidden" class="form-control" value="<?php  echo $AnswerID;?>"  name="ID_Choices<?php  echo $AnswerID;?>"   id="ID_Choices<?php  echo $AnswerID;?>"  >
                 </label>
                  
                <div class="clearfix"></div>
                </div>            
		<?php
					

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
       
            </div>  
            <div class="col-lg-6"> 
               <label class="control-label col-lg-3 padd_right_none" dir="rtl" ><?php echo lang('Degree'); ?>:</label> 
		        <label class="control-label col-lg-9" ><?php echo $Degree ; ?></label>
            </div>
            
                    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>       
             <div class="col-lg-6">
                <label class="control-label col-lg-3" > <?php echo lang('attach'); ?></label> 
               <div class="col-lg-9"> 
                 <a class="btn btn-success pull-right" href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a>
               </div>       
			 </div> 
		<?php }?>  
        
             <div class="col-lg-6">
                     <label class="control-label col-lg-4 padd_right_none"> <?php echo lang('youtube_script'); ?> </label>   
                <div class="col-lg-8"> 
                <?php echo $youtube_script;?>
               </div>
            </div>  
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>        
      
                <div class="clearfix"></div>
      </div>  
        <div class="clearfix"></div>
   </div>          
   
      <div class="clearfix"></div>       
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////

 break;  
 case '3':
  ?> 
  <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;

	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){
			$Question = $row->Question ;
			$Degree = $row->Degree ;
			$attach = $row->Q_attach ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			 ?>
            
                <div class="clearfix"></div>
             <div class="block-st q-st">
        <input type="hidden" id="txt_q_ID_3_<?php echo $q_one_count?>" name="txt_q_ID_3_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>           
         <div class="sec-title">	
          <h2><?php echo $q_types_Name ; ?></h2>
          </div>
          <div class="form-group col-lg-12">
  <div class="form-group col-lg-12 padd_right_none">
                <label class="control-label col-lg-1">
                	<?php echo lang('question'); ?>  
				</label>
                <label class="control-label col-lg-11">	
					<?php echo $Question ; ?>
                </label>
        </div>               
                    <div class="clearfix"></div> 
           <div class="form-group col-lg-7">
     
             <div class="col-lg-9">
			<?php			
			$ans_one_count=1;
	///////////////////////////////start loop for Answer//////////////
	
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
 			?>
            
                <?php  if($Answer==lang('right_answer') ){
						 ?>
               
                 <a href="javascript:void(0);" class="btn btn-default  btn-lg ask_btn" onclick="right_answer('<?php echo $Ans_q_ID?>','<?php echo $Answer_ID?>');" id="right_answer<?php echo $Ans_q_ID?>">
                  <?php echo lang("right_answer"); ?>
                 </a>  
                 
   				
				<?php }else{ ?>	
                  <a href="javascript:void(0);" class="btn  btn-default btn-lg ask_btn" onclick="wrong_answer('<?php echo $Ans_q_ID?>','<?php echo $Answer_ID?>');return false;"  id="wrong_answer<?php echo $Ans_q_ID?>">
                  <?php echo lang("wrong_answer"); ?>
               </a>  
                 
                 	<?php }?> 
				<?php if($ans_one_count==1){?><input type="hidden" name="ID_Choices<?php echo $Ans_q_ID?>"	 id="ID_Choices<?php echo $Ans_q_ID?>" value=""	/><?php }?>
              
		<?php
					

		$ans_one_count++;
			}}
	///////////////////////////////end loop for Answer//////////////
		?>   
         </div>  
            </div>  
          <div class="col-lg-6 form-group">       
         <label class="control-label col-lg-3 padd_right_none" dir="rtl" ><?php echo lang('Degree'); ?>: </label>
		 
		 <label class="control-label col-lg-3" > <?php echo $Degree ; ?></label>
         </div>
                    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>       
            <div class="col-lg-6 form-group">       
                <label class="control-label col-lg-3" > <?php echo lang('attach'); ?></label> 
                <div class="col-lg-9">   
                 <a class="btn btn-success pull-right" href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a>
                </div> 
            </div>        
			
		<?php }?>  
        <div class="col-lg-6 form-group">   
                     <label class="control-label col-lg-4 padd_right_none"> <?php echo lang('youtube_script'); ?>  </label>   
                <div class="col-lg-8" > 
                <?php echo $youtube_script;?>
               </div>
            </div> 
      <div class="clearfix"></div>
     
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>      
       </div>               
      <div class="clearfix"></div>
     </div>           
      <div class="clearfix"></div> 
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////
 break;  
 case '4':
  ?> 
  <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;

	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){
			$Question = $row->Question ;
			$Degree = $row->Degree ;
			$attach = $row->Q_attach ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			if($q_one_count!=1){
			?>
              <div class="clearfix"></div>

            <?php }?>
            <div class="clearfix"></div>
            <div class="block-st q-st">
		 <input type="hidden" id="txt_q_ID_4_<?php echo $q_one_count?>" name="txt_q_ID_4_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>        <div class="sec-title">	
          <h2><?php echo $q_types_Name ; ?></h2>
          </div>

         <div class="form-group col-lg-12">    
                	  
			<?php		
			$str = strip_tags($Question);
				$txt_answers_pieces = explode("##", $str);
				$array_count = count($str);
				$index_answer = strrpos($str,'##');
				$count_index_answer =0;
				$num_all_ans = 0;
				$count_Answer =1;
				if($index_answer>=0 ){
					echo '<div class="col-lg-12 text-right"><h4>'.$txt_answers_pieces[$count_index_answer].'</h4></div>';
					$count_index_answer++;
					}
				$count_Str = substr_count($str, '##');	
			$ans_one_count=1;?>
		<div class="form-group col-lg-8">	
			<?php
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
			?>
             <input style="width:auto;" type="text" class="form-control pull-right" id="answer_txt_complete_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="answer_txt_complete_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="" />  
            
 		<?php
			if($count_index_answer<=count($txt_answers_pieces)-1){
                echo '<label class="control-label pull-right" style="padding-right:15px;padding-left:15px;">'.$txt_answers_pieces[$count_index_answer].'</label>';
				}
                $count_index_answer++;
                $count_Answer++;
				$num_all_ans++;		

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>   </div>         
      
        <div class="form-group col-lg-6">
            <label class="control-label col-lg-3 padd_right_none" dir="rtl"><?php echo lang('Degree'); ?>: </label>
	    	<label class="control-label col-lg-3" > <?php echo $Degree ; ?></label>
        </div>
                    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>  
                <div class="form-group col-lg-6">     
                <label  class="control-label col-lg-3"> <?php echo lang('attach'); ?></label>
                <div class="col-lg-9">  
                  <a class="btn btn-success pull-right"  href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a>
                </div>    
			    </div>
		<?php }?>  
        </div>
         <div class="form-group col-lg-6">
                     <label class="control-label col-lg-4"> <?php echo lang('youtube_script'); ?> </label>   
                <div class="col-lg-8"> 
                <?php echo $youtube_script;?>
               </div>
            </div>    
                   <div class="clearfix"></div>
     </div>  
        <div class="clearfix"></div>
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////
 break;  
 case '5':
  ?> 
  <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;

	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){
			$Question = $row->Question ;
			$attach = $row->Q_attach ;
			$Degree = $row->Degree ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			if($q_one_count!=1){
			?>
        <div class="clearfix"></div>
            
            <?php }?>
        <div class="clearfix"></div>
        <div class="block-st q-st">
		 <input type="hidden" id="txt_q_ID_5_<?php echo $q_one_count?>" name="txt_q_ID_5_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>         <div class="sec-title">	
          <h2><?php echo $q_types_Name ; ?></h2>
          </div>

          <div class="form-group col-lg-12">
             <div class="form-group col-lg-12 padd_right_none">
                <label class="control-label col-lg-1">
                	<?php echo lang('question'); ?>  
				</label>
                <label class="control-label col-lg-11">	
					<?php echo $Question ; ?>
                </label>
        </div>               
                    <div class="clearfix"></div>
     	 <div class="form-group col-lg-7">
                             
			<?php			
			$ans_one_count=1;
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
			?>
            <div class="block">
            
           <input type="text"  class="form-control" id="answer_txt_mean_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="answer_txt_mean_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="" />  
      		<input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="<?php echo $Answer_ID?>"/>  
                
            </div>           
		<?php
					

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
        </div>
          <div class="col-lg-6 form-group">       
         <label class="control-label col-lg-3 padd_right_none" dir="rtl" ><?php echo lang('Degree'); ?>: </label>
		 
		 <label class="control-label col-lg-3" > <?php echo $Degree ; ?></label>
         </div>

                    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>       
                    
            <div class="col-lg-6 form-group">       
                <label class="control-label col-lg-3" > <?php echo lang('attach'); ?></label> 
                <div class="col-lg-9">   
                 <a class="btn btn-success pull-right" href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a>
                </div> 
            </div>      
			
		<?php }?>  
        
        <div class="col-lg-6 form-group">   
                     <label class="control-label col-lg-4 padd_right_none"> <?php echo lang('youtube_script'); ?>  </label>   
                <div class="col-lg-8" > 
                <?php echo $youtube_script;?>
               </div>
            </div> 

         
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>          
            </div>               
      <div class="clearfix"></div>
     </div>           
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////
 break;  
 case '6':
  ?> 
  <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;

	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){
			$Question = $row->Question ;
			$Degree = $row->Degree ;
			$attach = $row->Q_attach ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			if($q_one_count!=1){
			?>
                     <div class="clearfix"></div>
            
            <?php }?>
                     <div class="clearfix"></div>
                     <div class="block-st q-st">
		 <input type="hidden" id="txt_q_ID_6_<?php echo $q_one_count?>" name="txt_q_ID_6_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
         <div class="sec-title">	
          <h2><?php echo $q_types_Name ; ?></h2>
          </div>
          <div class="form-group col-lg-12">
  <div class="form-group col-lg-12 padd_right_none">
                <label class="control-label col-lg-1">
                	<?php echo lang('question'); ?>  
				</label>
                <label class="control-label col-lg-11">	
					<?php echo $Question ; ?>
                </label>
        </div>     
                     <div class="clearfix"></div>
                     
          <div class="form-group col-lg-7">
         
			<?php			
			$ans_one_count=1;
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
			?>
            <div class="block">
            
             <input type="file" class="input03" id="answer_txt_upload_<?php echo $q_one_count?>" name="answer_txt_upload_<?php echo $q_one_count?>" />  
      		<input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="<?php echo $Answer_ID?>"/>  
                
            </div>           
		<?php
					

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
        </div>   
         
          <div class="col-lg-6 form-group">       
         <label class="control-label col-lg-3 padd_right_none" dir="rtl" ><?php echo lang('Degree'); ?>: </label>
		 
		 <label class="control-label col-lg-3" > <?php echo $Degree ; ?></label>
         </div>

                    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
					 ?>
					  <div class="col-lg-6 form-group">       
                <label class="control-label col-lg-3" > <?php echo lang('attach'); ?></label> 
                <div class="col-lg-9">   
                 <a class="btn btn-success pull-right" href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a>
                </div> 
            </div>        

		<?php }?>  
                   
        <div class="col-lg-6 form-group">   
                     <label class="control-label col-lg-4 padd_right_none"> <?php echo lang('youtube_script'); ?>  </label>   
                <div class="col-lg-8" > 
                <?php echo $youtube_script;?>
               </div>
            </div> 
<div class="clearfix"></div>
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>  
      <div class="clearfix"></div>
            </div> 
            <div class="clearfix"></div>
            </div>                      
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////
 break;  
 case '7':
 ?>
  <?php
	///////////////////////////////start loop for questions//////////////
	$q_one_count=1;

	foreach($q_details as $row){
		$q_one_t_ID = $row->questions_types_ID ;
		if($q_one_t_ID ==$q_types_ID ){
			$Question = $row->Question ;
			$Degree = $row->Degree ;
			$attach = $row->Q_attach ;
			$q_one_Q_ID = $row->questions_content_ID ;
			$q_one_t_ID = $row->questions_types_ID ;
			$youtube_script = $row->youtube_script ;
			if($q_one_count!=1){
			?>
             <div class="clearfix"></div>
            <?php }?>
		 <input type="hidden" id="txt_q_ID_7_<?php echo $q_one_count?>" name="txt_q_ID_7_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/> 
         <div class="clearfix"></div>
         <div class="block-st q-st">
           <div class="sec-title">	
             <h2><?php echo $q_types_Name ; ?></h2>
           </div>
             <div class="alert alert-danger text-right">حرك مربعات الجانب الايسر امام ما يناسبها من الجانب الايمن</div>

         <div class="clearfix"></div>
        
         <?php /*?>
            <div class="section span4">
                     <label> <?php echo lang('youtube_script'); ?>  :</label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>  
                  
         <?php if($attach!=""&&file_exists("upload/$attach")){?>
          <div class="span4"> 
          <div class="block span12">
                 <label> <?php echo lang('attach'); ?>  :</label> 
                                  <a class="label label-info" href="<?php echo base_url()?>upload/<?php echo $attach;?>"><?php echo lang('Download'); ?></a>
              
			</div> 
		<?php }?><?php */?>
		<?php	
			$ans_one_count=1;
			
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
				$Answer   = explode("%!%",$Answer);
				array_pop ($Answer);
				$Question = explode("%!%",$Question);
				$count_qus = (count($Question)-1);
				$count_ans = (count($Answer)-1);
				shuffle_assoc($Answer);
				array_pop( $Question );
				/*foreach( $Question as $key => $value ) {
					if( $key % 2 != 0 ) {
						unset($Question[$key]);
					}
				}*/
				
			   //shuffle_assoc($Question);
			if($ans_one_count==1){	
								
			?>    
         
            <?php }?>
          <div class="col-lg-3" >
            <h4 class="text-center"> الجانب الايمن </h4>     
        <ul class="sortable connectedSortable " style="width:100%;float:right;margin:0px;" >
        <?php
		$num_qus=1;
        	foreach($Question as $q_row  ){
				if($num_qus<=$count_qus){
				?>
				<li style="width:100%;float:right;"  class="ui-state-default" ><?php echo $q_row?>
       			</li>
				<?php 
			}
		?>
		<?php 
		$num_qus++;}
		?>
        </ul>
        </div>
        <div class="col-lg-3" >
          <h4 class="text-center"> الجانب الايسر</h4> 
        <ul  class="sortable_l connectedSortable" id="sortable<?php echo $q_one_count;?>" style="width:100%;float:right;margin:0px;">
        
        <?php
			$num_ans=1;
			//$Answer             = explode('%!%',$Answer);
        	foreach($Answer as $key =>$ans_row  ){
				if($num_ans<=$count_ans){
				if($num_ans%2!=0){?>
				<li  style="width:100%;float:right;"  class="ui-state-highlight" id="ans_<?php echo $q_one_count;?>_<?php echo $key;?>"><?php echo $ans_row?>
				<?php }else{?>
       			</li>
				<?php }
			}
		?>
		<?php 
		$num_qus++;}
		?>
        </ul>
		</div>
    <input type="hidden" id="all_answer_<?php echo $q_one_count?>" name="all_answer_<?php echo $q_one_count?>" value=""/>  
    <input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>" value="<?php echo $Answer_ID?>"/>  
    
		<?php
			

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>    
              <div class="clearfix"></div>
     </div>        
<?php
		$q_one_count++;
}

 }
  ?>
  </div>
 <div class="clearfix"></div>
 
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count-1?>"/>         
  <?php
 break;
 default:
}//end switch
 ?>		

        </div>            
  <?php
$q_count++;
 }
 ///////////////////////////////end loop for type//////////////
 ?>	  
 <input type="hidden" id="txt_q_count" name="txt_q_count" value="<?php echo $q_count-1;?>"/>
 
<div class="clearfix"></div>
<hr />
<div class="clearfix"></div>
 <div class="col-lg-12 text-left form-group" >
 <input type="button" class="btn btn-success btnSave" value="انهاء" />
 </div>  

<div class="clearfix"></div>
   
 </div>   
<div class="clearfix"></div>
 </div>
 <?php
 }else{?><div class="alert alert-danger"><?php echo lang('Not_exit') ;?></div><?php }?>

<div class="clearfix"></div>
	
   		</div>


   

<script>
function  chk_one_choose(q_id,ans_id){
    chkID = '#slct_Correct_Answer'+ans_id; 
     $(chkID).val('1'); 
     $(chkID).prop('checked',true); 
     $("input[name='slct_Correct_Answer"+q_id+"']").not(chkID).val('0');  
     $("input[name='slct_Correct_Answer"+q_id+"']").not(chkID).prop('checked',false);  
	  $('.div_'+q_id).removeClass("check_div"); 
	   $('#div_'+ans_id).addClass("check_div");
	 }
function  chk_choose(q_id,ans_id){
    chkID = '#slct_Correct_Answer'+ans_id; 
     $(chkID).val('1'); 
     $(chkID).prop('checked',true); 
	   $('#div_'+ans_id).addClass("check_div"); 
	 } 
function wrong_answer(q_id,ans_id){
	if($("#wrong_answer"+q_id).hasClass('btn-danger')){
			 $("#wrong_answer"+q_id).removeClass('btn-danger');
			 $("#wrong_answer"+q_id).addClass('btn-default');
			 $("#right_answer"+q_id).removeClass('btn-default');
			 $("#right_answer"+q_id).addClass('btn-success');   
			 }
		 else if(!$("#wrong_answer"+q_id).hasClass('btn-danger')){
			 $("#wrong_answer"+q_id).removeClass('btn-default');
			 $("#wrong_answer"+q_id).addClass('btn-danger');
			 $("#right_answer"+q_id).removeClass('btn-success'); 
			 $("#right_answer"+q_id).addClass('btn-default');
 			 }
 			 $("#ID_Choices"+q_id).val(ans_id); 
			 return false;
	 }
  		 
function right_answer(q_id,ans_id){
	 if($("#right_answer"+q_id).hasClass('btn-success')){
			 $("#right_answer"+q_id).removeClass('btn-success');
			 $("#right_aswer"+q_id).addClass('btn-default'); 
			 $("#wrong_answer"+q_id).removeClass('btn-default');
			 $("#wrong_answer"+q_id).addClass('btn-danger'); 
			 }
		  else if(!$("#right_answer"+q_id).hasClass('btn-success')){
			 $("#right_answer"+q_id).removeClass('btn-default');
			 $("#right_answer"+q_id).addClass('btn-success');  
			 $("#wrong_answer"+q_id).removeClass('btn-danger');
			 $("#wrong_answer"+q_id).addClass('btn-default'); 
			 } 
			 $("#ID_Choices"+q_id).val(ans_id); 
			 return false;
	 }
 
$(document).ready(function(e) {
	 $(".btnSave").click(function(e) 
	{ 
	alert('klk');
	});
});
	 </script>