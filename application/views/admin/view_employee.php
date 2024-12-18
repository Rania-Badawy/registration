<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
 <script type="text/javascript" language="javascript" class="init">
    $(function () {
    $('#example').dataTable();
	
	       $("#check_all_Del").on("click", function() {
           $('.check_del').prop("checked", $(this).prop("checked"));
         });
    });
</script>

<script>
    function get_emp()
    {
        var NumberID=$("#NumberID").val();
        var str = $("#Name").val();
         if(str=="")
         {
            Name="NULL";
        }else{
           var Name = str.trim(); 
        }
         if(NumberID=="")
         {
            NumberID="NULL";
             
         }
    
       var check_active = 1  ;
    
      if($("#check_active").prop("checked") == true){var check_active = 0  ;}
    	window.location = "<?= site_url('admin/employee/index')?>/"+Name+"/"+NumberID+"/"+check_active;
    }
</script>

    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">
         <div class="block-st">
            <div class="sec-title">
              <h2><?php echo lang( 'br_employee_edit'); ?> </h2>
              <span class="pull-left">
    
                         <?php
                               $per=check_group_permission_page();
                              if($per['PermissionAdd']==1 ){?>
                             <a class="btn btn-success pull-left" href="<?= site_url('admin/employee/new_employee') ?>" ><?= lang('br_add_employee');?> </a>
                             <?php } ?>
                             <a class="btn btn-success pull-left" href="<?= site_url('admin/employee/index/show') ?>" > <?= lang('am_view_all');?></a>
                             <a class="btn btn-danger pull-left" href="<?= site_url('admin/employee/index/disactive') ?>" > <?= lang('br_not_active');?></a>
                              
          
				</span>
            </div>
 <div class="clearfix"></div>
            

			<?php 
				if($this->session->flashdata('SuccessAdd')){
				    echo  '<div class="alert alert-success">'. $this->session->flashdata('SuccessAdd').'</div>';

				}
				if($this->session->flashdata('ErrorAdd')){
				    echo  '<div class="alert alert-error">'. $this->session->flashdata('ErrorAdd').'</div>';

				}
			?> 
      
    <div class="form-group col-lg-5">

            <label for="multiple-label-example " class="label-control col-lg-3"><?php echo lang('br_Name'); ?></label>

            <div class="col-lg-9">

            <input name="Name" id="Name" class="form-control" type="text" value="<?php if($Name!="NULL"){ echo urldecode($Name);}?>">

            </div>

    </div>

    <div class="form-group col-lg-5">

          <label for="multiple-label-example " class="label-control col-lg-3"><?php echo lang('br_NumberID'); ?></label>

          <div class="col-lg-9">

          <input name="NumberID" id="NumberID" class="form-control" type="number" min="0" oninput="validity.valid||(value='');"  value="<?php if($NumberID!="NULL"){echo $NumberID;}?>">

          </div>

    </div>
    <div class="col-lg-2">

        <input type="button" class="btn btn-primary" onclick="return get_emp();" value="<?php echo lang('br_search');?>">

    </div>

 <div class="clearfix"></div>
            
<?php
if(($get_employee !="")&&($get_employee !="NULL")){
?>
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
       <?php if($per['PermissionEdit']==1){?>
       <th><?php echo lang('br_edit') ?></th>
       <?php } ?>
       <th><?php echo lang('br_status') ?></th>
       <?php if($per['PermissionDelete']==1){?>
       <th><?php echo lang('br_check_all') ?>
      <input type="checkbox" id="check_all_Del" style="display:inline-block !important; float:left;"/>
       </th>
       <?php } ?>
       </tr>
   </thead>
<tbody>
		<?php
          foreach($get_employee as $Key=>$RowEmp)
		  {
				$KeyVal              = $Key+1 ;
				$ID                  = $RowEmp->ID ;
				$Name                = $RowEmp->Name ;
				$Name_en             = $RowEmp->Name_en ;
				$Number_ID           = $RowEmp->Number_ID ;
				$Mail                = $RowEmp->Mail ;
				$Mobile              = $RowEmp->Mobile ;
				$LevelID             = $RowEmp->LevelID ;
				$Token               = $RowEmp->Token ;
				$Isactive            = $RowEmp->Isactive ;
				$LastLogin           = $RowEmp->LastLogin ;
				$CheckActive         = array(0=>lang('br_not_active'),1=>lang('br_active')); 
				// $CheckDelete = $this->employee_model->check_delete($ID);
				$Level_Name="";
				if($LevelID){
					$GetData = $this->db->query("SELECT GROUP_CONCAT(DISTINCT(row_level.Level_Name)) AS Level_Name 
					                             from row_level 
		                                         inner  JOIN employee ON employee.Contact_ID = $ID  AND FIND_IN_SET(row_level.Level_ID,employee.LevelID)
					                             ")->row_array();
				 $Level_Name= $GetData['Level_Name'];
				}
				?>
				<tr>
                <td><?php echo $KeyVal ; ?></td>
                <td><?php echo $Name ; ?></td>
                <td><?php echo $Number_ID ; ?></td>
                <td><?php echo $Mail ; ?></td>
                <td><?php echo $Mobile ; ?></td>
                <?php if($ApiDbname=='SchoolAccGheras'){?>
               <td><?php echo $Level_Name ; ?></td>
                <?php } ?>
                <td><?php echo $LastLogin ; ?></td>
                <?php if($per['PermissionEdit']==1){?>
                <td>
                <a href="<?= site_url('admin/employee/get_employee/'.$ID.''); ?>" class="btn btn-success btn-rounded fa fa-edit">
					      </td>
                <?php } ?>
                <td>
                  <a href="<?= site_url('admin/employee/check_active/'.$ID.''); ?>"><?= $CheckActive[$Isactive] ?></a>
                </td>
                  <?php if($per['PermissionDelete']==1){?>
            
                <td>
                    <input type="checkbox" class="check_del" name="checkboxdel" style="display:block !important" value="<?= $ID ; ?>"/>
                </td>
                <?php } ?>
                </tr>
			  <?php } ?>
         </tbody>
   </table>
   <?php if($per['PermissionDelete']==1){?>
   <div class="form-group col-lg-12">      
   <input type="button" class="btn btn-danger pull-left" value="<?php if($this->uri->segment(6)==0 && $this->uri->segment(6)!=""){echo lang('br_btn_active');}else{ echo lang('br_btn_not_active');} ?>" onClick="return delete_emp();" />
 </div> 
 <?php } ?>
   </div>
   
   
   </div>
   
   <?php 
  }elseif(!$this->uri->segment(4)){}elseif($get_employee =="" && $this->uri->segment(4)){echo '<div class="alert alert-error">'.lang('am_no_teachers').'</div>';}else{}
 ?>
   <div class="clearfix"></div>
   </div>
  <div class="clearfix"></div>
   </div>   
  <div class="clearfix"></div>
   </div>   
<div class="clearfix"></div>
<script>
function delete_emp()
{
	var msg = confirm('<?= lang('br_confirm') ?>');
	if(msg){
		
		      var favorite = [];
            $.each($("input[name='checkboxdel']:checked"), function(){            
                favorite.push($(this).val());
            });
			
			if(favorite.length > 0 )
			{
				
			
			
			var EmpID = favorite.join(", ") ; 
            var data  = { EmpID :EmpID };
									var url   = "<?php echo site_url('admin/employee/delete_emp_check') ?>" ;
									$.ajax({
										type    : "POST",
										url     : url,
										data    : data,
										cache   : false,
										beforeSend : function(){}, 
										success : function(html)
										{ 
										  window.location = "<?=  current_url(); ?>" ;
										//// end success
										},error: function(jqXHR, exception) {
											alert('Not connect.\n Verify Network.');
										}
									 }); /////END AJAX
		    }
			else{  alert("<?=  lang('br_error_permission') ?>"); return false ; }
		 }else{return false ; }
}
</script>