	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">

	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>

<script type="text/javascript" language="javascript" class="init">

$(function () {

$('#example').dataTable();

});



function check_type(CheckType)

{

	if(CheckType == 1 )

	{

		$("#level_div").show();

		$("#row_div").hide();

		$("#class_div").hide();

		$("#subject_div").hide();

	}

	else if(CheckType == 2 )

	{

		$("#level_div").hide();

		$("#row_div").show();

		$("#class_div").hide();

		$("#subject_div").hide();

	}else if(CheckType == 3 )

	{

		$("#level_div").hide();

		$("#row_div").hide();

		$("#class_div").show();

		$("#subject_div").hide();

	}else if(CheckType == 4 )

	{

		$("#level_div").hide();

		$("#row_div").hide();

		$("#class_div").hide();

		$("#subject_div").show();

	}

	

}

///////////get_group_data

 function get_emp_data(EmpID)

 {

    	window.location = "<?= site_url("admin/user_permission/index"); ?>/"+EmpID ; 

 }

</script>



<script type="text/javascript">



  

	

	   function check_sub()

    {

        var DateFromH = $("#DateFromH").val();

        var DateToH   = $("#DateToH").val();

        if(DateFromH.split(" ").join("") == "" ||DateToH.split(" ").join("") == "" )

        {

            alert("<?= lang('br_error_permission') ?>");

            return false ;

        }

		

		var RadioChecked = $("input[name=type]:checked").val() ;

			

			if(RadioChecked == 1 )

			{

				if($("#level").val() == null)

			  {

				alert("<?= lang("br_error_permission") ?>");

				return false ;

			  }

			}

			

			if(RadioChecked == 2 )

			{

				if($("#RowLevel").val() == null)

			  {

				alert("<?= lang("br_error_permission") ?>");

				return false ;

			  }

			}

			

			if(RadioChecked == 3 )

			{

				if($("#Class").val() == null)

			  {

				alert("<?= lang("br_error_permission") ?>");

				return false ;

			  }

			}

			

			if(RadioChecked == 4 )

			{

				if($("#GetSubject").val() == null)

			  {

				alert("<?= lang("br_error_permission") ?>");

				return false ;

			  }

			}

		

    }

	

</script>





<style type="text/css">

    .calendars-month table, .calendars-month table.display thead tr th

    {

        line-height:normal !important;

    }</style>

    <div class="clearfix"></div>

  <div class="content margin-top-none container-page">  

       <div class="col-lg-12">

         <div class="block-st">

            <div class="sec-title">

            <h2><?php echo lang('br_permission_add'); ?></h2>

            </div>

 <?php 

	if($this->session->flashdata('SuccessAdd'))



   {



	   echo  '<div class="alert alert-success">'



          . $this->session->flashdata('SuccessAdd').  



          '</div>';



	}

	if($this->session->flashdata('ErrorAdd'))



   {



	   echo  '<div class="alert alert-error">'



          . $this->session->flashdata('ErrorAdd').  



          '</div>';



	}



    ?>



  <form  action="<?php echo site_url('admin/user_permission/add_user_permission/'.$UserID.''); ?>" method="post">

  

  

  

  

          <div class="form-group col-lg-6 col-xs-12">

            <label for="multiple-label-example " class="label-control col-lg-2 col-md-3 col-sm-3 col-xs-3"><?php echo lang('br_emp'); ?></label>

            <div class="col-lg-8 col-md-9 col-sm-9 col-xs-9">

             <select data-placeholder="<?php echo lang('br_emp'); ?>" onchange="get_emp_data(this.value);"  class="form-control selectpicker" data-live-search="true" tabindex="18" name="SelectUser"  id="SelectUser">

             <option value="0"><?php echo lang('br_emp'); ?></option>

            <?php

			if($get_emp)

			{

				foreach($get_emp as $Key=>$Emp)

				{

					$ID   = $Emp->ContactID ;

					$Name = $Emp->ContactName ;

					?>

					<option value="<?php echo $ID ; ?>" <?php if($UserID == $ID ){echo "selected" ;} ?> ><?php echo $Name ; ?></option>

					<?php 

				}

			}

			

			 ?>

          </select>

			</div>

          </div>

          

          

          

          <!-------------------------------Type---------------------------------------------->

          <div class="form-group col-lg-6">

  <label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-3"><?php echo lang('br_EmpType'); ?></label>

 <div class="col-lg-10 col-md-9 col-sm-9 col-xs-9">

 <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">

<label class='control control-radio'>
 
<?php echo lang('br_level') ?>
<input type="radio" name="type"   value="1" <?php if($Type == 1  || $Type == 0 ){echo "checked";} ?>   onchange="check_type(1);"/>
 <div class='control_indicator_radio'></div>

</label>
 

</div>



<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
<label class="control-radio">
 <?php echo lang('br_row_level') ?> 						 
	<div class="control_indicator_radio"></div>
 <input type="radio" name="type"  value="2" <?php if($Type == 2 ){echo "checked";} ?>  onchange="check_type(2);"/> 
</label>
 

</div>



<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
<label class="control-radio">
    <?php echo lang('br_classes') ?>
	<input type="radio" name="type"  value="3" <?php if($Type == 3 ){echo "checked";} ?>  onchange="check_type(3);"/>					 
	<div class="control_indicator_radio"></div>
</label>
 

</div>



<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
<label class="control-radio">
    <?php echo lang('br_subjects') ?>
	<input type="radio" name="type"  value="4" <?php if($Type == 4 ){echo "checked";} ?>  onchange="check_type(4);"/>					 
	<div class="control_indicator_radio"></div>
</label>
 

</div> 



 



 </div>

</div>

          <div id="level_div"<?php if($Type == 1  || $Type == 0 ){echo'style="display:block;"';}else{echo'style="display:none;"' ;} ?>>

			<div class="form-group col-lg-6">

            <label for="multiple-label-example " class="label-control col-lg-2"><?php echo lang('br_level'); ?></label>

            <div class="col-lg-8">

             <select multiple data-placeholder="<?php echo lang('br_level'); ?>"  class="selectpicker form-control" data-live-search="true" tabindex="18" name="level[]"  id="level">

            <?php

			if($GetLevel)

			{

				foreach($GetLevel as $Key=>$Level)

				{

					$ID   = $Level->ID ;

					$Name = $Level->Name ;

					?>

					<option value="<?php echo $ID ; ?>"

                    <?php if($Type == 1 && in_array( $ID ,$PerType)){echo 'selected' ;} ?>

                    >

					<?php echo $Name ; ?></option>

					<?php 

				}

			}

			

			 ?>

          </select>

			</div>

          </div>

          </div>

          

  <div id="row_div"<?php if($Type == 2){echo'style="display:block;"';}else{echo'style="display:none;"' ;} ?>>

          <div class="form-group col-lg-6">

            <label for="multiple-label-example " class="label-control col-lg-2"><?php echo lang('br_row_level'); ?></label>

            <div class="col-lg-8">

             <select multiple data-placeholder="<?php echo lang('br_row_level'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="RowLevel[]"  id="RowLevel">

            <?php

			if($GetRowLevel)

			{

				foreach($GetRowLevel as $Key=>$RowLevel)

				{

					$ID   = $RowLevel->RowLevelID ;

					$Name = $RowLevel->LevelName."--".$RowLevel->RowName ;

					?>

					<option value="<?php echo $ID ; ?>"

                    <?php if($Type == 2 && in_array( $ID ,$PerType)){echo 'selected' ;} ?>

                    ><?php echo $Name ; ?></option>

					<?php 

				}

			}

			

			 ?>

          </select>

			</div>

          </div>

          </div>

          

 <div id="class_div" <?php if($Type ==3){echo'style="display:block;"';}else{echo'style="display:none;"' ;} ?> >

          <div class="form-group col-lg-6">

            <label for="multiple-label-example " class="label-control col-lg-2"><?php echo lang('br_classes'); ?></label>

            <div class="col-lg-8">

             <select  data-placeholder="<?php echo lang('br_classes'); ?>"  class="selectpicker form-control" data-live-search="true" tabindex="18" name="Class[]"  id="Class" multiple>

            <?php
if($GetRowLevel)
                        			{ 
                        				foreach($GetRowLevel as $Key=>$RowLevel)
                        				{
			if($GetClass)

			{

				foreach($GetClass as $Key=>$Class)

				{

						$ID   = $RowLevel->RowLevelID.'|'.$Class->ClassID ;
                	$Name = $RowLevel->LevelName."--".$RowLevel->RowName."--".$Class->ClassName ;

					?>

					<option value="<?php echo $ID ; ?>"

                    <?php if($Type == 3 && in_array( $ID ,$PerType)){echo 'selected' ;} ?>

                    ><?php echo $Name ; ?></option>

					<?php 

				}

			}

                        				}}

			 ?>

          </select>

			</div>

          </div>

          </div>

 <div id="subject_div"<?php if($Type==4){echo'style="display:block;"';}else{echo'style="display:none;"';} ?>>

          <div class="form-group col-lg-6">

            <label for="multiple-label-example " class="label-control col-lg-2"><?php echo lang('br_subjects'); ?></label>

            <div class="col-lg-8">

             <select  data-placeholder="<?php echo lang('br_subjects'); ?>"  class="selectpicker form-control" data-live-search="true" tabindex="18" name="GetSubject[]"  id="GetSubject" multiple>

            <?php

			if($GetSubject)

			{

				foreach($GetSubject as $Key=>$Subject)

				{

					$ID   = $Subject->ConfigSubjectID ;

					$Name = $Subject->SubName.'-'.$Subject->LevelName.'-'.$Subject->RowName;

					?>

					<option value="<?php echo $ID ; ?>"

                    <?php if($Type == 4 && in_array( $ID ,$PerType)){echo 'selected' ;} ?>

                    ><?php echo $Name ; ?></option>

					<?php 

				}

			}

			 ?>

          </select>

			</div>

          </div> 

          </div>

			

            <div class="form-group col-lg-6 col-xs-12">

                    <label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-3"><?php echo lang('br_from'); ?></label>

                    <div class="col-lg-8 col-md-9 col-sm-9 col-xs-9">

                        <input type="text" id="DateFromH" class="form-control" name="DateFromH" value="<?= $DateFromH ?>" readonly  />

                    </div>

                    <span class="col-lg-12"></span>

                </div>

                

                <div class="form-group col-lg-6 col-xs-12">

                    <label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-3"><?php echo lang('br_to'); ?></label>

                    <div class="col-lg-8 col-md-9 col-sm-9 col-xs-9">

                        <input type="text" id="DateToH" class="form-control" name="DateToH" value="<?= $DateToH ?>" readonly  />

                    </div>

                    <span class="col-lg-12"></span>

                </div>

              <div class="clearfix"></div>

<div class="panel panel-danger">



<div class="panel-body no-padding">

    <?php

		if($UserID  != 0 )

		  {

	 

		  if($get_page)

		  {

			  ?>        

 <table  class="table table-striped table-bordered">

     <thead>

              <tr>

                  <th><?php echo lang('br_page_name'); ?></th>
                  
                  <th><?php echo lang('br_check_all'); ?> 
                  
                  <th><?php echo lang('br_page_add'); ?></th>

                  <th><?php echo lang('br_page_edit'); ?></th>

                  <th><?php echo lang('br_page_delete'); ?></th>

                  <th><?php echo lang('br_page_view'); ?></th>

              </tr>

     </thead>

     <tbody>         

			  <?php

			  

			  foreach($get_page as $KeyPage=>$RowGetPage)

			  {

				  $PageID   = $RowGetPage->ID ; 

				  $PageUrl  = $RowGetPage->PageUrl ; 

				  $PageName = $RowGetPage->PageName ;

				  $CheckPage = $this->user_permission_model->check_user_page($UserID,$PageID);

				  $Add    = 0  ;

				  $Edit   = 0  ;

				  $Delete = 0  ;

				  $View   = 0  ;

				  if(is_array($CheckPage))

				  {

					  $Add    = $CheckPage['PermissionAdd']  ;

					  $Edit   = $CheckPage['PermissionEdit']  ;

					  $Delete = $CheckPage['PermissionDelete']  ;

					  $View   = $CheckPage['PermissioView']  ;

				  }

				  ?>

				     <tr>

                     <td>

                     <?php echo lang($PageName) ?>

                    <input type="hidden" name="pageID<?php echo $KeyPage ?>" value="<?php echo $PageID ?>" /> 

                    </td>
                    <td><div ><input id="ChkAll<?php echo $KeyPage ?>" value="<?php echo $KeyPage ?>"  type="checkbox" onChange="check_all_add_edit('<?php echo $KeyPage ?>')" /><label></label></div></td>

                    <td><input style="display:block !important" type="checkbox" <?php if($Add == 1 ){echo 'checked' ;} ?> name="ChkAdd<?php echo $KeyPage ?>" id="ChkAdd<?php echo $KeyPage ?>" value="1"  /><label></label></td>

                    <td><input style="display:block !important" type="checkbox" <?php if($Edit == 1 ){echo 'checked' ;} ?> name="ChkEdit<?php echo $KeyPage ?>" id="ChkEdit<?php echo $KeyPage ?>"  value="1"  /><label></label></td>

                    <td><input style="display:block !important" type="checkbox" <?php if($Delete == 1 ){echo 'checked' ;} ?> name="ChkDel<?php echo $KeyPage ?>"id="ChkDel<?php echo $KeyPage ?>" value="1"  /><label></label></td>

                    <td><input style="display:block !important" type="checkbox" <?php if($View == 1 ){echo 'checked' ;} ?> name="ChkView<?php echo $KeyPage ?>" id="ChkView<?php echo $KeyPage ?>" value="1"  /><label></label></td>

                    </tr>

				  <?php  

			  }

			  ?>

       </tbody>       

			  </table>  

         <input type="hidden" name="KeyPage" value="<?php echo $KeyPage ?>"  />

         <input type="submit" class="btn btn-success" value="<?php echo lang('br_save'); ?>" onclick="return check_sub();"/> 



           <?php

		   }

		  }

		   ?>

              </div>

              </div>

              

        </form>  
<script type="text/javascript">

		function check_all_add_edit(count)

		{

			

			//alert(document.getElementById("ChkAll"+count).value);

			//var ckbox = $("#ChkAll"+count).checked;

		  if (document.getElementById("ChkAll"+count).checked) {

            $("#ChkAdd"+count).prop('checked', true); 

			$("#ChkEdit"+count).prop('checked', true); 

			$("#ChkDel"+count).prop('checked', true); 

			$("#ChkView"+count).prop('checked', true);

        } else {

            $("#ChkAdd"+count).prop('checked', false); 

			$("#ChkEdit"+count).prop('checked', false); 

			$("#ChkDel"+count).prop('checked', false); 

			$("#ChkView"+count).prop('checked', false);

        }

		  

	

		}

        

        </script>
      </div> 

     <div class="clearfix"></div>       

     </div>

     <div class="clearfix"></div>   

   </div>    
   

    
 

  </script><script type ="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />

<script type="text/javascript">

            // When the document is ready

            $(document).ready(function () {

                $('#DateToH,#DateFromH').datepicker({

                    format: "yyyy/mm/dd"

                });

                $(".datepicker").click(function() {

                    $('.datepicker').hide();

                    // $("#DateFromH").val($("#DateToH").val());

                });

            });



        </script> 

