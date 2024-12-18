<?php
/*
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
}*/

?>
<script type="text/javascript">

 $(document).ready(function(){	
  setInterval(function() {
        $("#divMessage").hide("slow");
    }, 10000);  
 })
</script>
<style type="text/css">
.divMessage {
	width:98%;
	padding:7px;
	text-align:center;
	font-weight:bold;
	background-color: #C1F3A0;
	border: 1px solid #B4F37A;
	-moz-border-radius: 9px;
	-webkit-border-radius: 9px;
	border-radius: 9px;
	/*IE 7 AND 8 DO NOT SUPPORT BORDER RADIUS*/
	-moz-box-shadow: 0px 0px 2px #B4F37A;
	-webkit-box-shadow: 0px 0px 2px #B4F37A;
	box-shadow: 0px 0px 2px #336633;
	/*IE 7 AND 8 DO NOT SUPPORT BLUR PROPERTY OF SHADOWS*/
	opacity: 0.89;
	-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity = 89);
	/*-ms-filter must come before filter*/
	filter: alpha(opacity = 89);
	/*INNER ELEMENTS MUST NOT BREAK THIS ELEMENTS BOUNDARIES*/
	/*All filters must be placed together*/
	line-height:30px;
	

	}.divMessage h4 {
		border:none !important;
		color:#336633;
		}
</style>

    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">
 <div class="sec-title">
    <h2><?php  echo lang('Exams');?></h2>
 </div>
<?php

if (isset($message)){ 
			echo "<div id='divMessage' class='divMessage'><h4>".$message."</h4></div>"; 
}
?><?php
		$count=0;
        if($exam_details!=0){ 
			?>
          
<table class="table table-bordered table-striped" id="static">
     <thead>
         <tr>
            <th width="352"  align="center"><?php echo lang('Exam_Name'); ?></th>
            <th width="174" ><?php echo lang('Subject'); ?></th>
               <th width="199" ><?php echo lang('Time'); ?></th>
            <th width="199" ><?php echo lang('test_student_degree').' '.lang('from').' ' .lang('test_degree'); ?></th>
            <th width="246" ><?php echo lang('answer_exam'); ?></th>
         </tr>
      </thead> 
        <?php
            foreach($exam_details as $row){
				$test_ID              = $row->test_ID;
				$test_Name            = $row->test_Name;
				$test_Description     = $row->test_Description;
				$time_count           = $row->time_count;
				$teacher_Name         = $row->teacher_Name;
				$subject_Name         = $row->subject_Name;
				$config_semester_Name = $row->config_semester_Name;
				$row_level_Name       = $row->row_level_Name;
				$sumDegree            = $this->answer_exam_job_model->get_sum_degree($test_ID);	 
				extract($sumDegree);
				$count++;
			?>
     <tbody>
        <tr>
         <td  align="center"><?php  echo $test_Name;?></td>
         <td  align="center"><?php  echo $subject_Name.' - '.$row_level_Name;?></td>
            <td  align="center"><?php  echo $time_count;?></td>
         <td  align="center"><?php if($SumDegreeSt==""){$SumDegreeSt=' '.lang('not_answer_Exam');}else{$SumDegreeSt=' '.lang('from').' ' .$SumDegreeSt;
?>
 <?php
} echo $SumDegreeQ.$SumDegreeSt;?></td>
         <td >
        
         <a class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('emp/answer_exam/sees_answer/'.$test_ID )?>" >
           <?php echo lang('answer_exam'); ?> <i class="fa fa-pencil-square"></i>
          </a>
     
       </td>
   </tr>
  </tbody>
      <?php
            }
        ?>
</table>		     
                     
		<?php
            }else{?><div class="alert alert-danger"><?php echo lang('Not_exit') ;?></div><?php }
        ?>
       
    <input type="hidden" name="txt_count_ID" id="txt_count_ID" value="<?php  echo $count;?>" />
    
     
     
     </div>
     <div class="clearfix"></div>
     </div>
      <div class="clearfix"></div>
     </div>
