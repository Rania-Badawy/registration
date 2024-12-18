<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/register_style.css" />

<div class="block-st">
    <div class="sec-title">
        <h2><?php echo lang('br_Preparing_registration_form'); ?></h2>
    </div>

    <?php if ($this->session->flashdata('Sucsess')) { ?>
        <div class="widget-content">
            <div class="widget-box">
                <div class="alert alert-success fade in">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $this->session->flashdata('Sucsess'); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php $per = check_group_permission_page(); ?>
    <div class="clearfix"></div>

    <div class="panel panel-danger">
        <div class="panel-body no-padding">
            <div class="col-xs-12 title_register">
                <h5><i class="fa fa-home" aria-hidden="true"></i><?= lang('am_basic_data') ?></h5>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>

                        <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($form_main as $Key => $Row) {
                        $Num = $Key + 1;

                        $settingID  = $Row->ID;

                        $inputName    = $Row->input_id;

                        $display    = $Row->display;

                        $required    = $Row->required;

                        $disabled   = $Row->Edit;
                    ?>

                        <tr>
                            <td style="width: 5%;"><?php echo $Num; ?></td>

                            <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                            <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                            <td>
                                <?php if ($display == 0) { ?>
                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/activateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-success btn-rounded">
                                        <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                    </a>
                                <?php } else { ?>
                                    
                                    <a href="<?php if ($per['PermissionEdit'] == 1 ) {
                                        
                                                    echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-danger btn-rounded">
                                        <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                    </a>

                                <?php } ?>
                            </td>

                            <td>
                                <input type="checkbox" <?php if ($required == 1) {
                                                            echo 'checked';
                                                        } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                }
                                                                                                                                                                if ($display == 0) {
                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                }
                                                                                                                                                                echo $disabled; ?>>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-body no-padding">
            <div class="col-xs-12 title_register">
                <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_father_data') ?></h5>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>

                        <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($form_father as $Key => $Row) {
                        $Num = $Key + 1;

                        $settingID  = $Row->ID;

                        $inputName    = $Row->input_id;

                        $display    = $Row->display;

                        $required    = $Row->required;

                        $disabled   = $Row->Edit;
                    ?>

                        <tr>
                            <td style="width: 5%;"><?php echo $Num; ?></td>

                            <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                            <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                            <td>
                                <?php if ($display == 0) { ?>
                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/activateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-success btn-rounded">
                                        <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                    </a>
                                <?php } else { ?>

                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-danger btn-rounded">
                                        <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                    </a>

                                <?php } ?>
                            </td>

                            <td>
                                <input type="checkbox" <?php if ($required == 1) {
                                                            echo 'checked';
                                                        } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                }
                                                                                                                                                                if ($display == 0) {
                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                }
                                                                                                                                                                echo $disabled; ?>>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-body no-padding">
            <div class="col-xs-12 title_register mt-20">
                <h5><i class="fa fa-female" aria-hidden="true"></i><?= lang('am_mother_data') ?></h5>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>

                        <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($form_mother as $Key => $Row) {
                        $Num = $Key + 1;

                        $settingID  = $Row->ID;

                        $inputName    = $Row->input_id;

                        $display    = $Row->display;

                        $required    = $Row->required;

                        $disabled   = $Row->Edit;
                    ?>

                        <tr>
                            <td style="width: 5%;"><?php echo $Num; ?></td>

                            <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                            <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                            <td>
                                <?php if ($display == 0) { ?>
                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/activateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-success btn-rounded">
                                        <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                    </a>
                                <?php } else { ?>

                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-danger btn-rounded">
                                        <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                    </a>

                                <?php } ?>
                            </td>

                            <td>
                                <input type="checkbox" <?php if ($required == 1) {
                                                            echo 'checked';
                                                        } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                }
                                                                                                                                                                if ($display == 0) {
                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                }
                                                                                                                                                                echo $disabled; ?>>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-body no-padding">
            <div class="col-xs-12 title_register mt-20">
                <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_student_data') ?></h5>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>

                        <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($form_student as $Key => $Row) {
                        $Num = $Key + 1;

                        $settingID  = $Row->ID;

                        $inputName    = $Row->input_id;

                        $display    = $Row->display;

                        $required    = $Row->required;

                        $disabled   = $Row->Edit;
                    ?>

                        <tr>
                            <td style="width: 5%;"><?php echo $Num; ?></td>

                            <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                            <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                            <td>
                                <?php if ($display == 0) { ?>
                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/activateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-success btn-rounded">
                                        <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                    </a>
                                <?php } else { ?>

                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-danger btn-rounded">
                                        <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                    </a>

                                <?php } ?>
                            </td>

                            <td>

                                <?php if ($inputName != 'birthday_hijry') { ?>
                                    <input type="checkbox" <?php if ($required == 1) {
                                                                echo 'checked';
                                                            } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    if ($display == 0) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    echo $disabled; ?>>
                                <?php } ?>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE form_type = 1")->result(); ?>
        <?php if ($setting[43]->display == 1) { ?>
            <div class="panel-body no-padding">
                <div class="col-xs-12 title_register mt-20">
                    <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_student_psyy') ?></h5>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>

                            <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                            <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                            <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($form_psy as $Key => $Row) {
                            $Num = $Key + 1;

                            $settingID  = $Row->ID;

                            $inputName    = $Row->input_id;

                            $display    = $Row->display;

                            $required    = $Row->required;

                            $disabled   = $Row->Edit;
                        ?>

                            <tr>
                                <td style="width: 5%;"><?php echo $Num; ?></td>

                                <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                                <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                                <td>
                                    <?php if ($display == 0) { ?>
                                        <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                        echo site_url('admin/config_system/activateInput/' . $settingID);
                                                    } else {
                                                        echo '#';
                                                    } ?>" class="btn btn-success btn-rounded">
                                            <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                        </a>
                                    <?php } else { ?>

                                        <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                        echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                    } else {
                                                        echo '#';
                                                    } ?>" class="btn btn-danger btn-rounded">
                                            <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                        </a>

                                    <?php } ?>
                                </td>

                                <td>

                                    <input type="checkbox" <?php if ($required == 1) {
                                                                echo 'checked';
                                                            } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    if ($display == 0) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    echo $disabled; ?>>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="panel-body no-padding">
                <div class="col-xs-12 title_register mt-20">
                    <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_student_psyyy') ?></h5>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>

                            <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                            <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                            <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($form_medical as $Key => $Row) {
                            $Num = $Key + 1;

                            $settingID  = $Row->ID;

                            $inputName    = $Row->input_id;

                            $display    = $Row->display;

                            $required    = $Row->required;

                            $disabled   = $Row->Edit;
                        ?>

                            <tr>
                                <td style="width: 5%;"><?php echo $Num; ?></td>

                                <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                                <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                                <td>
                                    <?php if ($display == 0) { ?>
                                        <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                        echo site_url('admin/config_system/activateInput/' . $settingID);
                                                    } else {
                                                        echo '#';
                                                    } ?>" class="btn btn-success btn-rounded">
                                            <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                        </a>
                                    <?php } else { ?>

                                        <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                        echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                    } else {
                                                        echo '#';
                                                    } ?>" class="btn btn-danger btn-rounded">
                                            <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                        </a>

                                    <?php } ?>
                                </td>

                                <td>

                                    <input type="checkbox" <?php if ($required == 1) {
                                                                echo 'checked';
                                                            } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    if ($display == 0) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    echo $disabled; ?>>

                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <div class="panel-body no-padding">
            <div class="col-xs-12 title_register mt-20">
                <h5><i class="fa fa-database" aria-hidden="true"></i><?= lang('am_general_data') ?></h5>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>

                        <th style="text-align: center !important;"><?php echo lang('am_name'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('am_view'); ?></th>

                        <th style="text-align: center !important;"><?php echo lang('is_required'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($form_public as $Key => $Row) {
                        $Num = $Key + 1;

                        $settingID  = $Row->ID;

                        $inputName    = $Row->input_id;

                        $display    = $Row->display;

                        $required    = $Row->required;

                        $disabled   = $Row->Edit;
                    ?>

                        <tr>
                            <td style="width: 5%;"><?php echo $Num; ?></td>

                            <td style="width: 30%;"><?php echo lang($inputName) ?></td>

                            <input type="hidden" name="ID<?php echo $Num; ?>" id="ID<?php echo $Num; ?>" value="<?php echo $settingID; ?>" />

                            <td>
                                <?php if ($display == 0) { ?>
                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/activateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-success btn-rounded">
                                        <i class="fa fa-unlock"></i> <?php echo lang('br_btn_active'); ?>
                                    </a>
                                <?php } else { ?>

                                    <a href="<?php if ($per['PermissionEdit'] == 1) {
                                                    echo site_url('admin/config_system/deActivateInput/' . $settingID);
                                                } else {
                                                    echo '#';
                                                } ?>" class="btn btn-danger btn-rounded">
                                        <i class="fa fa-lock"></i> <?php echo lang('br_btn_not_active'); ?>
                                    </a>

                                <?php } ?>
                            </td>
                            <td>


                                <?php if ($inputName != 'am_student_psy') { ?>
                                    <input type="checkbox" <?php if ($required == 1) {
                                                                echo 'checked';
                                                            } ?> onChange="active_input_required('<?= $settingID ?>');" style="display:inline-block !important;" <?php if ($per['PermissionEdit'] != 1) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    if ($display == 0) {
                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                    }
                                                                                                                                                                    echo $disabled; ?>>
                                <?php } ?>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function active_input_required(settingID)

    {
        var data = {
            settingID: settingID
        };

        var url = "<?php echo site_url('admin/config_system/active_input_required') ?>";

        $.ajax({

            type: "POST",

            url: url,

            data: data,

            cache: false,

            beforeSend: function() {},

            success: function(html)

            {



                //// end success

            },
            error: function(jqXHR, exception) {

                alert('Not connect.\n Verify Network.');

            }

        }); /////END AJAX

    }
</script>