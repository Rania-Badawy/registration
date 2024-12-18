 <style type="text/css" >.error {width:auto;}.errorText {float:none;clear:both; }</style>
  
       <?php
        if(isset($item_question)){
            foreach($item_question as $row){
  				$attach_answer      =  $row->Answer;
				$answers_ID      =  $row->answers_ID;
                $questions_content_ID      = $row->questions_content_ID;
                $question_Name      = $row->Name;
				$question           = $row->Question;
				$Degree             = $row->Degree;
				$attach             = $row->Q_attach;
				$questions_types_ID = $row->questions_types_ID;
				$questions_types  = $row->Name;
				$count_Choices =1;
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
				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="<?php echo $questions_types_ID;?>"/>
				<input type="hidden" name="txt_question_ID" id="txt_question_ID" value="<?php echo $questions_content_ID;?>"/>
<div class="clearfix"></div>                    

              <div id="question_div" ></div>  
              
          <div class="ask-st">
          
              <div class="form-group col-lg-10">
               <label class="control-label col-lg-2" dir="rtl">نموذج الاجابه : </label>

                <div class="col-lg-3 padd_right_none" dir="rtl">
                <input type="file" id="fileUpload2" class="input03" />
                </div>               
                <div class="col-lg-5" dir="rtl" > <a href="#" class="btn btn-info" onclick="alert('mp4 | mp3 | wav | aif | aiff | ogg | MP3 | MP4 | jpeg | png | jpg | gif | pdf | doc | docx | txt | ppt | xlsx | pptx');return false;"> انواع الملفات المسموح رفعها </a>   </div>
               
               <div class="clearfix"></div>  <div class="col-lg-2"></div>
                <div class="col-lg-2">
            <span id="msg2"></span>
                <?php if($attach_answer!=""&&file_exists("upload/$attach_answer")){?>
                <input name ="txt_attach2" id ="txt_attach2" type="hidden" value="<?php echo $attach_answer;?>" />
                  <?php }else{?>
                <input name ="txt_attach2" id ="txt_attach2" type="hidden" value="0" /><?php }?>
            <div id="div_img2">
            
                <?php if($attach_answer!=""&&file_exists("upload/$attach_answer")){?>
                  <a class="btn btn-success" href="<?php echo base_url()?>upload/<?php echo $attach_answer;?>">
				 <i class="fa fa-download"></i> <?php echo lang('Download'); ?></a>
                 <?php } ?> 
            </div>
			<span id="error_image2" class="error span10"></span>
            <div id="files2"></div>                
                </div>
            </div>
   <div class="clearfix"></div>
<div class="clearfix"></div>
                <div class="col-lg-9">
                <div class="error errorText" id="error_txt_attach2" ></div>
                 
                </div>
<div class="clearfix"></div>  
   <div class="clearfix"></div> 
                 <div class="form-group col-lg-2">
            <button type="button" id="BtnAddAns" class="btn btn-success pull-left"><i class="fa fa-save"></i> <?php echo lang('am_save');?></button>
          </div>
   <div class="clearfix"></div>          
          </div>
                <?php
                }
            }
        ?> 
        
       
     <div class="clearfix"></div>              
 
 
<script type="text/javascript">
	
$(document).ready(function() {
	    	 $('#fileUpload2').change(function(e) {
					$("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload2')[0].files, function(i, file) {data.append('file', file);});
				 /*==============================================================================================*/
				 /*----------------------------------------------------------------------------*/
								$.ajax({
										url: '<?php echo site_url('admin/upload_ajax/up_ax') ?>',
										data: data,
										cache: false,
										contentType: false,
										processData: false,
										type: 'POST',
										beforeSend : function()
										{
											
										},  
										success: function(data){
											$("#loadingDiv").hide();
											
											if(data.msg_type == 0 )
											{
												$("#msg2").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{$("#msg2").hide();
												var newImg = data.base+'upload/'+data.img;
												var hidImg       = $("#txt_attach2").val(data.img);
												$( "#div_img2" ).html('<div id="imgcon"><a href="'+newImg+'" class="btn btn-success" target="_blank"  ><i class="fa fa-download"></i> تحميل</a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
				/*==============================================================================================*/
                });
 	
    $("#BtnAddAns").click(function(e) { 
			var txt_question = tinyMCE.get('txt_question').getContent(); 
			 var degree_difficulty =$('input[name="difficult_degree"]:checked').val();
			 var txt_Degree = $("#txt_Degree").val();
			 var txt_attach = $("#txt_attach").val();
 			 var num_Choices = $("#num_Choices").val();
 			 var txt_Tquestion_ID = $("#txt_Tquestion_ID").val();
 			 var txt_attach2 = $("#txt_attach2").val();
 			 var txt_question_ID = $("#txt_question_ID").val();
		 if(txt_question!=""&&txt_Degree>0&&txt_attach2!=0&&txt_question_ID>0){
			  
 				 	$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/question_new/insert_question') ?>",
								data    :{txt_question :txt_question , degree_difficulty : degree_difficulty , txt_Degree : txt_Degree , txt_attach : txt_attach , txt_attach2 : txt_attach2  , txt_Tquestion_ID : txt_Tquestion_ID} ,
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
							   });  } if(txt_question==""){$( "#error_txt_question" ).html( "يجب ادخال نص " ); } else{$( "#error_txt_question" ).html( "" ); }
		  if(txt_Degree>0){$( "#error_txt_Degree" ).html( "" );} else{$( "#error_txt_Degree" ).html( "يجب ادخال الدرجة " ) ; } 
		  if(txt_attach2!=0){$( "#error_txt_attach2" ).html( "" );} else{$( "#error_txt_attach2" ).html( "يجب ادخال اجابة " ) ; } 
	});
});
</script>