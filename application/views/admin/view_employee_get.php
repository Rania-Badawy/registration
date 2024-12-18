<?php
/*if($get_employee && $show != "NULL")
{ */  ?>

 <div class="clearfix"></div>
<div class="panel panel-danger">
<div class="panel-body no-padding">
        <table id="example" class="table table-striped table-bordered">
     <thead>
       <tr>
       <th><?php echo lang('br_n') ?></th>
       <th><?php echo lang('br_Name') ?></th>
       <th><?php echo lang('br_NumberID') ?></th>
       <th><?php echo lang('br_Email') ?></th>
       <th><?php echo lang('br_Mobile') ?></th>
       <th><?php echo lang('br_last_log') ?></th>
       <th><?php echo lang('br_edit') ?></th>
       <th><?php echo lang('br_status') ?></th>
       <th><?php echo lang('br_delete') ?></th>
       <th><?php echo lang('br_check_all') ?>
      <input type="checkbox" id="check_all_Del" style="display:inline-block !important; float:left;"/>
       </th>
       <th><?php echo lang('am_Pause') ?></th>
       </tr>
   </thead>
<!--tbody>
		<?php
          foreach($get_employee as $Key=>$RowEmp)
		  {
				$KeyVal              = $Key+1 ;
				$ID                  = $RowEmp->ID ;
				$Name                = $RowEmp->Name ;
				$Number_ID           = $RowEmp->Number_ID ;
				$Mail                = $RowEmp->Mail ;
				$Mobile              = $RowEmp->Mobile ;
				$Token               = $RowEmp->Token ;
				$Isactive            = $RowEmp->Isactive ;
				$LastLogin           = $RowEmp->LastLogin ;
				$Online              = $RowEmp->Online ;
				$DateFromDeactive    = $RowEmp->DateFromDeactive ;
				$DateToDeactive      = $RowEmp->DateToDeactive ;
				$CheckActive = array(0=>lang('br_not_active'),1=>lang('br_active')); 
				$CheckDelete = $this->employee_model->check_delete($ID);
				?>
				<tr>
                <td><?php echo $KeyVal ; ?></td>
                <td><?php echo $Name ; ?></td>
                <td><?php echo $Number_ID ; ?></td>
                <td><?php echo $Mail ; ?></td>
                <td><?php echo $Mobile ; ?></td>
                <td><?php echo $LastLogin ; ?></td>
                <td>
                <?php
				$Href = site_url('admin/employee/get_employee/'.$ID.'');
				check_group_permission_edit_link(35 , 'btn btn-success btn-rounded fa fa-edit' , '' , $Href  );
					?>
					</td>
                     <td>
                   <a href="<?= site_url('admin/employee/check_active/'.$ID.''); ?>"><?= $CheckActive[$Isactive] ?></a>
                   </td>
                    <td>
                    <?php
					$query = $this->db->query("SELECT ID FROM class_table WHERE EmpID = '".$ID."'")->num_rows();
					if($query == 0 )
					{
						$Href = site_url('admin/employee/delete_employee/'.$Token.'');
					    check_group_permission_delete_link(35 , 'btn btn-danger btn-rounded' , 'return check_Request();' , $Href ,'<i class="fa fa-trash-o"></i>');
					}else{
						   echo lang("br_delete_element");
						 }
					
					
                  ?>
                   </td>
                   
                    <td>
                    <?php
					$query = $this->db->query("SELECT ID FROM class_table WHERE EmpID = '".$ID."'")->num_rows();
					if($query == 0 )
					{
						
					    if(check_group_permission_delete_link(35 , '' , '' , '' ,'' , true))
						{
							?>
							<input type="checkbox" class="check_del" name="checkboxdel" style="display:block !important" value="<?= $ID ; ?>"/>
                            <?php
						}
					}else{ ?>
						  
						  <?php echo lang("br_delete_element"); ?>
						  
						<?php }
					
					
                  ?>
                   </td>
                   
                   <td>
                   
                   <?php
				   if($Isactive == 0 )
				   { ?>
					  <span> <?php echo lang('am_Activation_turned')."&nbsp;&nbsp;".$DateFromDeactive.lang('am_to').' &nbsp; &nbsp; '.$DateToDeactive   ;?></span>
					  
<a class="btn btn-success pull-left" href="<?= site_url('admin/employee/active_emp_date/'.$ID.'') ?>" > 
				  <?php echo lang('am_Activation') ?>  </a> 
					  
					   

					   <?php
	   
				   }else{
					      ?>
					   <button type="button" class="btn btn-danger pull-left" id="btn_deactive_<?= $ID ?>"  onclick="btn_deactive('<?= $ID ?>');" > <?php echo lang('am_Pause') ?></button> 
						  <?php
					    }
				    ?>
                   </td>
                </tr>
			  <?php 
			}
          ?>
         </tbody-->
   </table>
   <!--div class="form-group col-lg-12">      
      <input type="button" class="btn btn-danger pull-left" value="<?php echo lang('br_delete') ?>" onClick="return delete_emp();" />
 </div--> 
   </div>
   
   
   </div>
   
   <?php
 /* }else{echo '<div class="alert alert-error">'.lang('br_check_add').'</div>';}*/
 ?>

<script type="text/javascript">
 	$(document).ready(function() {
		$('#example').dataTable( {
			"language": {
                    "emptyTable": "لا توجد بيانات",
                    "loadingRecords": 'جاري التحميل ...',
                    "paginate": {
                        "next":       "التالي",
                        "previous":   "السابق"
                    },
                },
	        "ajax":{
			     	"url": "<?= site_url("admin/employee/getDataTableRecords"); ?>/show",
			     	"dataType": "json",
			     	"type": "post"
			    },
	       	aoColumns:[
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true }
            ],
	    } );
	} );
</script>