<style type="text/css">
.red {
    color: #F00;
}
</style>

<script type="text/javascript">
/////////////////////////////////////////////////////////////////////////////////////////////////////
function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 9) {
        return true;
    } else if (key == 46) {
        return true;
    } else if (key < 48 || key > 57) {
        return false;
    } else return true;
};
////////////////////////////////////////////////////////////////////////////
</script>
<div class="clearfix"></div>
<div class="content margin-top-none container-page">

    <div class="col-lg-12">
        <div class="block-st">
            <form action="<?php echo site_url('admin/employee/add_employee') ?>" method="post">
                <div class="sec-title">
                    <h2><?php echo lang( 'br_add_employee'); ?> </h2>
                </div>

                <div class="PersonalData">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_Name'); ?>
                            : <span class="red">*</span></label>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <input class="form-control" type="text" name="Name" id="Name"
                                value="<?php echo set_value('Name'); ?>" />
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <span class="error"><?php echo form_error('Name') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label
                            class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_nationality'); ?>
                            : <span class="red">*</span> </label>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <select class="form-control selectpicker" id="nationality" name="nationality">

                                <option value=""><?php echo lang('br_nationality'); ?></option>
                                <?php
                    			  foreach ($Nationality as $Row)
                    			  {
                    				 $ID   = $Row->NationalityId ; 
                    				 $Name = $Row->NationalityName ;
                    				 ?>
                                <option value="<?php echo $ID; ?>" <?php echo set_select('nationality', $ID); ?>>
                                    <?php echo $Name; ?></option>
                                <?php 
                    			  }
                    			   ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <span class="error"><?php echo form_error('nationality') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label
                            class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_NumberID'); ?>
                            : <span class="red">*</span></label>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <input class="form-control" type="text" name="numberid" minlength="10" maxlength="14"
                                id="Name" value="<?php echo set_value('numberid'); ?>" />
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <span class="error"><?php echo form_error('numberid') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label
                            class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_Mobile'); ?> :
                            <span class="red"></span></label>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <input class="form-control" onkeypress=" return validateNumber(event);" type="text"
                                minlength="9" maxlength="12" name="Mobile" id="Mobile"
                                value="<?php echo set_value('Mobile'); ?>" />
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <span class="error span12"><?php echo form_error('Mobile') ?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_Email'); ?>
                        </label>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <input class="form-control" type="email" maxlength="50" name="Email" id="Email"
                                value="<?php echo set_value('Email'); ?>" />
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                            <span class="error span12"><?php echo form_error('Email') ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
        </div>

        <div class="block-st">
            <div class="sec-title">
                <h2><?php echo lang('br_LoginData'); ?></h2>
            </div>
            <div class="form-group col-lg-12 col-md-6 col-sm-12 col-xs-12">
                <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_User_Name'); ?> :
                    <span class="red">*</span></label>
                <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" name="UserName" class="form-control" id="UserName" autocomplete="new-password"
                        value="<?php echo  set_value('UserName');?>" minlength="4" maxlength="50" />
                </div>
                <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                    <span class="error span12"><?php echo form_error('UserName') ?></span>
                </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo lang('br_Password'); ?> :
                    <span class="red">*</span></label>
                <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                    <input class="form-control" type="password" name="Password" id="Password" autocomplete="new-password"
                        value="<?php echo  set_value('Password');?>"  minlength="4" maxlength="50" />
                </div>
                <div class="col-lg-3 col-md-8 col-sm-8 col-xs-8">
                    <span class="error"><?php echo form_error('Password') ?></span>
                </div>
            </div>
            
            <div class="form-group text-left col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="submit" class="btn btn-success pull-left" value="<?php echo lang('br_save') ?>" />
            </div>
            <div class="clearfix"></div>
            </form>

        </div>
        
    </div>
</div>