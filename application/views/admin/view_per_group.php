
<style type="text/css">

    .calendars-month table, .calendars-month table.display thead tr th

    {

        line-height:normal !important;

    }</style>

<script>

    function check_sub()

    {

        var Name = $("#Name").val();

        if(Name.split(" ").join("") == "" )

        {

            alert("<?= lang('br_error_permission') ?>");

            return false ;

        }

    }

   

</script>



<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">

            <div class="sec-title">

                <h2><?php echo lang('br_per_group'); ?></h2>

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

            <?php $per=check_group_permission_page(); 
            if($per['PermissionAdd']==1 || $per['PermissionEdit']==1){?>

            <form action="<?php echo site_url('admin/user_permission/edit_per_group/'.$GetID.'') ?>" method="post">

                

                <div class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-10">

      <label for="multiple-label-example " class="label-control col-lg-3"><?php echo lang('Add_group_name'); ?></label>

                    <div class="col-lg-5 col-md-10 col-sm-8 col-xs-8">

                        <input type="text" id="Name" class="form-control" name="Name" value="<?= $Name ?>"   />

                    </div>

                    <span class="col-lg-12"><?php echo form_error('DateFromH'); ?></span>

                </div>



                



                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2 text-right">

                    <input type="submit" class="btn btn-success" onclick="return check_sub()" value="<?php echo lang('br_save'); ?>"  />

                </div>

            </form>
           <?php } ?>


            <!----- Edit title -------->

            <div class="clearfix"></div>



            <div class="clearfix"></div>

            <div class="panel panel-danger">



                <div class="panel-body no-padding">



                    <?php if(is_array($GetAllPer)){ ?>

                    <table class="table table-bordered table-striped" >

                        <thead>

                        <tr>

                            <th style="text-align: center !important;" >#</th>

                            <th style="text-align: center !important;" ><?php echo lang('br_Name') ?></th>

                            <!-- <th style="text-align: center !important;" ><?php echo lang('br_btn_active') ?></th> -->
                            <?php if($per['PermissionEdit']==1){?>
                            <th style="text-align: center !important;" ><?php echo lang('br_edit') ?></th>
                            <?php } ?>
                            <?php if($per['PermissionDelete']==1){?>
                            <th style="text-align: center !important;" ><?php echo lang('br_delete') ?></th>
                            <?php } ?>
                            <?php if($per['PermissionAdd']==1){?>
                            <th style="text-align: center !important;" ><?php echo lang('br_add_emp_group') ?></th>
                            <?php } ?>
                            

                        </tr>

                        </thead>



                        <tbody>

                        <?php

                        foreach ($GetAllPer as $Key=>$row )

                        {

                            $Num		   = $Key+1 ;

                            $ID 	       = $row->ID ;

							$Name 	       = $row->Name ;

                            $IsActive 	   = $row->IsActive ;
                            
                            $allowDel 	   = $row->enable_delete ;

                            $IsActiveArray = array(1=>lang('br_active'),0=>lang('br_not_active'));

                            ?>

                            <tr>

                                <td><?php echo $Num ; ?></td>

                                <td>

                                    <?php echo $Name; ?>

                                </td>

                                

                                <!-- <td>

                                    <php echo $IsActiveArray[$IsActive]; ?>

                                </td> -->

                                <?php if($per['PermissionEdit']==1){?>

                                <td> <!-----EDIT----->
                                
                                <?php  
                                
                                if(($ID == 16 || $ID == 18 || $ID == 24 || $ID == 74 || $ID == 98)){ 
                                ?>
                                
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                    
                                    
                                <?php }else{  ?>
                                    <a role="button"  href="<?= site_url('admin/user_permission/per_group/'.$ID.'') ?>" class="btn btn-success btn-rounded" >

                                        <i class="fa fa-edit"></i>

                                    </a>
                                
                                <?php } ?>
                                
                                </td>
                                <?php } ?>
                                <?php if($per['PermissionDelete']==1){?>
                                <td>
                                    <?php  
                                    $query_member = $this->db->query("select * from contact where GroupID = ".$ID." ")->result();
                                if(($ID == 16 || $ID == 18 || $ID == 24 || $ID == 74 || $ID == 98)||!empty($query_member)){ 
                                ?>
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                    
                                    
                                <?php }else{  ?>
                                    <a role="button" onclick="return confirm('Are you sure to delete?')" href="<?= site_url('admin/user_permission/del_group/'.$ID.'') ?>" class="btn btn-danger btn-rounded" >

                                        <i class="fa fa-trash"></i>

                                    </a>
                                
                                <?php } ?>
                                </td>
                                 <?php } ?>
                                 <?php if($per['PermissionAdd']==1){?>
                                <td> 
                                    <a role="button"  href="<?= site_url('admin/user_permission/emp_group/'.$ID.'') ?>" class="btn btn-success btn-rounded" >

                                        <i class="fa fa-plus-circle"></i>

                                    </a>

                                </td>
                               <?php } ?>
                            </tr>

                        <?php

                        }

                        ?>

                        </tbody>

                    </table>

                </div>

            </div>



        <?php }else{echo lang('br_check_add');}?>

        </div>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>



</div>



<script type ="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
<script type="text/javascript">
            $(document).ready(function () {
                $('#DateFromH').datepicker({
                    format: "yyyy-mm-dd"
                });

                $(".datepicker").click(function() {
                    $('.datepicker').hide();
                });
				   $('#DateToH').datepicker({
                    format: "yyyy-mm-dd"
                });
            });
</script> 


