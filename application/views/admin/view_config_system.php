<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>

<script type="text/javascript" language="javascript" class="init">

    $(function () {

        $('#example').dataTable();

    });

</script>

 

<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">

        <?php

            if($this->session->flashdata('SuccessAdd')){echo  '<div class="alert alert-success">'. $this->session->flashdata('SuccessAdd').'</div>';}

            if($this->session->flashdata('ErrorAdd')){echo  '<div class="alert alert-error">'. $this->session->flashdata('ErrorAdd').'</div>';}

            ?>
    <form action="<?php echo site_url('admin/config_system/new_year') ?>" method="post">

            <div class="sec-title">

                <h2>تهيئة العام الجديد </h2>

            </div>

            <div class="clearfix"></div>

                 <div class="panel ">

                    <div class="panel-body">  

							<div class="form-group col-lg-5" style="margin:0px;">

							<label for="multiple-label-example"  class="label-control col-lg-2"><?php echo lang('br_from'); ?></label>

							<div class="col-lg-8">

							<input type="number" id="YearFrom"  name="YearFrom"  class="form-control" value="<?= $get_specific_year['YearFrom']; ?>" min="1"/>
							</div>


                    </div>

					<div class="panel-body">  

							<div class="form-group col-lg-5" style="margin:0px;">

							<label for="multiple-label-example"  class="label-control col-lg-2"><?php echo lang('br_to'); ?></label>

							<div class="col-lg-8">

							<input type="number" id="YearTo"  name="YearTo"  class="form-control" value="<?= $get_specific_year['YearTo']; ?>" min="1"/>
							</div>


                    </div>
					<br><br><br>
					<div class="panel-body">  

							<div class="form-group col-lg-5" style="margin:0px;">

							<label for="multiple-label-example"  class="label-control col-lg-2">السنة الهجربه</label>

							<div class="col-lg-8">

							<input type="text" id="year_name_hij"  name="year_name_hij"  class="form-control"  value="<?= $get_specific_year['year_name_hij']; ?>"/>
							<input type="hidden" id="ID"  name="ID"  class="form-control"  value="<?= $get_specific_year['ID']; ?>"/>
							</div>


                    </div>


                            <?php if($ID){?>

								<div class="form-group col-lg-2">      

								<input type="submit" class="btn btn-success" value="<?php echo lang('br_edit') ?>" />

							</div> 
							<?php }else{ ?>
							<div class="form-group col-lg-2">      

								<input type="submit" class="btn btn-success" value="<?php echo lang('br_save') ?>" />

							</div> 
                           <?php } ?>
							
 
							<div class="clearfix"></div>
							
							<div class="clearfix"></div>
							
							<br><br><br>

							<div class="form-group col-lg-12">
								<label class="control-label col-lg-1 padd_left_none padd_right_none"><?php echo lang('br_notes'); ?></label>
												<div class="col-lg-11">
													<p style="font-size: initial;color: red;">عند اضافة سنه جديده بيتم التعديل على السنه السابقه لتكون السنة الجديده هى السنه الحاليه</p>

							</div>
					</div>		  
                </div>   
            </div>

 </form>
 <div class="panel-body no-padding">

 

 <table class="display table table-bordered" width="100%" cellspacing="0" id="">

     <thead>

              <tr>

                  <th>السنة</th>
				  <th>السنة الهجرية</th>
				  <th>تعديل </th>
              </tr>

     </thead>

     <tbody>         

			  <?php

			  

			  foreach($get_year as $Key1=>$Row1)

			  {

				  $ID          = $Row1->ID ;

				  $year_name        = $Row1->year_name ;

				  $year_name_hij        = $Row1->year_name_hij ;

                  ?>

                     <tr>

                     <td><?php echo $year_name;?></td>
					 <td><?php echo $year_name_hij;?></td>
					 <td><a href="<?php echo base_url().'admin/config_system/index/'.$ID?>" >تعديل</a> </td>



                         

                    </tr>

				  <?php  

			  }

			 

			  ?>

       </tbody>       

			  </table>

