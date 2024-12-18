	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>
	<script type="text/javascript" language="javascript" class="init">
    $(function () {
    $('#example').dataTable();
    });
	
    </script>
    
  </script>
 <script type ="text/javascript" src="<?=base_url()?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>datepicker/css/datepicker.css" type="text/css" />
<script type="text/javascript">
    $(document).ready(function () {
        $('.txt_Date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
        });
    });
</script>
<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">

            <div class="sec-title">

                <h2> <?php echo lang('Test_date_report') ?>  </h2>
               <a href="<?php echo site_url('admin/Report_Register'); ?>" class="btn btn-success pull-left" role="button"> <?php echo lang('er_Return') ?>   </a>

            </div>

            <form  action="<?php echo site_url('admin/Report_Register/add_register_date/'.$reg_id.''); ?>" method="post">

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
                
                <div class="form-group col-lg-5">

                    <label class="control-label col-lg-3"><?php echo lang('br_date') ?></label>

                        <div class="col-lg-9">

                             <input type="text" name="txt_Date" id="txt_Date" class="form-control txt_Date"  value="<?= (isset($date)) ? $date : '' ?>" required >

                        </div>

                </div>
                 <div class="form-group col-lg-5">

                    <label class="control-label col-lg-3"><?php echo lang('attend') ?></label>

                        <div class="col-lg-9">

                             <select id="absence"  name="absence" class="form-control">
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                    <option value="1"><?php echo lang('attend') ?>  </option>
                    <option value="2"><?php echo lang('br_abcent_day') ?>  </option>
                </select>

                        </div>

                </div>
 <div class="form-group col-lg-5">

                    <label class="control-label col-lg-3"><?php echo lang('am_notes') ?></label>

                        <div class="col-lg-9">

                             <input type="text" name="note" id="note" class="form-control "  value="" >

                        </div>

                </div>
               

                <div class="col-lg-2">

                    <input type="submit" class="btn btn-success" onclick="return check_sub();" value="<?php echo lang('br_save') ?>" >

                </div>







                <div class="clearfix"></div>

                <div id="result_data"></div>



            </form>

        </div>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>

</div>
 
            <div class="clearfix"></div>
            <div class="panel panel-danger">

                <div class="panel-body no-padding">

                   
                    <table id="example" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th style="text-align: center !important;" >#</th>
                           
                          
                            <th style="text-align: center !important;" ><?php echo lang('interview_date') ?> </th>
                            <th style="text-align: center !important;" ><?php echo lang('attend') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('am_notes') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_edit') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_delete') ?></th>
                           
                            
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($getdate as $Key=>$StudentR )
                        {
                            $Num		   = $Key+1 ;
							$id 	       = $StudentR->ID ;
                            $Date 	       = $StudentR->Date ;
                            $Absence       = $StudentR->Absence  ;
                            $note          = $StudentR->note   ;
                            $reg_id        = $StudentR->reg_id   ;
                          
                            ?>
                            <tr>
                                <td><?php echo $Num ; ?></td>
                                 <td>
                                     <?php echo $Date; ?>
                                    <!--<a class="form-control "  value="<?php echo $Date ?>" readonly ><?php echo $Date ?></a>-->
                                </td>
                                <td>
                                    <?php 
                                    if ($Absence==1)
                                    {
                                     echo lang('attend') ;} elseif($Absence==2){echo lang('br_abcent_day') ; }else { echo "";}?>
                                </td>
                                 <td>
                                    <?php echo $note; ?>
                                </td>
                               <td>
                    <button type="button" class="allowedAddedButton btn btn-info btn-rounded" data-toggle="modal" data-target="#view-rating-<?= $id ?><?= $reg_id ?>"><?php echo lang('br_edit'); ?></button>
                               </td>
                               <td>
                                    <a role="button" onClick="return check_del();" href="<?= site_url('admin/Report_Register/delete_register_date/'.$id."/".$reg_id) ?>" class="btn btn-danger btn-rounded" >

                                        <?php echo lang('br_delete') ?> <i class="fa fa-trash-o"></i>

                                    </a>
                               </td>

                                
                            </tr>
                            
                            <div id="view-rating-<?= $id ?><?= $reg_id ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">   <?php echo lang('br_edit'); ?>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" rtl>×</button>
                                                    </h4>
                                                    
                                                </div>
                                                <form action="<?php echo site_url('admin/Report_Register/edit_register_date')?>" method="post" >
                                                <input type="hidden" name="iddd" id="iddd"   value="<?php echo $id?>" >
                                                      <input type="hidden" name="reg_idddd" id="reg_idddd"   value="<?php echo $reg_id?>" >
                                                   
                                                  <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                  <div class="form-group col-lg-12">

                                                       <label class="control-label col-lg-3"><?php echo lang('br_date'); ?></label>

                                                     <div class="col-lg-9">

                                                           <input type="date" name="test_date" id="test_date" class="form-control "  value="<?php echo $Date ?>" >

                                                       </div>
                                                        <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                   <div class="clearfix"></div>
                                                    <div class="clearfix"></div>
                                                  <div class="form-group col-lg-12">

                                                       <label class="control-label col-lg-3"><?php echo lang('attend'); ?></label>

                                                     <div class="col-lg-9">

                                                           <select id="absence_edit"  name="absence_edit" class="form-control">
                                                                <option value=""><?php echo lang('am_choose_select'); ?></option>
                                                                <option value="1"><?php echo lang('attend') ?>  </option>
                                                                <option value="2"><?php echo lang('br_abcent_day') ?>  </option>
                                                            </select>

                                                       </div>
                                                       </div>
                                                        <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                  <div class="form-group col-lg-12">

                                                       <label class="control-label col-lg-3"><?php echo lang('am_notes'); ?></label>

                                                     <div class="col-lg-9">

                                                           <input type="text" name="note_edit" id="note_edit" class="form-control "  value="<?= $note;?>" >

                                                       </div>

                                                  </div>

                                                  </div>
                                                  <div class="clearfix"></div>
                                                  <div class="clearfix"></div>
                                                   <div class="col-lg-2">

                                                      <input type="submit" class="btn btn-success"  value="<?php echo lang('br_save') ?>" >
                                                     
                                                     

                                                     </div>
                                                    <div class="modal-footer noborder" >
                                                        <!--<button type="button" class="col-lg-2 text-right" class="btn btn-danger" data-dismiss="modal"><?php echo lang('cancel')  ?></button>-->
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                        <?php
                        }
                        ?>
                        
                        </tbody>
                    </table>
                </div>
            </div>
           

        