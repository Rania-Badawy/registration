<script>

$(document).ready(function(e) {
	$("#loadingDiv").hide();
    	 $('#fileUpload').change(function(e) {
					$("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload')[0].files, function(i, file) {data.append('file', file);});
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
												$("#msg").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{
												var newImg = data.base+'upload/'+data.img;
												var hidImg       = $("#txt_attach").val(data.img);
												$( "#div_img" ).html('<div id="imgcon"><img src="'+newImg+'" class="uploadimgre" width="100px" height="100px"><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
				/*==============================================================================================*/
                });
});
function delImgUp(){$("#imgcon").remove()}
</script>
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
                <div class="col-lg-9">
                 <div class="error errorText"><?php echo form_error('txt_question') ?></div>
                </div>
            </div>

            <div class="form-group col-lg-6" style="display:none">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('am_degree_difficulty');?></label>
                <div class="col-lg-9">
                	 <select class="form-control selectpicker"  name="degree_difficulty" id="degree_difficulty">
                     <option value="1" <?php if ($degree_difficulty==1){?> selected="selected"  <?php }?>><?php echo lang('am_easy');?></option>
                     <option value="2" <?php if ($degree_difficulty==2){?> selected="selected"  <?php }?>><?php echo lang('am_average');?></option>
                     <option value="3" <?php if ($degree_difficulty==3){?> selected="selected"  <?php }?>><?php echo lang('am_difficult');?></option>
                     </select>                
                </div>
                <div class="col-lg-9">
                <div class="error errorText"><?php echo form_error('degree_difficulty') ?></div>
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


      
 <div class="clearfix"></div>                   
            <div class="form-group col-lg-6" style="display:none">
                <label class="control-label col-lg-3"><?php echo lang('attach');?> انواع الملفات : mp4|mp3|wav|aif|aiff|ogg|MP3|MP4|jpeg|png|jpg|gif|pdf|doc|docx|txt|ppt|xlsx|pptx</label>
                <div class="col-lg-3" dir="rtl">
            <input type="file" id="fileUpload" class="input03"  />
            <input name="txt_attach" id="txt_attach" type="hidden" value="0" />                
                </div>
                <div class="col-lg-3">
            <span id="msg"></span>
            <div id="div_img"></div>
            <div id="files"></div>
            <?php if($attach!=""&&file_exists("upload/$attach")){?>
     <a class="label label-info pull-left" href="<?php echo base_url()?>upload/<?php echo $attach;?>"  target="_blank" >
	 
     <img src="<?php echo base_url()?>upload/<?php echo $attach;?>" width="100px"/></a>
<?php }?>                
                </div>
                <div class="col-lg-9">    
                  <span id="error_image" class="error span10"></span>          
                </div>
            </div>
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


