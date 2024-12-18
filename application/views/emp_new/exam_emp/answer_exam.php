<link href="<?php echo base_url()?>css/smart_wizard.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.smartWizard.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    	// Smart Wizard 	
  		$('#wizard').smartWizard();
      
      function onFinishCallback(){
        $('#wizard').smartWizard('showMessage','Finish Clicked');
        //alert('Finish Clicked');
      }     

		});
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style>
.sortable, .sortable_l { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: right; margin-right: 10px; }
.sortable li, .sortable_l li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
.section iframe {width:100% !important;height:100% !important;}
.ui-state-default {
	background:#2980b9;
	color:#fff;
	}

.ui-state-highlight {
	background:#c0392b;
	color:#fff;
	}
.tit-ui-state-default {
	background:#2C3E50 ;
	color:#fff;
	text-align:center;
	margin: 0px 0px 5px 0px;
    padding: 5px;
	}

.tit-ui-state-highlight {
	background:#2C3E50 ;
	color:#fff;
	text-align:center;
	margin: 0px 0px 5px 0px;
    padding: 5px;
	}	
	.content p {
    font-size: 1.4em;
}
</style>

<script>
$(document).ready(function(e) {
    $( "form" ).submit(function( event ){
		var q_count =$("#txt_q_count").val();
		var count_answer = $("#txt_q_one_count_"+q_count).val();
		for (index = 1; index <= count_answer; ++index) {
		idsInOrder = $("#sortable"+index).sortable("toArray");
		$("#all_answer_"+index).val(idsInOrder);
		};
		return true ; 
    });
});

$(function() {
	var q_count =$("#txt_q_count").val();
	var num_q =$("#txt_q_one_count_"+q_count).val();
	for (index = 1; index <= num_q; ++index) {
			$("#sortable"+index ).sortable({connectWith: "#sortable"+index }).disableSelection();
		};
});
</script>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/answers.css"  />
 
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.timer.js"></script>
 
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
  <form action="<?php echo site_url('emp/answer_exam_job/correction_exam'); ?>" name="form" method="post" enctype="multipart/form-data"  >
 
 <div class="block-st">

<?php
         $testdate = '';
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
     $testdate = $row->date_to;
 	$test_ID            = $row->test_ID ;
 	$subjectID           = $row->subjectID ;
	$test_Name          = $row->test_Name ;
 	$test_Description   = $row->test_Description ;
	$time_count         = $row->time_count ;
 }
 ?>
  <div class="sec-title">
 <h2><?php echo $test_Name?></h2>
 </div>
 <div class="clearfix"></div>

 		<div class="form-group col-lg-12">
             <label class="col-lg-3 label-control"> <?php echo lang('Description') ;?> </label>  
             <label class="col-lg-9 label-control"><?php echo $test_Description?></label>
         </div>
 <?php if($time_count!=""){?>
 
        <div class="clock_st_co" style="display:none">
             <label class="col-lg-4"> <?php echo lang('Time') ;?></label>  
              <input type="text" id="counter" name="counter" class='count smallWidth clock_st col-lg-4' readonly/>  
             <input type="hidden"  id="txt_time_count" name="txt_time_count"  value="<?php echo $time_count*60?>" >
             <label class="col-lg-4"> <?php echo lang('second') ;?></label>
             </div>
             <div class="error"><?php echo form_error('txt_time') ?></div>
 <?php }?>
 <input type="hidden" id="txt_time_count" name="txt_time_count" value="<?php echo $time_count?>"/>
 <input type="hidden" id="txt_test_ID" name="txt_test_ID" value="<?php echo $test_ID?>"/>
   		<div id="wizard" class="swMain">
  			<ul>
          <?php
	$q_count=1;
	foreach($exam_details as $row){
		$q_types_Name = $row->questions_types_Name ;
		$q_types_ID = $row->questions_types_ID ;
?>  
  				<li><a href="#step-<?php echo $q_count?>">
                   <span class="stepDesc"><?php echo $q_types_Name ;?> 
                   </span>
                    </a>
                 </li>
            <input type="hidden" id="txt_t_q_ID_<?php echo $q_count?>" name="txt_t_q_ID_<?php echo $q_count?>" value="<?php echo $q_types_ID?>"/>   
        <?php
$q_count++;
 }
 ?>   
    
  			</ul>
			<?php
///////////////////////////////start loop for type//////////////
	$q_count=1;
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
            <div class="clearfix"></div><hr /><div class="clearfix"></div>
            <?php }?>
		 <input type="hidden" id="txt_q_ID_1_<?php echo $q_one_count?>" name="txt_q_ID_1_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
          <div class="form-group col-lg-12">
                	<h4><?php echo lang('question'); ?> <span> <?php echo $Question ; ?></span></h4>
                                        <div class="clearfix"></div>
                    <hr />
         <div class="clearfix"></div>
            <div class="col-lg-10" >
            <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			       if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>      <label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a target="_blank" href="<?php echo $ImagePath; ?>"><img  style="width:100%" src="<?php echo $ImagePath; ?>"/></a></label> 
                    
		
		<?php }?> 
		
		</div>

   
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
          <div class="col-lg-10" >
           
            <div class="radio radio-success" >
          
            <input type="radio" value="<?php echo $Answer_ID?>" name="radio_<?php echo $q_one_count?>" id="radio_<?php echo $q_one_count?>_<?php echo $ans_one_count?>"   />  
            <label for="radio_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" ><?php  echo $Answer  ;?></label> 
                     
      		<input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="<?php echo $Answer_ID?>"/>  
                
            </div> 
           
           </div> 
          
          
		<?php
					

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
        </div>           
          <div class="form-group col-lg-12">
         <label class="control-label col-lg-3" ><?php echo lang('Degree'); ?>: <?php echo $Degree ; ?></label>
               
                     <label class="control-label col-lg-9" hidden> <?php echo lang('youtube_script'); ?> </label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>

         
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>    
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
            <div class="clearfix"></div><hr /><div class="clearfix"></div>
            <?php }?>
		 <input type="hidden" id="txt_q_ID_2_<?php echo $q_one_count?>" name="txt_q_ID_2_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
          <div class="form-group col-lg-12">
                	 <h4><?php echo lang('question'); ?> <span> <?php echo $Question ; ?></span></h4>
                                         <div class="clearfix"></div>
                    <hr />
         <div class="clearfix"></div>
          <div class="col-lg-10" >
                  <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			       if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>      <label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a target="_blank" href="<?php echo $ImagePath; ?>"><img  style="width:100%" src="<?php echo $ImagePath; ?>"/></a></label> 
                    
		
		<?php }?> 

               </div>
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
            <div class="col-lg-10">
             <div class="checkbox checkbox-success">
            <input type="checkbox" class="chkbox"  value="<?php echo $Answer_ID?>" name="check_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" id="check_<?php echo $q_one_count?>_<?php echo $ans_one_count?>"   />
            <label for="check_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" ><?php  echo $Answer  ;?></label>
      		<input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="<?php echo $Answer_ID?>"/>  
             </div>     
            </div> 
            
		<?php
					

		$ans_one_count++;
		
				}
		}
	///////////////////////////////end loop for Answer//////////////
		?>
        </div>
          <div class="form-group col-lg-12">
         <label class="control-label col-lg-3" ><?php echo lang('Degree'); ?>: <?php echo $Degree ; ?></label>
                     <label class="control-label col-lg-3" hidden> <?php echo lang('youtube_script'); ?> </label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>  
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>                     
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
			if($q_one_count!=1){
			?>
            <div class="clearfix"></div><hr /><div class="clearfix"></div>
            <?php }?>
		 <input type="hidden" id="txt_q_ID_3_<?php echo $q_one_count?>" name="txt_q_ID_3_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
          <div class="form-group col-lg-12">
                	<h4><?php echo lang('question'); ?> <span> <?php echo $Question ; ?> </span></h4>
                    
                    <div class="clearfix"></div>
                    <hr />
         <div class="clearfix"></div>
          <div class="col-lg-10">
          <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			       if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>       <label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a target="_blank" href="<?php echo $ImagePath; ?>"><img  style="width:100%" src="<?php echo $ImagePath; ?>"/></a></label> 
                    
			
		<?php }?>  
   </div>
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
           <div class="col-lg-10">
             <div class="radio radio-success">
            
            <input type="radio" name="correct_<?php echo $q_one_count?>" value="<?php echo $Answer_ID?>" id="correct_<?php echo $q_one_count?>_<?php echo $ans_one_count?>"   />
            <label for="correct_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" ><?php  echo $Answer  ;?></label>
      		<input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="<?php echo $Answer_ID?>"/>  
              </div>    
            </div> 
            
		<?php
					

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
        </div>            
        <div class="form-group col-lg-12">
         <label class="control-label col-lg-3" ><?php echo lang('Degree'); ?>: <?php echo $Degree ; ?></label>
                   
                     <label class="control-label col-lg-9"  hidden> <?php echo lang('youtube_script'); ?>  </label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>   
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>                     
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
            <?php }?>
		 <input type="hidden" id="txt_q_ID_4_<?php echo $q_one_count?>" name="txt_q_ID_4_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
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
					echo '<h4>'.$txt_answers_pieces[$count_index_answer].'</h4>';
					$count_index_answer++;
					}
				$count_Str = substr_count($str, '##');	
			$ans_one_count=1;?>
			<div class="col-lg-10" >
			    <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			       if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>       <label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a target="_blank" href="<?php echo $ImagePath; ?>"><img  style="width:100%" src="<?php echo $ImagePath; ?>"/></a></label> 
                    
			
		<?php }?>  
		</div>
		
		<div class="col-lg-10" >
			<?php
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
			?>
             <input type="text" class="form-control" id="answer_txt_complete_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="answer_txt_complete_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="" />  
		<?php
			if($count_index_answer<=count($txt_answers_pieces)-1){
                echo '<label style="width:auto" >'.$txt_answers_pieces[$count_index_answer].'</label>';
				}
                $count_index_answer++;
                $count_Answer++;
				$num_all_ans++;		

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/> 
      </div>         
            <div class="form-group col-lg-12">
         <label class="control-label col-lg-3" ><?php echo lang('Degree'); ?>: <?php echo $Degree ; ?></label>
                
                     <label class="control-label col-lg-9" hidden> <?php echo lang('youtube_script'); ?> </label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>        
     </div>             
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
            <?php }?>
		 <input type="hidden" id="txt_q_ID_5_<?php echo $q_one_count?>" name="txt_q_ID_5_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
          <div class="form-group col-lg-12">
                	 <h4><?php echo lang('question'); ?> <span><?php echo $Question ; ?></span></h4>
                     
                                         <div class="clearfix"></div>
                    <hr />
         <div class="clearfix"></div>
         <div class="col-lg-10" >
                        <?php 
				 $ImagePath =base_url().'upload/'.$attach;
  if(file_exists('./upload/'.$attach)&&$attach!=""){?> <label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a target="_blank" href="<?php echo $ImagePath; ?>"><img  style="width:100%" src="<?php echo $ImagePath; ?>"/></a></label> 
                    
			
		<?php }?>  
		</div>
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
            <div class="col-lg-10" >
            
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
        <div class="form-group col-lg-12">
         <label class="control-label col-lg-3" ><?php echo lang('Degree'); ?>: <?php echo $Degree ; ?></label>
                  
                     <label class="control-label col-lg-9"hidden> <?php echo lang('youtube_script'); ?> </label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>                     
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
            <?php }?>
		 <input type="hidden" id="txt_q_ID_6_<?php echo $q_one_count?>" name="txt_q_ID_6_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
          <div class="form-group col-lg-12">
                	<h4> <?php echo lang('question'); ?> <span> <?php echo $Question ; ?></span></h4>
                     
                                         <div class="clearfix"></div>
                    <hr />
         <div class="clearfix"></div>
         <div class="col-lg-10" >
                      <?php 
				 $ImagePath =base_url().'upload/'.$attach;
			     if(file_exists('./upload/'.$attach)&&$attach!=""){
				?>    <!--   <label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a class="btn btn-success pull-left" href="<?php echo $ImagePath; ?>"><?php echo lang('Download'); ?></a></label> -->
				<label class="control-label col-lg-6" > <?php echo lang('attach'); ?>  <a target="_blank" href="<?php echo $ImagePath; ?>"><img  style="width:100%" src="<?php echo $ImagePath; ?>"/></a></label> 
                    
			
		<?php }?>  
         </div>
        
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
           <div class="col-lg-10" >
            
             <input type="file" class="input03" id="answer_txt_upload_<?php echo $q_one_count?>" name="answer_txt_upload_<?php echo $q_one_count?>" />  
      		<input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>_<?php echo $ans_one_count?>" value="<?php echo $Answer_ID?>"/>  
                
            </div> 
            <br><br>
		<?php
					

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>
        </div>            
        <div class="form-group col-lg-12">
         <label class="control-label col-lg-3" ><?php echo lang('Degree'); ?>: <?php echo $Degree ; ?></label>
                   
                     <label class="control-label col-lg-9" hidden> <?php echo lang('youtube_script'); ?>  </label>   
                <div> 
                <?php echo $youtube_script;?>
               </div>
            </div>    
      <input type="hidden" id="txt_q_one_count_<?php echo $q_count?>" name="txt_q_one_count_<?php echo $q_count?>" value="<?php echo $q_one_count?>"/>                     
<?php
		$q_one_count++;
}

 }
 	///////////////////////////////end loop for questions//////////////
 break;  
 case '7':
 ?>
 <div class="alert alert-info"><p>حرك مربعات الجانب الايسر امام ما يناسبها فى مربعات الجانب الايمن </p></div>
 <div class="clearfix"></div>
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
            <?php }?>
		 <input type="hidden" id="txt_q_ID_7_<?php echo $q_one_count?>" name="txt_q_ID_7_<?php echo $q_one_count?>" value="<?php echo $q_one_Q_ID?>"/>
        
       
		<?php	
			$ans_one_count=1;
			
	///////////////////////////////start loop for Answer//////////////
			foreach($q_answers as $row){
		    $Answer   = $row->Answer ;
		    $Answer_ID   = $row->Answer_ID ;
		    $Ans_q_ID = $row->questions_content_ID ;
		    $Ans_correct = $row->Answer_correct ;
			if($Ans_q_ID==$q_one_Q_ID){
				$Answer   =  substr($Answer, 3);
				$Question   =  substr($Question, 3);  
 				$Answer   = explode("%!%",$Answer); 
				$Question = explode("%!%",$Question);
				/*
				$count_qus = (count($Question)-1);
				array_pop ($Answer);$count_ans = (count($Answer)-1);
				shuffle_assoc($Answer);
				array_pop( $Question );*/
				/*foreach( $Question as $key => $value ) {
					if( $key % 2 != 0 ) {
						unset($Question[$key]);
					}
				}*/
				
			   //shuffle_assoc($Question);
			$count_qus = (count($Question));
  				$array_rand =array();
  				$array_rand_exist =array();
				while($count_qus>0){
					$count_qus--;
					$array_rand[$count_qus]=$count_qus;print_r('<br/>'); 
					}
								
			?>     
     <div class="col-lg-3"> 
        <div class="tit-ui-state-default">
        <h4>الجانب الايمن  </h4>
       </div>   
        <ul style="width:100%;padding:0px;margin:0px;" class="sortable connectedSortable " >
     
        
        <?php
		$num_qus=1;
        	foreach($Question as $key=>$q_row  ){
				$result = array_diff($array_rand, $array_rand_exist);

				$count_q_rand = array_rand($result);
				$array_rand_exist[$key]=$count_q_rand;
 				?>
				<li  style="width:100%;margin:5px 0px 5px 0px;" class="ui-state-default" ><?php echo $Question[$array_rand_exist[$key]]?>
       			</li>
				<?php 
 		?>
		<?php 
		$num_qus++;}
		?>
        </ul>  
      </div>   
      
     <div class="col-lg-3"> 
      <div class="tit-ui-state-highlight">
        <h4>الجانب الايسر   </h4>
      </div>  
        <ul style="width:100%;padding:0px;margin:0px;" class="sortable_l connectedSortable" id="sortable<?php echo $q_one_count;?>" >
      
        <?php
			$num_ans=1;
			//$Answer             = explode('%!%',$Answer);
        	foreach($Answer as $key =>$ans_row  ){
 			 ?>
				<li  style="width:100%;margin:5px 0px 5px 0px; "  class="ui-state-highlight" id="ans_<?php echo $q_one_count;?>_<?php echo $key;?>"><?php echo $ans_row?>
				<?php ?>
       			</li>
				<?php  
 		?>
		<?php 
		$num_qus++;}
		?>
        </ul>
	</div>	
	
<div class="clearfix"></div>
<hr>
<div class="clearfix"></div>
    <input type="hidden" id="all_answer_<?php echo $q_one_count?>" name="all_answer_<?php echo $q_one_count?>" value=""/>  
    <input type="hidden" id="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>" name="txt_answer_ID_<?php echo $q_count?>_<?php echo $q_one_count?>" value="<?php echo $Answer_ID?>"/>  
    
		<?php
			

		$ans_one_count++;
			}
				}
	///////////////////////////////end loop for Answer//////////////
		?>            
<?php
		$q_one_count++;
}

 }
  ?>
  </div>
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
</div>
 <?php
 }else{?><div class="alert alert-danger"><?php echo lang('Not_exit') ;?></div><?php }?>
<div class="clearfix"></div>
</form> 	


<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>

   
<script> 
</script>
