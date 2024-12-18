	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">


	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
    		<script type="text/javascript" src="<?php echo base_url(); ?>media/js/jquery.dataTables.columnFilter.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>

    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">
<script type="text/javascript" >
$( document ).ready(function() {
	$("#loadingDiv").hide();

$("#slct_Types_questions").change(function(e) { 
var slct_Types_questions =  $("#slct_Types_questions").val();
var txt_exam_ID          =  $("#txt_exam_ID").val();
switch(slct_Types_questions){
	 case'1':
	 	 window.location ='<?php echo site_url("emp/question/sess_show_question/1/'+txt_exam_ID+'"); ?>';
	   break;
	 case'2':
	    window.location ='<?php echo site_url("emp/question/sess_show_question/2/'+txt_exam_ID+'"); ?>';
	   break;
	 case'3':
	    window.location ='<?php echo site_url("emp/question/sess_show_question/3/'+txt_exam_ID+'"); ?>';
	   break;
	 case'4':
	    window.location ='<?php echo site_url("emp/question/sess_show_question/4/'+txt_exam_ID+'"); ?>';
	   break;
	 case'5':
	    window.location ='<?php echo site_url("emp/question/sess_show_question/5/'+txt_exam_ID+'"); ?>';
	   break;
     case'6':
	    window.location ='<?php echo site_url("emp/question/sess_show_question/6/'+txt_exam_ID+'"); ?>';
	   break;
     case'7':
	    window.location ='<?php echo site_url("emp/question/sess_show_question/7/'+txt_exam_ID+'"); ?>';
	   break;
	 default:
	
	}
});
 });
 
 
 	function add_exist_question(questionID){
var txt_exam_ID          =  $("#txt_exam_ID").val();
	$("#loadingDiv").show();

		  var data    = { questionID :  questionID,txt_exam_ID:txt_exam_ID};
		$.ajax({
				type    : "POST",
				url     : "<?php echo site_url('emp/question/add_exist_question') ?>",
				data    : data,
				cache   : false,
				beforeSend : function(){}, 
				success : function(html)
				{
					if(html.stp == 0 )
					{
						alert(html.msg);
	$("#loadingDiv").hide();
					}
					else if(html.stp == 1 )
					        {
								window.location.href = "<?php echo site_url('emp/question/add_question'); ?>/"+txt_exam_ID;	
					        }
				},
				error: function(jqXHR, exception) {
																	if (jqXHR.status === 0) {
																		alert('Not connect.\n Verify Network.');
																	} else if (jqXHR.status == 404) {
																		alert('Requested page not found. [404]');
																	} else if (jqXHR.status == 500) {
																		alert('Internal Server Error [500].');
																	} else if (exception === 'parsererror') {
																		alert('Requested JSON parse failed.');
																	} else if (exception === 'timeout') {
																		alert('Time out error.');
																	} else if (exception === 'abort') {
																		alert('Ajax request aborted.');
																	} else {
																		alert('Uncaught Error.\n' + jqXHR.responseText);
																	}
																}
		 }); /////END AJAX
		
		}
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/load.css">
<div class="loading_div" id="loadingDiv" ></div>

            <div class="form-group col-lg-6">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('Type_question'); ?></label>
                <div class="col-lg-9">
<select name="slct_Types_questions" id="slct_Types_questions" class="selectpicker form-control"  >
        
         <option value="0"  ><?php echo lang('Select_Type_question'); ?></option>
        <?php
        if(isset($Type_question)){
            foreach($Type_question as $row){
                $Type_question_ID   = $row->ID;
                $Type_question_Name = $row->Name;
                ?>
                <option value="<?php echo $Type_question_ID ?>" <?php echo  set_select('slct_Types_questions',$Type_question_ID); ?>  ><?php echo $Type_question_Name;?></option>
                <?php
                }
            }
        ?>
        </select>                
                </div>
                <div class="col-lg-9">
               <div class="error"><?php echo form_error('slct_Types_questions') ?></div> 
                </div>
            </div>

   <div class="clearfix"></div>

<div id="questions" ></div>   <div class="clearfix"></div>
<div id="loadingDiv" style="display:none;" ><img src="<?php echo base_url()?>/images/loading.gif"/></div>
<input type="hidden" name="txt_exam_ID" id="txt_exam_ID" value="<?php echo $exam_ID;?>"/>
   <div class="clearfix"></div>

   
    
 <script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
	$('#example').dataTable()
	
		  .columnFilter({
			aoColumns: [ { type: "text"},{type: "select", values: [ 'إختيار (واحد صحيح)', 'إختيار متعدد', 'صح أم خطأ','أكمل','اكتب المصطلح العلمى','السؤال المقالى','التوصيل'] },{ type: "number" },{ type: "select", values: [ 'سهل', 'متوسط', 'صعب']  },null
				]

		});
});

</script>

<?php
	 if($question !=0 ){            
?>  
             <div class="clearfix"></div>

            <div  class="panel panel-danger">
				<div class="panel-body no-padding"> 
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
   <thead>
	<tr>
    	<th><?php echo lang('question'); ?></th>
        <th><?php echo lang('Type_question'); ?></th>
        <th><?php echo lang('Degree'); ?></th>
        <th><?php echo lang('am_degree_difficulty'); ?></th>
        <th>  <?php echo lang('am_add_question');?></th>
    </tr>
   </thead>
   <tfoot>
	<tr>
    	<th><?php echo lang('question'); ?></th>
        <th><?php echo lang('Type_question'); ?></th>
        <th><?php echo lang('Degree'); ?></th>
        <th><?php echo lang('am_degree_difficulty'); ?></th>
        <th>  <?php echo lang('am_add_question');?></th>
    </tr>   
   </tfoot>
   <tbody>
  <?php  
  foreach($question as $row){
	  $q_type = $row->questions_types_ID;
	  ?><?php if($q_type!=7){?>
	<tr class="gradeX">
    	<td><?php  echo $row->Question;?></td>
    	<td><?php  echo $row->Name;?></td>
    	<td><?php  echo $row->Degree?></td>
    	<td><?php  if($row->degree_difficulty==1){echo lang('am_easy');}else if($row->degree_difficulty==2){echo lang('am_average');}else if($row->degree_difficulty==3){echo lang('am_difficult');}?></td>
        <td><span class="tip" >
         <a class="btn btn-success" onclick="add_exist_question('<?php echo $row->questions_content_ID ;?>');" href="#" title="Add"   
      >
         <i class="fa fa-plus-circle"></i>
        </a>
      </span></td>
    </tr>
    <?php }else{
		$Question = explode('%!%',$row->Question);
		$q_more = $Question[0].'...';
		$count_degree = count($Question)-1;
		$count_array = 1;
		$degree= 0;
		while($count_degree>$count_array){ 
		$degree = $degree+floatval($Question[$count_array]);
		$count_array= $count_array+2;}
		?>
	<tr class="gradeC">
    	<td><?php  echo $q_more;?></td>
    	<td><?php  echo $row->Name;?></td>
    	<td><?php  echo $degree;?></td>
    	<td><?php  if($row->degree_difficulty==1){echo lang('am_easy');}else if($row->degree_difficulty==2){echo lang('am_average');}else if($row->degree_difficulty==3){echo lang('am_difficult');}?></td>
        <td><span class="tip" >
         <a class="btn btn-success" onclick="add_exist_question('<?php echo $row->questions_content_ID ;?>');" href="#"  title="Add"   
      ><i class="fa fa-plus-circle"></i>
        </a>
      </span></td>
    </tr>
    <?php }//else type_q?>
 <?php }?>
   </tbody>
</table>

       </div>
       </div>
<?php  }
else
{?><div class="alert-danger alert"><?php echo lang('Not_exit') ;?></div><?php }?>

    </div>
    <div class="clearfix"></div>
     </div>  
    <div class="clearfix"></div>
    </div>

