 
         <?php
		 
        if(isset($item_question)){
            foreach($item_question as $row){
                $questions_content_ID      = $row->questions_content_ID;
                $question_Name      = $row->Name;
				$Question           = explode('%!%',$row->Question);
				$Answer             = explode('%!%',$row->Answer);
				$Degree             = $row->Degree;
				$attach             = $row->Q_attach;
				$questions_types_ID = $row->questions_types_ID;
				$questions_types  = $row->Name;
				$answers_ID      =  $row->answers_ID;
				$youtube_script = $row->youtube_script;
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
 	 											 $("#emp_add_question").hide() ;
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

<script type="text/javascript">
function create_row(){
	   $('#num_del').val( parseInt($('#num_del').val())+1);
	   if($("#txt_Degree_del").val()>0){
	   total = parseInt( $("#txt_Degree_del").val())/parseInt($('#num_del').val()); 
	   $("#total_Degree").html(total);
	  }
  	   $('#table_del > tbody:last').append('<tr><td>'+$('#num_del').val()+' </td> <td id="right_'+$('#num_del').val()+'"><textarea class="hidden" id="txt_right_'+$('#num_del').val()+'"> </textarea><input type="button" data-toggle="modal" data-target="#smallModal"  class="btn btn-danger" onclick="create_right('+$('#num_del').val()+');" value="اضافة عنصر فى الجانب الايمين" /> </td> <td id="left_'+$('#num_del').val()+'"><textarea class="hidden" id="txt_left_'+$('#num_del').val()+'"> </textarea><input type="button"  class="btn btn-danger" data-toggle="modal" data-target="#smallModal" onclick="create_left('+$('#num_del').val()+');" value="اضافة عنصر فى الجانب الايسر" /> </td></tr>'); 
	   
	}
function create_right(count){
  	   $('#del_id').val(count);
  	   $('#del_type').val(1);  
 	   tinyMCE.get('txt_del').setContent(''); 
	}
function create_left(count){
  	   $('#del_id').val(count);
  	   $('#del_type').val(2); 
 	   tinyMCE.get('txt_del').setContent(''); 
	}
function edit_right(count){ 
  	   $('#del_id').val(count);
  	   $('#del_type').val(1);  
  	   $('#txt_right_'+del_id).val(); 
 	   tinyMCE.get('txt_del').setContent($('#txt_left_'+del_id).val()); 
	}
function edit_left(count){
  	   $('#del_id').val(count);
  	   $('#del_type').val(2); 
  	   $('#txt_right_'+del_id).val();
 	   tinyMCE.get('txt_del').setContent($('#txt_left_'+del_id).val());

	}
	
	
$(document).ready(function() {
    $("#BtnAddAns").click(function(e) { 
			
 			 var txt_Degree = $("#txt_Degree_del").val();
			 var num_del = $("#num_del").val(); 
 			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
			 var degree_difficulty =1;
 			 var txt_attach = '';
			 var txt_answer  ='';
			 var txt_question ='';
  			 while(num_del>=1){ 
 				   txt_question+= '%!%'+$('#txt_right_'+num_del).val();
				   txt_answer += '%!%'+$('#txt_left_'+num_del ).val();
				    
				  num_del--;
 				 }  
 			 var num_del = $("#num_del").val(); 
 			 var txt_question_ID = $("#txt_question_ID").val();
 			  
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach  , txt_Tquestion_ID : txt_Tquestion_ID,txt_question_ID:txt_question_ID,txt_answer:txt_answer} ,
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
 	});
	
	
	$("#txt_Degree_del").keyup(function(e) { 
	  if($("#txt_Degree_del").val()>0){
	   total = parseInt( $("#txt_Degree_del").val())/parseInt($('#num_del').val()); 
	   $("#total_Degree").html(total);
	  }else{$("#txt_Degree_del").val('1');alert('يجب ان يكون الدرجه اكبر من صفر');}
	});
	$("#btnAdddel").click(function(e) { 
				var del_type  = $("#del_type").val();
				var del_id    = $("#del_id").val();
				var txt_del = tinyMCE.get('txt_del').getContent(); 
				if(del_type==1){
				$('#txt_right_'+del_id).val(txt_del);
					
					$("#right_"+del_id).html(''+txt_del+'<textarea class="hidden" id="txt_right_'+del_id+'">'+txt_del+'</textarea>');
					$("#right_"+del_id).append('<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#smallModal" onclick="edit_right('+del_id+');"> تعديل النص <i class="fa fa-edit"></i></a>');
					}
				if(del_type==2){
				$('#txt_left_'+del_id).val(txt_del);
					$("#left_"+del_id).html(''+txt_del+'<textarea class="hidden" id="txt_left_'+del_id+'">'+txt_del+'</textarea>');
					$("#left_"+del_id).append('<a href="#" class="btn btn-warning"  data-toggle="modal" data-target="#smallModal" onclick="edit_left('+del_id+');"> تعديل النص <i class="fa fa-edit"></i></a>');
					}	
	}); 
 
		});

 </script>

 
    <div class="clearfix"></div>
<div class="ask-st">
<div class="sec-title">	
          <h2>التوصيل</h2>
                    <a href="javaScript:void(0);" onclick="create_row();" class="btn btn-success pull-left"><i class="fa fa-plus"></i> اضافة صف </a>              

 </div>
                
<div class="form-group col-lg-12">
  <table class="table table-striped table-bordered" id="table_del" >
  	<tr>
    	<td>الترقيم </td>
        <td> الجانب الايمن </td>
        <td>الجانب الايسر </td>
    </tr>
  	<tbody>
    <?php foreach( $Question as $key=>$row){if($key!=0){?>
    	<tr>
        	<td><?php echo $key;?></td>
            <td id="right_<?php  echo $key;?>">  <?php echo $row?>
             <textarea class="hidden" id="txt_right_<?php  echo $key;?>">  <?php echo $row?></textarea> <input type="button"  class="btn btn-danger" data-toggle="modal" data-target="#smallModal" onclick="create_right('<?php  echo $key;?>');" value="اضافة عنصر فى الجانب الايمن" /></td>
            <td id="left_<?php echo  $key;?>">  <?php echo $Answer[$key]?>
             <textarea class="hidden" id="txt_left_<?php  echo $key;?>"> <?php echo $Answer[$key]?> </textarea> <input type="button"  class="btn btn-danger" data-toggle="modal" data-target="#smallModal" onclick="create_left('<?php  echo $key;?>');" value="اضافة عنصر فى الجانب الايسر" />
            </td>
        </tr>
	<?php }}?>
    </tbody>
  </table>
</div>
  <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Degree'); ?></label>
                <div class="col-lg-6">
                <input type="number" class="form-control"  name="txt_Degree_del" value="<?php echo $Degree?>" style="float:none;clear:both;"  id="txt_Degree_del"  class=" full">
                </div> 
                <label class="col-lg-3 control-label"> الدرجه لكل صف
                <div class=" " id="total_Degree" > </div>
                </label>
            </div>				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="7"/>

  <input type="hidden" name="num_del" id="num_del" value="<?php echo $key?>" />
 
 				<input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>
<div class="clearfix"></div>   
 <div class="form-group col-lg-6">
     <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save fa-2"></i> <?php echo lang('am_save');?></button>
    </div>       
</div>
<div class="clearfix"></div>

</div>
<?php }?>
 