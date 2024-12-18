 

<script type="text/javascript" >
$( document ).ready(function() {
 $('#slct_Correct_Answer1').prop('checked', true);
 $('#slct_Correct_Answer1').val('1');
    $("#BtnAddAns").click(function(e) { 
	         
	   var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
 			 var num_Choices = $("#num_Choices").val();
 			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
			 var txt_Choices = new Array();
			 var slct_Correct_Answer = new Array();
			  var txt_exam_ID= $("#txt_exam_ID").val();
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
			 
		 if(txt_question!=""&&txt_Degree>0&&varTrue>=2&&oneTrue==1){	  
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach , num_Choices : num_Choices , txt_Choices : txt_Choices , slct_Correct_Answer : slct_Correct_Answer, txt_Tquestion_ID : txt_Tquestion_ID , txt_exam_ID:txt_exam_ID} ,
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
			  if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); }
			  else{$( "#error_txt_question" ).html( "" ); }
			  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; }
			  if(varTrue>=2){$( ".error_var_true" ).html( "" ); } else{$( ".error_var_true" ).html( "يجب ادخال قيمتين على الاقل فى الاختيارات " ); }
			  if(oneTrue!=1){$( ".error_one_true" ).html( "يجب تحديد اجابه صحيحه" ); }
			  else{$( ".error_one_true" ).html( "" ); }

			  
	});
    $("#add_Choice").click(function(e) { 
	$('#loadingDiv').show(); 
	var num_Choices = parseInt($("#num_Choices").val())+1;  
  	$('#Choices_Div').append ("<div  class='check_div_static check_div_static3'  id='div_"+num_Choices+"'><div class='clearfix'></div><div class='col-lg-1'>  <div class='checkbox checkbox-success'><input type='checkbox' class='checkbox_class' value='0' onchange='chk("+num_Choices+");'    id='slct_Correct_Answer"+num_Choices+"' name='slct_Correct_Answer'  value='"+num_Choices+"' /><label></label></div></div><div class='col-lg-7 '>  <input type='text' class='form-control' name='txt_Choices"+num_Choices+"'  id='txt_Choices"+num_Choices+"'  ></div><div class='col-lg-1'><input type='button' value='x' class='btn btn-danger' onclick='delete_div("+num_Choices+");' /></div><div class='clearfix'></div></div></div></div>" );
	 
	 $("#num_Choices").val(num_Choices); 	
 
	$('#loadingDiv').hide();
	
    }); 
	 
});

  
function chk  (id){
 	  chkID = '#slct_Correct_Answer'+id; 
  		$("input:checkbox").not(chkID).attr('checked', false);
  		$("input:checkbox").not(chkID).val('0');
  	  $('.check_div_static').removeClass("check_div");
     if ($(chkID).prop('checked')) {
 	  $('#div_'+id).addClass("check_div");
    $(chkID).val('1'); 
	 }else{
	  $('#div_'+id).removeClass("check_div"); 
		 $(chkID).val('0'); 
		 }
	 }
function delete_div(div){
	div = '#div_'+div;
	if(div!='#div_1'&&div!='#div_2'){
	$(div).remove();
	 }else{alert('لا يمكنك مسح اول عنصرين');}
	}
</script>
  
          
        <?php
        if(isset($name_question)){
            foreach($name_question as $row){
                $question_ID   = $row->ID;
                $question_Name = $row->Name;
				$count_Choices =2;
				$start_Choices =1;
                ?>
             
<div class="clearfix"></div>
				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $question_ID;?>"/>
              <div id="question_div" ></div>

        
<div class="ask-st">

            <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Choices'); ?></label>
<div class="clearfix"></div>                
                <?php while($count_Choices>=$start_Choices){?>
                <div id="div_<?php  echo $start_Choices?>" class="check_div_static check_div_static3  <?php if($start_Choices==1){?> check_div<?php }?> " > 
                <div class="clearfix"></div>
                <div class="col-lg-1">
                  <div class="checkbox checkbox-success">
                     <input type="checkbox" value="0"  onchange="chk('<?php  echo $start_Choices?>');"  id="slct_Correct_Answer<?php  echo $start_Choices;?>" name="slct_Correct_Answer"    />
                     <label></label>
                  </div>
                </div>
                <div class="col-lg-7">
                <input type="text" class="form-control"  class='checkbox_class'  name="txt_Choices<?php  echo $start_Choices;?>"   id="txt_Choices<?php  echo $start_Choices;?>"  >
                 </div>
                 
                <div class="col-lg-1">
                  <input type="button" class="btn btn-danger" value="x" onclick="delete_div('<?php  echo $start_Choices?>');" />
                </div>
                <div class="clearfix"></div>
                </div>
                <?php $start_Choices++;} ?>
                  
                <div class="col-lg-9">
                <div class="error errorText error_var_true" ></div>
                <div class="error errorText error_one_true" ></div>
                
                </div>
<div id="Choices_Div"></div> 
            </div>

   
    <div class="form-group col-lg-6">
     <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save fa-2"></i> <?php echo lang('am_save');?></button>
    </div>
          
           <div class="clearfix"></div>    
           <div class="form-group col-lg-4">
           <a class="btn btn-success pull-left" herf="#" name="add_Choice" id="add_Choice" ><i class="fa fa-plus"></i> <?php echo lang('add_Choice'); ?></a>           
           </div>    
           <div class="clearfix"></div>        
                
              


            <input type="hidden" name="num_Choices" id="num_Choices" value="<?php  echo $count_Choices;?>" />
  </div>             
 <?php /*?><div class="form-group col-lg-6">
<label class="control-labe col-lg-3" for="inputEmail"> <div class="error pull-left">*</div> <?php echo lang('Correct_Answer'); ?></label>
 
</div><?php */?>   
      <div class="clearfix"></div>     

                <?php
                }
            }
        ?><input type="hidden" name="txt_exam_ID" id="txt_exam_ID" value="<?php echo $exam_ID;?>"/>
        
     
      <div class="clearfix"></div>  

 