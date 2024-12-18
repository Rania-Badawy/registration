
<div class="content margin-top-none container-page">
	<div class="col-lg-12">
		<div class="block-st">
			<div class="sec-title">
				<h2><?php echo lang('Preparing_admission') ?> </h2>
			</div>
			
			<div class="clearfix"></div>
			
			<form action="<?php echo site_url('/admin/Report_Register/edit_reg_type') ?>" method="post">
			    <!-- <div class="form-group col-lg-6">-->
			    <!--    <label class="control-label col-lg-2" >فى الحسابات</label>-->
			    <!--    <div class="col-lg-10">-->
			    <!--        <select name="IN_ERP" id="IN_ERP" class="form-control selectpicker bs-select-hidden">-->
			    <!--            <option value=""><?php echo lang('am_choose_select'); ?></option>-->
			    <!--            <option value="1"> <?php echo lang('yes') ;?></option>-->
			    <!--            <option value="2"> <?php echo lang('no') ;?> </option>-->
			    <!--        </select>-->
			    <!--    </div>-->
			    <!--</div>-->
			    <div class="form-group col-lg-3">
			        <label class="control-label col-lg-2" ><?php echo lang('type') ?></label>
			        <div class="col-lg-10">
			            <select name="reg_type" id="reg_type" class="form-control selectpicker bs-select-hidden">
			                <option value=""><?php echo lang('am_choose_select'); ?></option>
			                <option value="1"> <?php echo lang('am_admission') ?></option>
			                <option value="2"><?php echo lang('am_admission_markting')?></option>
			            </select>
			        </div>
			    </div>
			   <div id="show">
			    <div class="form-group col-lg-6">
			        <label class="control-label col-lg-2" ><?php echo lang('accpet_type') ?></label>
			        <div class="col-lg-10">
			            <select name="accpet_reg_type" id="accpet_reg_type" class="form-control selectpicker bs-select-hidden">
			                <option value=""><?php echo lang('am_choose_select'); ?></option>
			                <option value="1"><?php echo lang('direct_accpet') ?></option>
			                <option value="2"><?php echo lang('academy_accpet') ?></option>
			                <option value="3"><?php echo lang('only_academy_accpet') ?></option>
			            </select>
			        </div>
			    </div>
			   </div>

			   <div id="show2">
			    <div class="form-group col-lg-6">
			        <label class="control-label col-lg-6" ><?php echo lang('br_smsTestDirect') ?></label>
			        <div class="col-lg-4">
			           <input type="checkbox" name="smsTestDirect" value="1" <?php if($get_type[0]->smsTestDirect==1){echo checked ;} ?>>
			        </div>
			    </div>
			   </div>
			    <div class="col-lg-2 text-right">
			        <input type="submit" class="btn btn-success" onclick="return check_type()" value="<?php echo lang('br_save') ?>"/>
			    </div>
            </form>

			
			
			<div class="clearfix"></div>
			
			
			<table class="table table-striped table-bordered dataTable no-footer">
			    <thead>
			        <tr>
			            <td>#</td>
			            <td><?php echo lang('am_type');?></td>
			            <?php if($get_type[0]->accpet_reg_type){ ?>
			            <td><?php echo lang('accpet_type') ?></td>
			            <?php } ?>
			        </tr>
			    </thead>
			    <tbody>
			        <?php
			    
			            $Num		 	     = $Key+1 ;
			            $schoolId            = $get_type[0]->ID;
			            $Name        	     = $get_type[0]->SchoolName ;
			            $reg_type		     = $get_type[0]->reg_type;
			            $accpet_reg_type	 = $get_type[0]->accpet_reg_type;
			            $IN_ERP	             = $get_type[0]->IN_ERP;
			         ?>
			        <tr>
			            <td><?php echo $Num ; ?></td>
			           
			            
			            <td>
			                <?php if($reg_type == 1){ echo lang('am_admission'); }else{echo lang('am_admission_markting');} ?>
			            </td>
			            <?php if($accpet_reg_type){ ?>
			            <td>
			                <?php if($accpet_reg_type == 1){ echo lang('direct_accpet'); }elseif($accpet_reg_type == 2){echo lang('academy_accpet');}else{echo lang('only_academy_accpet');} ?>
			            </td>
			            <?php } ?>
			        </tr>
			       
			    </tbody>
			</table>
		</div>
	</div>
</div>	
<script>
   $(document).ready(function() {
    document.getElementById("show").style.display = "none";
	document.getElementById("show2").style.display = "none";
   });
   $('select[name^="reg_type"]').on('change', function() {
    var reg_type = $('#reg_type').val();
    if(reg_type == 1){
        document.getElementById("show").style.display = "block";
		document.getElementById("show2").style.display = "none";
    }
    if(reg_type == 2){
        document.getElementById("show").style.display = "none";
		document.getElementById("show2").style.display = "block";
    }
   });
</script>