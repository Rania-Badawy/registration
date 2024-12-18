 

        <?php

	 

        if(isset($item_question)){

            foreach($item_question as $row){

                $questions_content_ID      = $row->questions_content_ID;

                $question_Name      = $row->Name;

				$question           = $row->Question;

				$Degree             = $row->Degree;

				$attach             = $row->Q_attach;

				$questions_types_ID = $row->questions_types_ID;

				$question_Type = $row->Name;

				$Answer             = $row->Answer;

				$answers_ID         = $row->answers_ID;

				$youtube_script = $row->youtube_script;

				$count_Choices =1;

				

			}

                ?>

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

<div id="question_<?php echo $questions_content_ID;?>">

<style>



.controls iframe {

	width:100% !important;

	height:100% !important;

	}

</style>

    <div class="clearfix"></div>

 

 <div class="block-st q-st">

  

        <div id="collapseDVR3" class="panel-collapse collapse in">

 



               

           

<!-- Question Area  Start -->

<div class="sec-title">	

       <h2 dir="rtl"><?php echo $question_Name;?> </h2>

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

 

              <?php   if($attach!=""&&file_exists("upload/".$attach)){?>               

            <div class="form-group col-lg-6"  >

                <label class="control-label col-lg-2"><?php echo lang('attach');?> </label>

               

                <div class="col-lg-2">

          

     <a class="btn btn-success" href="<?php echo base_url()?>upload/<?php echo $attach;?>"  target="_blank" >

	  <i class="fa fa-download"></i> <?php echo lang('am_download');?></a>

              

                </div>

                 

            </div><?php }?>     

<div class="clearfix"></div>

              <div class="form-group col-lg-6">

                <label class="control-label col-lg-3"><?php echo lang('answer'); ?></label>

                  <label class="control-label col-lg-9"> <?php echo $Answer;?> </label>

                     <input type="hidden" name="txt_answer_ID" id="txt_answer_ID" value="<?php echo $answers_ID;?>"/>

                <div class="col-lg-9">

                <div class="error errorText"><?php echo form_error('txt_answer') ?></div>

                </div>

            </div>

            

 

              

 

             



                   

   <div class="clearfix"></div>          

          <?php

            }

        ?>

             

    <div class="clearfix"></div>  



 

 

 

</div>

 <div class="clearfix"></div>     

</div>

 <div class="clearfix"></div>     

</div>