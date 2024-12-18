
<div class="content margin-top-none container-page">
    <div class="col-lg-12">


    <?php 
	if($get_employee)
	{
		extract($get_employee);
   ?>
        <form action="<?php echo site_url('admin/employee/edit_employee/'.$ConID.'') ?>" method="post">
            <div class="PersonalData">
                <div class="block-st">
                    <div class="sec-title">
                        <h2><?php echo $Name ; ?></h2>
                    </div>
                    
                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('br_Name'); ?> </label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="Name"
                                value="<?php echo  set_value('Name',$Name) ; ?>" required />
                        </div>
                        <div class="col-lg-9">
                            <span class="error span12"><?php echo form_error('Name') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('br_User_Name'); ?> </label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="User_Name"
                                value="<?php echo  set_value('User_Name',$User_Name) ; ?>"  minlength="4" maxlength="50" />
                        </div>
                        <div class="col-lg-9">
                            <span class="error span12"><?php echo form_error('User_Name') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('br_Password'); ?></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="password" name="Password" id="Password" value=""
                            minlength="4" maxlength="50" />
                        </div>
                    </div>
                    <input type="hidden" name="ConID" id="ConID" value="<?php echo $ConID ?>" />
                    <input type="hidden" name="OldPass" value="<?php echo $Password ?>" />

                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('br_NumberID'); ?></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="numberid" id="numberid" minlength="10"
                                maxlength="14" value="<?= set_value('numberid',$Number_ID) ;?>" />
                        </div>
                        <div class="col-lg-9">
                            <span class="error"><?php echo form_error('numberid') ?></span>
                        </div>
                    </div>
                    

                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('br_nationality'); ?></label>
                        <div class="col-lg-9">

                            <select class="form-control" id="nationality" name="nationality" required>

                                <option value=""><?php echo lang('br_nationality'); ?></option>
                                <?php
                    			  foreach ($Nationality as $Row)
                    			  {
                    				 $ID   = $Row->NationalityId ; 
                    				 $Name = $Row->NationalityName ;
                    				 ?>
                                <option value="<?php echo $ID ; ?>"
                                    <?php if($Nationality_ID == $ID ){echo "selected" ;} ?>><?php echo $Name ; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-9">
                            <span class="error"><?php echo form_error('br_nationality') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('am_mobile'); ?></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="am_mobile" id="am_mobile" minlength="9"
                                maxlength="12" value="<?= set_value('am_mobile',$Mobile) ;?>" />
                        </div>
                        <div class="col-lg-9">
                            <span class="error"><?php echo form_error('am_mobile') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label col-lg-3"><?php echo lang('br_Email'); ?></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="email" name="Email" id="Email" maxlength="50"
                                value="<?= set_value('Email',$Mail ) ;?>" />
                        </div>
                        <div class="col-lg-9">
                            <span class="error"><?php echo form_error('am_mobile') ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php 
                        if($Getupdate){
                        $last_update= date('Y-m-d H:i:s',strtotime($Getupdate['last_update']));
                    ?>
                    <div class="form-group col-lg-6">

                        <label class="label-control col-lg-3"> <?php echo lang('Who_modified'); ?> </label>

                        <div class="col-lg-9 text-right">
                            <input class="form-control" type="text" readonly name="UserNam" id="UserNam"
                                value="<?php echo $Getupdate['Name']?>" />

                        </div>

                        <div class="col-lg-9">

                            <span class="error"><?php echo form_error('UserNam') ?></span>

                        </div>

                    </div>

                    <div class="form-group col-lg-6">

                        <label class="label-control col-lg-3"><?php echo lang('ra_update_date'); ?> </label>

                        <div class="col-lg-9 text-right">
                            <input class="form-control" type="text" readonly name="last_update" id="last_update"
                                value="<?php echo $last_update?>" />

                        </div>

                        <div class="col-lg-9">

                            <span class="error"><?php echo form_error('last_update') ?></span>

                        </div>

                    </div>
                    <?php } ?>
                      

                    <div class="form-group col-lg-12">
                        <input type="submit" class="btn btn-success pull-left" value="<?php echo lang('br_save') ?>" />
                    </div>
        
                   </form>
                    <div class="clearfix"></div>
                </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
<?php
}else{echo '<div class="alert alert-error">'.lang('br_check_add').'</div>';}
?>
