 
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
 	 											 $("#emp_add_question").show() ;
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

    <div class="clearfix"></div>
<div class="ask-st">
<div class="sec-title">	
          <h2>التوصيل</h2>
          
                 <a href="#" onclick="delete_q('<?php echo $questions_content_ID;?>');" class="btn btn-danger pull-left btn_exam_tool btn_exam_tool1"><i class="fa fa-trash"></i>  <?php echo lang('am_delete');?></a>
            <a href="#" onclick="edit_q('<?php echo $questions_content_ID;?>');" class="btn btn-success pull-left btn_exam_tool btn_exam_tool2" ><i class="fa fa-edit"></i> <?php echo lang('am_edit');?></a>
 </div>
                
<div class="form-group col-lg-12">
  <table class="table table-striped table-bordered" id="table_del" >
  	<tr>
    	<td>الترقيم </td>
        <td> الجانب الايمن </td>
        <td>الجانب الايسر </td>
    </tr>
  	<tbody>
    <?php   foreach( $Question as $key=>$row){if($key!=0){?>
    	<tr>
        	<td><?php echo $key;?></td>
            <td id="right_<?php echo $key;?>">  <?php echo $row?></td>
            <td id="left_<?php echo $key;?>">  <?php echo $Answer[$key]?></td>
        </tr>
	<?php }}?>
    </tbody>
  </table>
</div>
  <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Degree'); ?></label>
                <div class="col-lg-6">
                <input type="number" class="form-control"  name="txt_Degree_del"  value="<?php echo $Degree?>" style="float:none;clear:both;"  id="txt_Degree_del"   class=" full">
                </div> 
                <label class="col-lg-3 control-label"> الدرجه لكل صف
                <div class=" " id="total_Degree" > </div>
                </label>
            </div>				<input type="hidden" name="txt_Tquestion_ID" id="txt_Tquestion_ID" value="7"/>

  <input type="hidden" name="num_del" id="num_del" value="1" />
 
<div class="clearfix"></div>          
</div>
<div class="clearfix"></div>

</div>
<?php }?>
 