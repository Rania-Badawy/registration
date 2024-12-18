<?php
        if(isset($exam_details_edit)){
            foreach($exam_details_edit as $row){
				$Name                = $row->Name;
				$test_ID             = $row->test_ID;
				$Description         = $row->Description;
				$subject_Name_this   = $row->subject_Name;
				$Subject_ID_this     = $row->Subject_ID;
				$time_count          = $row->time_count; 	
				$date_from           = $row->date_from;		
				$date_to             = $row->date_to;			
 				$ID                  = $row->ID;
                 }
            }
?>
 
            <div class="form-group col-lg-3">
                <label class="control-label col-lg-12"><div class="error pull-left">*</div> <?php echo lang('Exam_Name'); ?></label>
                <div class="col-lg-12">
                <input class="form-control" type="text" name="txt_exam"  id="txt_exam"  value="<?php echo $Name;?>">
                </div>
                <div class="col-lg-12">
                <div class="error span9" id="error_txt_exam" > </div>
                </div>
            </div>
            
            <div class="form-group col-lg-3">
                <label class="control-label col-lg-12"><div class="error pull-left">*</div> <?php echo lang('Subject_Name'); ?></label>
                <div class="col-lg-12">
     <select class="  form-control" name="slct_subject" id="slct_subject" >
         <option value="<?php echo $Subject_ID_this;?>" <?php echo  set_select('slct_subject',$Subject_ID_this); ?>  ><?php echo $subject_Name_this;?></option>
         
        <?php
        if(isset($subjectEmp_details)){
            foreach($subjectEmp_details as $row){
                $subject_ID   = $row->SubEmpID;
                $subject_Name = $row->subject_Name;
                 if ($Subject_ID_this!= $subject_ID){?>
				 <option value="<?php echo $subject_ID ?>" <?php echo  set_select('slct_subject',$subject_ID); ?> ><?php echo $subject_Name ;?></option>
				<?php }
               
                }
            }
        ?>
        </select>                
                </div>
                <div class="col-lg-12">
                <div class="error span9"  id="error_slct_subject"> </div>
                </div>
            </div>
            <div class="form-group col-lg-3">
                <label class="control-label col-lg-12"><?php echo lang('Exam_Time2'); ?></label>
                <div class="col-lg-12 padd_left_none">
           
          <input class="form-control smallWidth" type="number" name="txt_time"  id="txt_time" value="<?php echo $time_count / 60;?>" >                
                </div>
                <div class="col-lg-9">
                <div class="error span9"   id="error_txt_time" >  </div>
                </div>
            </div>
            

<div class="clearfix"></div>
			<div class="form-group col-lg-3 ">
                <label class="control-label col-lg-12"><?php echo lang('date_time') ; ?></label>
         </div>
         <div class="clearfix"></div>
             <div class="form-group col-lg-3">
                <label class="control-label col-lg-12"><?php echo lang('am_from'); ?></label>
                <div class="col-lg-6">
                <?php  $date_from_format = new DateTime($date_from); 	?> 
                <input type="text" class="form-control datepicker" autocomplete="off" name="Date_from" id="Date_from"  value="<?= $date_from_format->format('Y-m-d');?>"/>
                </div> 
                  <div class="col-lg-6" dir="ltr">
                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                    <input type="text" class="form-control" name="time_from" id="time_from" value="<?= $date_from_format->format('H:i:s');?>">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group col-lg-3">
                <label class="control-label col-lg-12"><?php echo lang('am_to'); ?></label>
                <div class="col-lg-6">
                <?php  $date_to_format = new DateTime($date_to); 	?> 
                <input type="text" class="form-control datepicker" autocomplete="off"  name="Date_to" id="Date_to" value="<?= $date_to_format->format('Y-m-d');?>"/>
                </div>  
                  <div class="col-lg-6" dir="ltr">
                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                    <input type="text" class="form-control" name="time_to" id="time_to" value="<?= $date_to_format->format('H:i:s');?>">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                </div>
            </div>
           


            <div class="form-group col-lg-6">
                <label class="control-label col-lg-12"><?php echo lang('Description'); ?></label>
                <div class="col-lg-12 padd_left_none">
                  <textarea name="txt_description_edit" style="height:35px"  id="txt_description_edit" class="form-control"> <?php echo strip_tags( $Description);?></textarea>
                </div>
                <div class="col-lg-9">
                <div  class="error span9" id="error_txt_description"  > </div>
                </div>
            </div>

          <div class="form-group col-lg-12 text-left ">
            <button type="button" id="BtnEditExam" class="btn btn-success"><?php echo lang('am_save');?></button>
          </div>
<div class="clearfix"></div>  
 
<script type="text/javascript">
	
$(document).ready(function() {
    
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
   
    AScgiloc : 'https://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'https://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"
}); 

 	    $("#BtnEditExam").click(function(e) {
			 
 		var slct_subject  = $("#slct_subject").val(); 
 		var txt_test_ID  = $("#txt_test_ID").val(); 
		var txt_exam  = $("#txt_exam").val(); 
		var txt_time  = $("#txt_time").val(); 
		var txt_description  =  tinyMCE.get('txt_description_edit').getContent();
		var Date_from  = $("#Date_from").val(); 
		var Date_to  = $("#Date_to").val(); 
		var num_student  = $("#num_student").val();
		var Time_from  = $("#time_from").val();
		var Time_to  = $("#time_to").val();
		
		var timeDateFrom = Date_from + ' ' + Time_from; 
		var timeDateTo = Date_to + ' ' + Time_to;
 
 	var data  = {  txt_time :  txt_time , Date_to : timeDateTo  , Date_from :  timeDateFrom ,  slct_subject :  slct_subject , txt_exam : txt_exam, txt_description : txt_description ,txt_test_ID:txt_test_ID };
 
		$.ajax({
				type    : "POST",
				url     : "<?php echo site_url('emp/exam_new_emp/edit_exam') ?>",
				data    : data,
				cache   : false,
				beforeSend : function(){}, 
				success : function(html)
				{  
					if(html.stp == 0 )
					{ 
 						$("#error_slct_subject").html(html.slct_subject);
						$("#error_txt_exam").html(html.txt_exam);
						$("#error_txt_time").html(html.txt_time); 
 					}
					else if(html.stp == 1 )
					        { 
							$("#showEditExam").empty();
							add_exam_ID = html.add_exam_ID;
							$.ajax({
								type    : "POST",
								url     : "<?php echo site_url('emp/exam_new_emp/show_exam') ?>",
								data    :{add_exam_ID :add_exam_ID} ,
								success : function(html)
										{ 
										      $('#showExam').show();
											  $('#showExam').html(html) ;
 										}
							   });
  					        } 
					else if(html.stp == 2 )
					        { 
							$("#errorMessage").show();
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
    }); /////BTN CLICK
	   
});
</script>
 
 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/new/clockpicker/bootstrap-clockpicker.min.css" type="text/css" />
<script type ="text/javascript" src="<?php echo base_url(); ?>assets/new/clockpicker/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker(); 
</script>
<script>
$(document).ready(function () {

$(".datepicker.dropdown-menu").on("blur", function(e) { $(this).datepicker("hide"); }); 
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('#Date_from').datepicker({
  format: "yyyy-mm-dd", 
  onRender: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate());
    checkout.setValue(newDate);
  }
  checkin.hide();
  //$('#dpd2')[0].focus();
}).data('datepicker');
var checkout = $('#Date_to').datepicker({
  format: "yyyy-mm-dd", 
  onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');
 $("#Date_from ~ .datepicker").hide();
 $("#Date_to ~ .datepicker").hide();

});
</script>