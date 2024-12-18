          
<script type="text/javascript" >
$( document ).ready(function() {
	    $("#add_Choice").click(function(e) {
			$('#loadingDiv').show();
			var num_Choices = parseInt($("#num_Choices").val());
			    num_Choices = num_Choices+1 ; 
		
  		$('#Choices_Div').append ("<div  class='check_div_static check_div_static3'  id='div_"+num_Choices+"'><div class='col-lg-1'>  <div class='checkbox checkbox-success'><input type='checkbox'  id='slct_Correct_Answer"+num_Choices+"' name='slct_Correct_Answer'  onchange='chk_choose("+num_Choices+");'   value='0'  /><label></label></div></div><div class='col-lg-7'>  <input type='text' class='form-control' name='txt_Choices"+num_Choices+"'  id='txt_Choices"+num_Choices+"'  ></div><div class='col-lg-1'><input type='button' value='x' class='btn btn-danger' onclick='delete_div("+num_Choices+");' /></div><div class='clearfix'></div></div></div></div>" );
		$("#num_Choices").val(num_Choices);
		$('#loadingDiv').hide();
 });
 
	$('input:checkbox').change(function(){
    if($(this).is(":checked")) { 
        $('#div_'+this.value).addClass("check_div");
    } else { 
        $('#div_'+this.value).removeClass("check_div");
    }
});
 	 $("#BtnAddAns").click(function(e) { 
			 
			 var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
  			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
 			 var txt_answer_ID = $("#txt_answer_ID").val();
			 var txt_question_ID = $("#txt_question_ID").val();
			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
 			 var num_Choices = $("#num_Choices").val();
			  var txt_Choices = new Array();
			 var slct_Correct_Answer = new Array();
			 count=0;
			 var varTrue =0;
			 var oneTrue =0;
			 while(num_Choices>=1){ 
				 if($('#txt_Choices'+num_Choices ).val() != ""&&$('#txt_Choices'+num_Choices ).length){  
				   txt_Choices[count]         = $('#txt_Choices'+num_Choices).val();
				   slct_Correct_Answer[count] = $('#slct_Correct_Answer'+num_Choices ).val();
				   if(slct_Correct_Answer[count]==1){oneTrue=1;} 
				   varTrue++;
				 }
				  num_Choices--;
				  count++;
				 }
 			 var num_Choices = $("#num_Choices").val(); 
		 if(txt_question!=""&&txt_Degree>0&&varTrue>=2&&oneTrue==1&&txt_question_ID>0){	
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/update_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach , num_Choices : num_Choices , txt_Choices : txt_Choices , slct_Correct_Answer : slct_Correct_Answer, txt_question_ID : txt_question_ID  ,txt_Tquestion_ID:txt_Tquestion_ID} ,
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
							   }); 	 }
			  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); }
			  else{$( "#error_txt_question" ).html( "" ); }
			  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; }
			  if(varTrue>=2){$( ".error_var_true" ).html( "" ); } else{$( ".error_var_true" ).html( "يجب ادخال قيمتين على الاقل فى الاختيارات " ); }
			  if(oneTrue!=1){$( ".error_one_true" ).html( "يجب تحديد اجابه صحيحه" ); } else{$( ".error_one_true" ).html( "" ); } 
	});
 
});
function chk_choose (id){
 	  chkID = '#slct_Correct_Answer'+id;
     if ($(chkID).prop('checked')) {
 	  $('#div_'+id).addClass("check_div");
    $(chkID).val('1'); 
	 }else{
	  $('#div_'+id).removeClass("check_div"); 
		 $(chkID).val('0'); 
		 }
	 }
function checkChange() {
	var num_checkbox = document.getElementById("num_checkbox").value;
	}
	
function delete_div(div){
	div = '#div_'+div;
	if(div!='#div_1'&&div!='#div_2'){
	$(div).remove();
	 }else{alert('لا يمكنك مسح اول عنصرين');}
	}
</script>
<!-- /TinyMCE -->
<style>

.controls iframe {
	width:100% !important;
	height:100% !important;
	}
</style>
    <div class="clearfix"></div>
 
 <div class="ask-st">
 
        <div id="collapseDVR3" class="panel-collapse collapse in">

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
				$count_Choices =count($item_question);
				$start_Choices =1;
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
            <div class="clearfix"></div>          
     
				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $questions_types_ID;?>"/>

              <div id="question_div" ></div>
              
              
 <div class="clearfix"></div>                         
               <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Choices'); ?></label>
<div class="clearfix"></div>                
                <?php foreach($item_question as $Key=>$row){
						 $AnswerID 		  = $row->answers_ID ;
						 $Answer   		  = $row->Answer ;
						 $Answer_correct  = $row->Answer_correct ;?>
                <div id="div_<?php  echo $start_Choices?>" class="check_div_static  check_div_static3 <?php if($Answer_correct==1){?> check_div<?php }?>" > 
                <div class="clearfix"></div>
                <div class="col-lg-1">
                  <div class="checkbox checkbox-success">
                     <input type="checkbox" onchange="chk_choose('<?php  echo $start_Choices?>');"   id="slct_Correct_Answer<?php  echo $start_Choices;?>" name="slct_Correct_Answer"   <?php if($Answer_correct==1){?> checked="checked" value="1" <?php }else{?> value="0" <?php }?>/>
                     <label></label>
                  </div>
                </div>
                <div class=" col-lg-7">
                <input type="text" class="form-control" value="<?php  echo $Answer;?>"  name="txt_Choices<?php  echo $start_Choices;?>"   id="txt_Choices<?php  echo $start_Choices;?>"  >
                 </div>
                 
                <div class="col-lg-1">
                  <input type="button" class="btn btn-danger" value="x" onclick="delete_div('<?php  echo $start_Choices?>');" />
                </div>
                <div class="clearfix"></div>
                </div>
                <?php  $start_Choices++;} ?>
                  
<div id="Choices_Div"></div> 
            </div>
                <div class="form-group col-lg-6">
     <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save fa-2"></i> <?php echo lang('am_save');?></button>
    </div>
          
           <div class="clearfix"></div>    
           <div class="form-group col-lg-4">
           <a class="btn btn-success pull-left" herf="#" name="add_Choice" id="add_Choice" ><i class="fa fa-plus"></i> <?php echo lang('add_Choice'); ?></a>           
           </div>    
           
                <div class="col-lg-9">
                <div class="error errorText error_var_true" ></div>
                <div class="error errorText error_one_true" ></div>
                
                </div>
           <div class="clearfix"></div>
       
               <input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>

            <input type="hidden" name="num_Choices" id="num_Choices" value="<?php  echo $count_Choices;?>" />
 			<input type="hidden" name="num_checkbox" id="num_checkbox" value="1" />
                <?php
               
            }
        ?> 
        

       </div>        
 <div class="clearfix"></div> 
   </div>   
 <div class="clearfix"></div> 