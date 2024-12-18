
<form action="<?php echo site_url('admin/Report_Register/add_per_request/'.$Type) ?>" method="post">
                
<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">
           
            <div class="sec-title">
                 <?php if($Type ==3){ ?>
                <h2><?php echo lang( 'br_representatives_permissions'); ?>  </h2>
                <?php } else { ?>
                <h2><?php echo lang('br_per_request_1'); ?></h2>
                <?php } ?>
            </div>

            <?php

            if($this->session->flashdata('Sucsess'))

            {

                ?>

                <div class="widget-content">

                    <div class="widget-box">

                        <div class="alert alert-success fade in">

                            <button data-dismiss="alert" class="close" type="button">×</button>

                            <?php

                            echo $this->session->flashdata('Sucsess');

                            ?>

                        </div>

                    </div>

                </div>

            <?php

            }

            if($this->session->flashdata('Failuer'))

            {

                ?>

                <div class="widget-content">

                    <div class="widget-box">

                        <div class="alert alert-danger fade in">

                            <button data-dismiss="alert" class="close" type="button">×</button>

                            <?php

                            echo $this->session->flashdata('Failuer');

                            ?>

                        </div>

                    </div>

                </div>

            <?php

            }

            ?>

            <!----- Add title -------->

<?php if($Type ==2){ ?>
                
  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_EmpType'); ?></label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
           <select data-placeholder="<?php echo lang('br_EmpType'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="NameSpace"  id="NameSpace">
                 <!--<option value="">------</option>-->
            <?php if($GetAllNameSpace){
				foreach($GetAllNameSpace as $Key=>$NameSpace){
					$ID   = $NameSpace->ID ;
					$Name = $NameSpace->Name ;
			?>
		    	<option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
			<?php }} ?>

          </select> 
        </div>

 </div>
<?php } ?>

 <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_Emp_2'); ?></label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
           <select data-placeholder="<?php echo lang('br_Emp_2'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="EmpID" id="EmpID"  >
              <!--<option value="">------</option>-->
            <?php if($GetAllEmp){
				foreach($GetAllEmp as $Key=>$Emp){
					$ID   = $Emp->ID ;
					$Name = $Emp->Name ;
			?>
			<option value="<?php echo $ID ; ?>  <?php if($ID == $EmpID){echo 'selected'; } ?>"><?php echo $Name ; ?></option>
            <?php 	}} ?>
          </select> 
        </div>
 </div>
 
 <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('class_type'); ?></label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
           <select data-placeholder="<?php echo lang('class_type'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="class_type[]" id="class_type" multiple required >
              <!--<option value="">------</option>-->
            <?php if($GetClassType){
				foreach($GetClassType as $Key=>$val){
					$ID   = $val->ClassTypeId ;
					$Name = $val->ClassTypeName ;
			?>
			<option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
            <?php 	}} ?>
          </select> 
        </div>
 </div>
      
 <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('am_studeType'); ?></label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
           <select data-placeholder="<?php echo lang('class_type'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="studeType[]" id="studeType" multiple required >
            <?php if($allStudeType){
				foreach($allStudeType as $Key=>$val){
					$ID   = $val->StudyTypeId ;
					$Name = $val->StudyTypeName ;
			?>
			<option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
            <?php 	}} ?>
          </select> 
        </div>
 </div>

 <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
    <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_level'); ?></label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <select  class="selectpicker form-control"  tabindex="18"name="Level[]"  id="Level" multiple required>
                <option value=""><?= lang('am_select') ?></option>
    <?php 
    

    if ($row_level) {
        $grouped_levels = [];

        // Group by LevelId to ensure unique entries
        foreach ($row_level as $level) {
            $grouped_levels[$level->LevelId] = $level->LevelName;
        }

        // Render the dropdown options
        foreach ($grouped_levels as $level_id => $level_name) {
            ?>
            <option value="<?= htmlspecialchars($level_id) ?>">
                <?= htmlspecialchars($level_name) ?>
            </option>
            <?php
        }
    }
    ?>
</select>
        </div>
  </div>

  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
      <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('school'); ?></label>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
             <select  class="selectpicker form-control"  tabindex="18" name="school[]"  id="school" multiple required>
                <option value=""><?=lang('am_select')?></option>
                  <?php 
										if ($get_schools) {
											foreach ($get_schools as $school) {
										?>
                                            <option value="<?=$school->SchoolId?>"><?=$school->SchoolName?></option>
                                            <?php
											}
										}
										?>
                </select>
         </div>
 </div>
                

  <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <input type="submit" class="btn btn-success" onclick="return check_sub()" value="<?php echo lang('br_save'); ?>"/>
  </div>

 <div class="clearfix"></div>
 <div class="panel panel-danger">
     
     
<div class="panel-body no-padding">

<br/>

    <div class="clearfix"></div>

                    <?php if(is_array($GetAllrequest)){ ?>

                    <table class="table table-bordered table-striped" >

                    <thead>
                        <tr>
                            <th style="text-align: center !important;" >#</th>
                            <?php if($Type==2){ ?>
                            <th style="text-align: center !important;" ><?php echo lang('br_EmpType') ?></th>
                              <?php } ?>
                            <th style="text-align: center !important;" ><?php echo lang('br_Emp_2') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('class_type') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('school') ?></th>
                            <th style="text-align: center !important;"><?php echo lang('am_studeType') ?></th>
                             <th style="text-align: center !important;" ><?php echo lang('br_level') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_delete') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GetAllrequest as $Key=>$request ){
                            $Num		   = $Key+1 ;
                            $ID 	       = $request->ID ;
							$Name 	       = $request->Name ;
							$ContactName   = $request->ContactName ;
							$SchoolName    = $request->SchoolName ;
							$level_name    = $request->level_name;
							$Level_id      = $request->Level;
							$school_id     = $request->school_id;
							$EmpID         = $request->EmpID;
							$ClassType     = $request->ClassType;
                            $StudyType     = $request->StudyType;
							$level         = $this->db->query("SELECT Name FROM level WHERE ID IN ($Level_id) ")->result();
							$School        = $this->db->query("SELECT SchoolName FROM school_details WHERE ID IN ($school_id) ")->result();

                            ?>

                            <tr>
                                <td><?php echo $Num ; ?></td>
                                 <?php if($Type==2){ ?>
                                <td><?php echo $Name; ?></td>
                                <?php }?>
                                <td><?php echo $ContactName; ?></td>
                                <td> 
                                   <?php foreach($GetClassType as $Key=>$val)
                				     {
                					$ID   = $val->ClassTypeId ;
				                	$Name = $val->ClassTypeName ;
				                	$ClassType_array=explode("," ,$ClassType);
                                     if(in_array($ID,$ClassType_array)){ echo $Name.",";}} ?>
                                </td>
                                <?php if($Type==3||$Type==2){ ?>
                                <td>
                               <?php foreach ($School as $Key=>$sch ){ 
                                    echo $School_Name = $sch->SchoolName.",";
                               }
                               ?>
                                </td>
                                 <?php }?>
                                 <td> 
                                   <?php foreach($allStudeType as $Key=>$val)
                				     {
                					$ID   = $val->StudyTypeId ;
				                	$Name = $val->StudyTypeName ;
				                	$StudyType_array=explode("," ,$StudyType);
                                     if(in_array($ID,$StudyType_array)){ echo $Name.",";}} ?>
                                </td>
                               <td>
                               <?php foreach ($level as $Key=>$lev ){ 
                                    echo $level_Name = $lev->Name.",";
                               }
                               ?>
                                </td>
                           

                                <td>





                                    <a role="button" onClick="return check_del();" href="<?= site_url('admin/Report_Register/del_per_request/'.$Type.'/'.$ID.'/'.$EmpID) ?>" class="btn btn-danger btn-rounded" >

                                        <?php echo lang('br_delete') ?> <i class="fa fa-trash-o"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php

                        }

                        ?>

                        </tbody>

                    </table>

                </div>

            </div>



        <?php }else{ ?>
    <div class="alert alert-danger">
        <?php  echo lang('br_check_add'); ?>
    </div>
        

         <?php   }?>

        </div>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>



</div>
</form>
<script>

 function check_del()

 {

	 var msg = confirm("<?= lang("br_confirm"); ?>");

	 if(msg == true){return true ;}

	 else{return false ;}

 }

</script>