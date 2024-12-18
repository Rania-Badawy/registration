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

											{$("#msg").hide();

												var newImg = data.base+'upload/'+data.img;

												var hidImg       = $("#txt_attach").val(data.img);

												$( "#div_img" ).html('<div id="imgcon"><a href="'+newImg+'" target="_blank" class="btn btn-success"  ><i class="fa fa-download"></i> تحميل</a><button class="uploadclose" onClick="delImgUp();">X</button></div>');

											}

										}

						});

				/*==============================================================================================*/

                });

});

function delImgUp(){$("#imgcon").remove()}

</script>

<div class="ask-st">

 <div class="sec-title">	

                   <h2 id="question_name"> </h2>                 

  			    </div>

            <div class="form-group col-lg-12">

                <label class="control-label col-lg-1"><div class="error pull-left">*</div> <?php echo lang('question'); ?></label>

                <div class="col-lg-11 txt_question_st">

                <textarea name="txt_question" class="form-control " id="txt_question" style="width: 100%;"></textarea>   

                </div>

                <div class="col-lg-9">

                <div class="error errorText" id="error_txt_question">  </div>

                </div>

            </div>





            <div class="form-group col-lg-6 hidden">

                <label class="control-label col-lg-3"><?php echo lang('youtube_script'); ?></label>

                <div class="col-lg-9">

              <input type="text" class="form-control full" name="youtube_script" id="youtube_script" style="float:none;clear:both;" value="">

                </div>

                <div class="col-lg-9">

                <div class="error errorText"><?php echo form_error('youtube_script') ?></div>

                </div>

            </div>





            <div class="form-group col-lg-5 ">

                <label class="control-label col-lg-4 padd_left_none"><div class="error pull-left">*</div>درجه صعوبة السؤال</label>

                <div class="col-lg-8">

<?php /*?>                	 <select class="selectpicker form-control"  name="degree_difficulty" id="degree_difficulty">

                         <option value="0">إختر</option>

                         <option value="1"><?php echo lang('am_easy');?></option>

                         <option value="2"><?php echo lang('am_average');?></option>

                         <option value="3"><?php echo lang('am_difficult');?></option>

                     </select>  <?php */?>    

                <div class="col-lg-4">

                  <div class="radio radio-success">

                  <input type="radio"  name="difficult_degree"  value="1" checked="checked"  />

                  <label>سهل</label>

                  </div>                    

                </div>

                <div class="col-lg-4">

                  <div class="radio radio-success">

                  <input type="radio"  name="difficult_degree" value="2"  /> 

                  <label>متوسط</label>

                  </div>                   

                </div>                

                <div class="col-lg-4">

                  <div class="radio radio-success">

                  <input type="radio" name="difficult_degree" value="3"  />

                  <label>صعب</label>

                  </div>                 

                </div>                

                               

                </div>

                <div class="col-lg-9">

                 <div class="error errorText"></div>

                </div>

            </div>



            <div class="form-group col-lg-3">

                <label class="control-label col-lg-4"><div class="error pull-left">*</div> <?php echo lang('Degree'); ?></label>

                <div class="col-lg-8">

                <input type="number" class="form-control" name="txt_Degree" value="1" style="float:none;clear:both;"  id="txt_Degree"  value="" class=" full">

                </div> 

                <div class="col-lg-9">

                <div class="error errorText" id="error_txt_Degree" ></div>

                </div>

            </div>

            

  <div class="clearfix"></div>

  

            <div class="form-group col-lg-6">

                <label class="control-label col-lg-3 padd_left_none" dir="rtl">  <?php echo lang('am_attach') ?> : </label>

                <div class="col-lg-4" dir="rtl">

                <input type="file" id="fileUpload" class="input03" />

                <input name ="txt_attach" id ="txt_attach" type="hidden" value="0" />

                 </div>

                 <div class="col-lg-5" dir="rtl">

                <a href="#" class="btn btn-info" onclick="alert('mp4 | mp3 | wav | aif | aiff | ogg | MP3 | MP4 | jpeg | png | jpg | gif | pdf | doc | docx | txt | ppt | xlsx | pptx');return false;">انواع الملفات المسموح رفعها </a>

                </div>

                <div class="col-lg-3">

                <br />

                    <span id="msg"></span>

                    <div id="div_img"></div>

                    <span id="error_image" class="error span10"></span>

                    <div id="files"></div>    

                 </div>

             </div>  

              

                <div class="clearfix"></div>

          

</div>

                



