<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css"><script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script><script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script><script type="text/javascript" language="javascript" class="init">    $(function () {        $('#example').dataTable();    });</script> <div class="clearfix"></div><div class="content margin-top-none container-page">    <div class="col-lg-12">        <div class="block-st">        <?php            if($this->session->flashdata('SuccessAdd')){echo  '<div class="alert alert-success">'. $this->session->flashdata('SuccessAdd').'</div>';}            if($this->session->flashdata('ErrorAdd')){echo  '<div class="alert alert-error">'. $this->session->flashdata('ErrorAdd').'</div>';}            ?>    <form action="<?php echo site_url('admin/config_system/add_config_accounts_erp') ?>" method="post">            <div class="sec-title">                <h2><?=  lang("config_accounts"); ?> </h2>            </div>            <div class="clearfix"></div>                 <div class="panel ">                    <div class="panel-body">           <div class="form-group col-lg-5" style="margin:0px;">            <label for="multiple-label-example"  class="label-control col-lg-2"><?php echo lang('br_config'); ?></label>            <div class="col-lg-8">             <select  class="form-control selectpicker" name="confige"  id="confige" >                               <option value=""><?php echo lang('select');?></option>                   <option value="1" <?php if($confige == 1){echo 'selected';} ?>><?php echo lang('accounts');?></option>                            <option value="2" <?php if($confige == 2){echo 'selected';} ?>><?php echo lang('no_accounts');?></option>                         </select>			</div>          </div> <div class="form-group col-lg-2">            <input type="submit" class="btn btn-success" value="<?php echo lang('br_save') ?>" /> </div>   <div class="clearfix"></div>  <div class="clearfix"></div>  <br><br><br><div class="form-group col-lg-12">      <label class="control-label col-lg-1 padd_left_none padd_right_none"><?php echo lang('br_notes'); ?></label>                    <div class="col-lg-11">                        <p style="font-size: initial;color: red;"><?php echo lang('config_accounts_alert'); ?></p>                    </div>                </div>		  		                  </div>   	     </div>                          </form> 