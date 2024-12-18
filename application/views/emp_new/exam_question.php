<?php	   
$CI = get_instance();
$lang = $CI->session->userdata('language'); 
$dir = 'rtl';
if($lang != 'arabic'){
 $dir = 'ltr';
};
?>
<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
const initDir = 
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
    directionality: "<?php echo $dir ?>",   
    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
}); 
</script>
       <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/load.css">
           <div class="loading_div" id="loadingDiv" ></div>
                    <div id="result_data" >
                    <form  action="<?php echo site_url('emp/exam_new/add_exam_question/'.$Type_question_ID."/".$test_id); ?>" method="post">
                       <?php $query=$this->db->query("select Name from questions_types where ID=".$Type_question_ID."")->row_array();?>
                        <h2 ><?php echo $query['Name'];?> </h2>
                                
                                <div class="col-lg-9">
                                    <label for="" class="mb10 strong-weight"> <?php echo lang('question'); ?></label>
                                        <textarea name="txt_question" id="txt_question"></textarea>
                                </div>
                                <br>
                                <div class="row">
							    <div class="col-4 col-s-3 ">
							      <label class="control-radio">
								    <?php echo lang('am_easy'); ?>
							       <input type="radio"  name="difficult_degree"  value="1" checked="checked" style="width: 20%;" />
							      </label>
							    </div>
							    <div class="col-4 col-s-3 ">
							      <label class="control-radio">
								    <?php echo lang('am_average'); ?>
								    <input type="radio"  name="difficult_degree" value="2" style="width: 20%;" /> 	
							      </label>	                 
							   </div>                
							   <div class="col-4 col-s-3 ">
							     <label class="control-radio">
								   <?php echo lang('am_difficult'); ?>
								  <input type="radio" name="difficult_degree" value="3"  style="width: 20%;"/>	
							     </label>
							  </div>   
							  <div class="col-4 col-s-3 ">
							    <label class="control-radio">
								    <?php echo lang('Degree'); ?>
									<input type="number" name="txt_Degree" value="0.5" min="0.5" style="float:none;clear:both;"  id="txt_Degree"  step="0.5" >
							    </label>
							  </div> 
                            </div>
                            
                            <div class="row">
                            <label class="col-3 align-self-center mb15"><?php echo lang('am_attach'); ?></label>
                                <div class="col-4 col-s-3 ">
                                    <div class="file-input" data-btn="upload">
                                       <input type="file" id="fileUpload"/>
							           <input type="hidden" name ="hidImg" id ="hidImg"  value="0" />
							        </div>
                                </div>
                                <div class="col-4 col-s-3 ">
                                    <a href="#" class="btn purble-bg" onclick="alert('mp4 | mp3 | wav | aif | aiff | ogg | MP3 | MP4 | jpeg | png | jpg | gif | pdf | doc | docx | txt | ppt | xlsx | pptx');return false;"> <?php echo lang('Allowed_file_types') ?> </a>
                                </div>
                           
                            </div>
                              <?php if($Type_question_ID==1){ ?>
                              <div class="form-repeater" style="width: -webkit-fill-available;">
                                            <label for="" class="mb10 strong-weight">الاختيارات</label>
                                            <!-- Repeater Item -->
                                            <div class="repeater-item" style="width: -webkit-fill-available;">
                                                <!-- Controls to Repeate -->
                                                <div class="controls-wrap row" style="width: -webkit-fill-available;">
                                                    <?php 
                                                     for ($x = 1; $x <= 2; $x++){ 
                                                     ?>
                                                    <!-- Control -->
                                                    <div class="col-12 col-m-8">
                                                        <input type="text" name="txt_Choices" placeholder="" value="">
                                                    </div>
                                                    <!-- Control -->
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkbox" checked >
                                                        <span>الاجابه الصحيحة</span>
                                                    </label>
                                                    <?php 
                                  
                                                      }
                                                    ?>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="#" class="fas fa-plus add-item"></a>
                                                </div>
                                                <!-- Repeater Button -->
                                                
                                            </div>
                                            <!-- // Repeater Item -->
                                        </div>
                                         <?php }elseif($Type_question_ID==2){ ?>
                                    <div class="form-repeater" style="width: -webkit-fill-available;">
                                            <label for="" class="mb10 strong-weight">الاختيارات</label>
                                            <!-- Repeater Item -->
                                            <div class="repeater-item" style="width: -webkit-fill-available;">
                                                <!-- Controls to Repeate -->
                                                <div class="controls-wrap row" style="width: -webkit-fill-available;">
                                                    <?php 
                                                     for ($x = 1; $x <= 2; $x++){ 
                                                     ?>
                                                    <!-- Control -->
                                                    <div class="col-12 col-m-8">
                                                        <input type="text" placeholder="" value="">
                                                    </div>
                                                    <!-- Control -->
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkbox" checked >
                                                        <span>الاجابه الصحيحة</span>
                                                    </label>
                                                    <?php 
                                  
                                                      }
                                                    ?>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="#" class="fas fa-plus add-item"></a>
                                                </div>
                                                <!-- Repeater Button -->
                                                
                                            </div>
                                            <!-- // Repeater Item -->
                                        </div>
                            <?php }elseif($Type_question_ID==3){ ?>
                            <div class="col-lg-9">
                                 <a type="button" class="btn info" id="right_answer"><?php echo lang("right_answer"); ?></a> 
                                 <a type="button" class="btn default" id="wrong_answer"><?php echo lang("wrong_answer"); ?></a>
                                 <input type="hidden" name="true_txt" id="true_txt" value="1"/> 
				                 <input type="hidden" name="false_txt" id="false_txt" value="0"/> 
                            </div>         
                            <?php }elseif($Type_question_ID==4) {?>
                                    <br>
                                    <a type="button" class="btn btn info " onclick="Create_complete();"  herf="#" name="Create_answers" id="Create_answers" >  <?php echo lang('Add_Place_Correct_Answers'); ?>  </a>
                                    <a type="button" class="btn btn warning" onclick="Create_answers();"  herf="#" name="Create_answers" id="Create_answers" ><?php echo lang('Create_Correct_Answers'); ?></a>
                                <div class="alert alert-info" dir="rtl">
             	                    <strong><?php echo lang('how_complete') ?>.</strong>
                                    <br/>
             	                    <strong><?php echo lang('complete_answer_format'); ?>.</strong>
                                </div>
                            <?php }elseif($Type_question_ID==7) {?>
                             <div class="form-group col-lg-12">
                                <table class="table bordered-y white-bg medium-spaces" id="table_del" >
  	                              <tr>
                                    <td>الترقيم </td>
                                    <td> الجانب الايمن </td>
                                    <td>الجانب الايسر </td>
                                  </tr>
  	                           <tbody>
                                  <tr>
        	                       <td>1</td>
                                   <td id="right_1"> <textarea hidden id="txt_right_1"> </textarea><input type="button" data-toggle="modal" class="btn btn-danger" data-target="#smallModal" onclick="create_right('1');" value="اضافة عنصر فى الجانب الايمين" /></td>
                                   <td id="left_1">
                                   <textarea hidden id="txt_left_1"> </textarea> <input type="button"  data-toggle="modal" class="btn btn-danger" data-target="#smallModal" onclick="create_left('1');" value="اضافة عنصر فى الجانب الايسر" /></td>
                                  </tr>
                               </tbody>
                             </table>
                           </div>
                            <?php } ?>
                      
                       
                         
                        <div style="text-align: end;">
                            <button class="btn miw-120 small info" type="submit" ><?php echo lang('br_save') ?></button>
                        </div>
                    </form>
                </div>
        <script type="text/javascript">
            $(document).ready(function () {
              $("#loadingDiv").hide();
          /*========================================== question correct*/
           $("#wrong_answer").click(function(e) {

		  if(!$("#wrong_answer").hasClass('btn danger')){

			 $("#wrong_answer").removeClass('btn default');

			 $("#wrong_answer").addClass('btn danger');

			 $("#right_answer").removeClass('btn info'); 

			 $("#right_answer").addClass('btn default');

			 $("#false_txt").val(1);

			 $("#true_txt").val(0);

			 }

	 });

	 $("#right_answer").click(function(e) {

		   if(!$("#right_answer").hasClass('btn info')){

			 $("#right_answer").removeClass('btn default');

			 $("#right_answer").addClass('btn info');  

			 $("#wrong_answer").removeClass('btn danger');

			 $("#wrong_answer").addClass('btn default');

			 $("#false_txt").val(0);

			 $("#true_txt").val(1);

			 }

	 });
     
});
</script>
     <script>
    	/*===========================================================upload file*/
    	 $('#fileUpload').change(function(e) {
                  $("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload')[0].files, function(i, file) {data.append('file', file);});
								$.ajax({
										url: '<?php echo site_url('emp/Exam_new/up_ax') ?>',
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
											   $("#msgUpload").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{
												var newImg = data.base+'upload/'+data.img;
												var hidImg       = $("#hidImg").val(data.img);
												$( "#div_img" ).append('<div id="imgcon"><a href="'+newImg+'" ><?php echo lang('am_download');?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
                });

            function delImgUp(){$("#imgcon").remove()}
	/*==================================== question complete*/		
	           var ClickCount = 0;
               function Create_complete(){
                 var clickLimit = 1; //Max number of clicks
                //   if (ClickCount >= clickLimit)
                //   {
                //      alert("there is only  one space");
                //      return false;
                //   }
                //  else
                //  {
                   ClickCount++;
                   tinyMCE.get('txt_question').execCommand('insertHTML', false, ' ## ');
        
                //  }
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

  	   $('#txt_left_'+del_id).val();

 	   tinyMCE.get('txt_del').setContent($('#txt_left_'+del_id).val());



	}
</script>
<script src="<?php echo base_url(); ?>assets_emp/js/tornado.min.js"></script>