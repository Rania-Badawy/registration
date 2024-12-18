<style type="text/css" >
.red {
	color:#F00;
	width:99%;
	}
</style>


<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo base_url(); ?>jscripts/tiny_mce/tiny_mce.js"></script>

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
<!-- /TinyMCE -->

<script type="text/javascript">
function Del_Confirm()
	{
		var delConfirm = confirm("<?php echo lang('del_confirm') ?>")
		if (delConfirm)
		{ 	
			return ture;
		}else
		{
			return false;
		}
	
	}

</script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" class="init">
$(document).ready( function () {
	$('#example').dataTable();
	$('#example2').dataTable();
				/*var oTable = $('#example').dataTable( {
					"sDom": 'R<"H"lfr>t<"F"ip>',
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				} );*/
				var values_total = $("input[id='total_degree']")
              .map(function(){return $(this).val();}).get();
				
				var values = $("input[id='s_degree']")
              .map(function(){return $(this).val();}).get();
			  

			} );
		</script>
	<script src="<?php echo base_url()?>js/jquery.reveal.js"></script>

	<script type="text/javascript">
	function popupJ(num){
				var modal = '#modal'+num;
			 	$(modal).reveal({ // The item which will be opened with reveal
				  	animation: 'fade',                   // fade, fadeAndPop, none
					animationspeed: 600,                       // how fast animtions are
					closeonbackgroundclick: true,              // if you click background will modal close?
					dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
				});
			}
    function validation_upload(count_upload,row_num){
				var array_t_s_ID       = new Array();
				var array_s_degree     = new Array();
				var array_total_degree = new Array();
				var count_array        = 0;
				var upload_answer = "upload_answer_"+count_upload;
				upload_answer     =parseInt(document.getElementById(upload_answer).value);
				var bigger_t_degree = 0;
				var no_any_ans = 0;
				/*********************************************************/
				for (var i = 1 ; i<=upload_answer;i++){ 
				var s_degree      = "#s_degree_"+row_num+"_"+i;
				s_degree          = parseInt($(s_degree).val());
				
				if(!s_degree){no_any_ans++;}else{}
				}
				if(no_any_ans==upload_answer){alert("<?php echo lang('no_enter_numder_degree'); ?>");}else{
				/*********************************************************/
				for (var i = 1 ; i<=upload_answer;i++){ 
				var upload_div    = "#upload_div_"+row_num+"_"+i;
				
				var s_degree      = "#s_degree_"+row_num+"_"+i;
				s_degree          = parseInt($(s_degree).val());
				
				var total_degree  = "#total_degree_"+row_num+"_"+i;
				total_degree          =parseInt($(total_degree).val());
				
				if(!s_degree){}else{
					if(total_degree>=s_degree){
						var t_s_ID  = "#t_s_ID_"+row_num+"_"+i;
						t_s_ID          =parseInt($(t_s_ID).val());
						array_t_s_ID[count_array ]       = t_s_ID;
						array_s_degree[count_array ]     = s_degree;
						array_total_degree[count_array ] = total_degree;
						count_array ++;
						}else{
							upload_div_all    = "#lab_"+row_num+"_"+i;
							bigger_t_degree++;
							$(upload_div_all).show();
							$("#s_degree_"+row_num+"_"+i).css( "border", "1px solid #F00" );
							}
					}
				}
				}
				$.ajax({
					type: "POST",
					url: "<?php echo  site_url('emp/exam_new_emp/add_upload_degree');?>",
					cache: false,
					data:  ({ t_s_ID:array_t_s_ID,s_degree:array_s_degree,total_degree:array_total_degree }),
					success: function(html)
					{
					window.location.href = '<?php echo  site_url('exam');?>';	
					$("#result").html(html).show();
					}
						 });
			}
	 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	  function collapse_q(count_ans,count_upload){
		  var div_upload ="#content_"+count_ans+"_"+count_upload; 
		  if($(div_upload).is(':visible')){
			    $(".all_content .contentJ ").hide();
			   $(div_upload).slideUp("slow" );
			  }else{
				 $(".all_content .contentJ ").hide();
				 $(div_upload).slideDown(); 
				  }
		  }
	</script>
    
    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">

 <div class="sec-title">	
    <h2><?php  echo lang('Exams');?></h2>
<a class="btn btn-success pull-left" href="<?php echo site_url('emp/exam_new_emp/create_exam')?>" title="bottom left"><?php echo lang('Add_Exam'); ?> </a>
 
</div>
        <div id="collapseDVR3" >
<div id="result"></div>


<div class="clearfix"></div>

<?php 
		$count=0;
        if($exam_details!=0){
			?>
         <div class="clearfix"></div>
            <div class="panel panel-danger">
				<div class="panel-body no-padding">
 <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
     <thead>
         <tr>
            <th align="center"><?php echo lang('Exam_Name'); ?></th>
            <th><?php echo lang('Subject'); ?></th>
            <th><?php echo lang('Description'); ?></th>
            <th><?php echo lang('Semester'); ?></th>
            <th><?php echo lang('Time'); ?></th>
            <th><?php echo lang('am_edit'); ?></th>
             <th>حل الاختبار</th>
            <th>نموذج الاجابة</th>
             <th><?php echo lang('am_delete'); ?></th>
         </tr>
      </thead>  
     <tbody>
        <?php
            foreach($exam_details as $row){
				$Name                   = $row->Name;
				$Description            = $row->Description;
				$subject_Name           = $row->subject_Name;
				$Name_sms               = $row->Name_sms;
				$time_count             = $row->time_count;
				$row_Name               = $row->row_Name;
				$level_Name             = $row->level_Name;
				$ID                     = $row->ID;		
				$count++;
			?>
        <tr >
         <td  align="center"><?php  echo $Name;?></td>
         <td  align="center"><?php  echo $subject_Name ;?></td>
         <td  align="center"><?php  echo   $Description;?></td>
         <td  align="center"><?php  echo $Name_sms;?></td>
         <td  align="center"><?php  echo $time_count;?></td>
         <td >
         <span class="tip" >
         <a class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('emp/exam_new_emp/set_exam_edit/'.$ID )?>" >
            <i class="fa fa-edit"></i>
          </a>
       </span>
       </td>
        
         <td >
         <span class="tip" >
         <a class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('emp/answer_exam_job/show_exam_new/'.$ID )?>" >
             <i class="fa fa-edit"></i>
          </a>
       </span>
       </td> 
       
         <td >
         <span class="tip" >
         <a class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('emp/exam_new_emp/frame_exam/'.$ID  )?>" >
           <i class="fa fa-edit"></i>
          </a>
       </span>
       </td> 
       <td> 
       <span class="tip" >
         <a class="btn btn-danger btn-rounded" id="1" class="Delete" href="<?php echo site_url('emp/exam_new_emp/del_exam/'.$ID); ?>" onclick="return Del_Confirm(); " name="Band ring" title="Delete"  >
              <i class="fa fa-trash-o"></i>
        </a>
      </span> 
     </td>
   </tr>
      <?php
            }
        ?>
  </tbody>
</table>		     
    </div>
    </div>   
   <?php /*?><div id="report" >
   <div class="clearfix"></div><?php 
// $exams_students = $this->exam_new_emp_model->get_exams_students();	
?>
     <div class="sec-title">	
    <h2><?php echo lang('Report_exam_student') ;?></h2>
    </div>
    
    <?php
        if($exams_students!=0){
			?>
<div id="demo">
         <div class="clearfix"></div>
            <div class="panel panel-danger">
				<div class="panel-body no-padding">
 <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
     <thead>
         <tr>
         	<th><?php echo lang('student_name'); ?></th>
            <th align="center"><?php echo lang('Exam_Name'); ?></th>
            <th ><?php echo lang('Subject'); ?></th>
            <th><?php echo lang('test_student_degree').'/'.lang('test_degree'); ?></th>
            <th><?php echo lang('Semester'); ?></th>
            <th><?php echo lang('Row'); ?></th>
            <th ><?php echo lang('upload_question'); ?></th>
         </tr>
      </thead> 
	<tfoot>
         <tr>
         	<th ><?php echo lang('student_name'); ?></th>
            <th align="center"><?php echo lang('Exam_Name'); ?></th>
            <th ><?php echo lang('Subject'); ?></th>
            <th ><?php echo lang('test_student_degree').'/'.lang('test_degree'); ?></th>
            <th><?php echo lang('Semester'); ?></th>
            <th ><?php echo lang('Row'); ?></th>
            <th ><?php echo lang('upload_question'); ?></th>
         </tr>
	</tfoot>
	<tbody>
       <?php
	   $countRow = 2;
	   $count_answers = 1;
            foreach($exams_students as $row){
	 	  		$count_upload=0;
				$test_ID               = $row->test_ID;
				$test_Name             = $row->test_Name;
				$subject_Name          = $row->subject_Name;
				$contact_Name          = $row->contact_Name;
				$row_level_Name        = $row->row_level_Name;
				$test_Degree           = $row->test_Degree;
				$del_degree            = $this->exam_new_emp_model->get_del_degree($test_ID);
				if($del_degree!=0){
				$test_Degree           = $test_Degree +	array_sum($del_degree);	}
				$student_name          = $row->student_name.' '.$row->father_name;
				$config_semester_Name  = $row->config_semester_Name;
				$student_Degree        = $row->student_Degree;
				$student_ID            = $row->student_ID;
				$upload_answers        = $this->exam_new_emp_model->get_upload_answers($test_ID,$student_ID);	
				if($countRow%2==0){$styleRow = "even_gradeA";}else{$styleRow = "odd_gradeA";}
			?>
        <tr class="<?php echo $styleRow;?>">
         <td  align="center"><?php  echo $student_name;?></td>
         <td  align="center"> <?php  echo $test_Name;?></td>
         <td  align="center"><?php  echo $subject_Name;?> </td>
         <td  align="center"> <?php  echo $test_Degree.'/'.$student_Degree;?></td>
         <td  align="center"> <?php  echo $config_semester_Name;?></td>
         <td  align="center"> <?php  echo $row_level_Name;?></td>
         <td >	<?php
         		
            	if($upload_answers!=0){?>
         <a href="#" id="button<?php echo $count_answers?>" onclick="return popupJ('<?php echo $count_answers?>');"><?php echo lang('correction_upload'); ?></a>
          <div class="popupJ" >
                            <div id="modal<?php echo $count_answers?>" class="modal">
                            <div class="all_content" >	
							<?php
					foreach($upload_answers as $row_ans){
						$t_s_ID         = $row_ans->t_s_ID;
						$answer_content = $row_ans->answer_content;
						$Question       = $row_ans->Question;
						$q_Degree       = $row_ans->q_Degree;
						$Q_attach       = $row_ans->Q_attach;
					    $upload_answer         = 'upload_answer'.$count_answers.$count_upload;
						$count_upload++;
						?><div  id="upload_div_<?php echo $countRow.'_'.$count_upload?>">
                                <div class="heading" onclick="collapse_q('<?php echo $count_answers;?>','<?php echo $count_upload;?>');" >
                                   <?php echo lang('question'); ?>: <?php echo strip_tags($Question);?>
									<?php if($Q_attach!=""&&file_exists("upload/$Q_attach")){?>
                                              <a href="<?php echo base_url()?>upload/<?php echo $Q_attach;?>" title="<?php echo lang('Download').' '.lang('question')." - ".$Q_attach; ?>"><div class="iconBox color"> <img alt="<?php echo lang('Download')." - ".$Q_attach; ?>" src="<?php echo base_url();?>images/icon/color_18/arrow_down2.png" style="opacity: 1;"> </div></a>
                                     <?php }?>    <?php echo $count_answers; ?>
                                </div>
                               <div id="content_<?php echo $count_answers.'_'.$count_upload;?>" class="contentJ" style="display:none;" >
									<div class='red' style="display:none;" id="lab_<?php echo $countRow.'_'.$count_upload?>" ><?php echo lang('plese_check_number_degree'); ?></div>
                                       <div>
                                        <?php echo lang('answer'); ?>: 
										<?php if($answer_content!=""&&file_exists("upload/$answer_content")){?>
                                                  <a href="<?php echo base_url()?>upload/<?php echo $answer_content;?>" title="<?php echo lang('Download').' '.lang('answer')." - ".$answer_content; ?>"><div class="iconBox color"> <img alt="<?php echo lang('Download')." - ".$answer_content; ?>" src="<?php echo base_url();?>images/icon/color_18/download2.png" style="opacity: 1;"> </div></a>
                                         <?php }?>
                                         </div>
                                        <div> 
                                        <input type="text" value="" name="s_degree[]" onkeypress="return isNumberKey(event)" id="s_degree_<?php echo $countRow.'_'.$count_upload;?>"/>
                                     	<input type="hidden" value="<?php echo $q_Degree?>" name="total_degree[]" id="total_degree_<?php echo $countRow.'_'.$count_upload;?>"/>
                                        <input type="hidden" value="<?php echo $t_s_ID?>" name="t_s_ID[]" id="t_s_ID_<?php echo $countRow.'_'.$count_upload;?>"/>
                                        <span> - <?php echo $q_Degree;?> </span>
                                        </div>
                            </div>
                            </div>
						<?php 
						$count_answers++;
					}
			?>    <input type="hidden" name="upload_answer[]" value="<?php echo $count_upload;?>" id="upload_answer_<?php echo $count_upload;?>"/>
            </div>
             <div class="contentJ">
                <a href="#" class="button green" onclick="validation_upload('<?php  echo $count_upload?>','<?php  echo $countRow?>');">
              	  <img src="<?php echo base_url()?>images/tick.png"><?php echo lang('Save'); ?>
                </a>
                            
                 <a href="#" class="button red close"><img src="<?php echo base_url()?>images/cross.png"><?php echo lang('Cancel'); ?></a>
           </div>
            </div>
                            </div>
            <?php
            }else{
						 echo lang('am_not_exist'); 
						}
			?>
       	</td>
   		</tr>
 
      <?php
	   $countRow++;
            }
        ?> 
 </tbody>
</table>
</div>
</div>

</div>
<div class="spacer"></div>
<?php
		}else{?><div class="alert alert-danger"><?php echo lang('am_not_exist') ;?></div><?php }
?>  </div><?php */?>             
		<?php
            }else{?><div class="alert alert-danger"><?php echo lang('am_not_exist') ;?></div><?php }
        ?>
       
    <input type="hidden" name="txt_count_ID" id="txt_count_ID" value="<?php  echo $count;?>" />
    
  </div>
  
  </div>
  <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
  </div>
    
<?php /*?> <?php

function Cut($string, $max_length){
if (strlen($string) > $max_length){
$string = substr($string, 0, $max_length);
$pos = strrpos($string, " ");
if($pos === false) {
return substr($string, 0, $max_length)."...";
}
return substr($string, 0, $pos)."...";
}else{
return $string;
}
}
?><?php */?>