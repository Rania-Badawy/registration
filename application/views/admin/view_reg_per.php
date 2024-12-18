

    <div class="clearfix"></div>

  <div class="content margin-top-none container-page">  

       <div class="col-lg-12">

 <div class="block-st">

 <div class="sec-title">

      <h2>  <?php echo lang( 'level_marketing'); ?></h2>

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









<style type="text/css" media="all">

/* fix rtl for demo */

.chosen-rtl .chosen-drop { left: -9000px; }

</style>

<form action="<?php echo site_url('admin/Report_Register/add_reg_per_level'); ?>" method="post" >

   <div class="form-group col-lg-5">

      <label class="control-label col-lg-3"><?php echo lang('br_Branche'); ?></label>

     <div class="col-lg-9">

<select data-placeholder="<?php echo lang('br_Branche'); ?>"  class="selectpicker form-control" tabindex="18" name="school_id[]" id="school_id" multiple>

                <!--<option value="0"></option>-->

                <?php

                if($get_school)

                {

                    foreach($get_school as $Key=>$school)

                    {

                        $ID = $school->SchoolId ;

                        $SchoolName  = $school->SchoolName ;

                        ?>

                        <option value="<?php echo $ID ; ?>"><?php echo $SchoolName ; ?></option>

                        <?php 

                    }

                }

                 ?>

          </select>     

     </div>

    </div>

    

<div class="form-group col-lg-5">

  <label class="control-label col-lg-3"><?php echo lang('br_level');?></label>

 <div class="col-lg-9">

  <select   class="form-control" data-live-search="true" tabindex="18" id="reg_level" name="reg_level">

        <option value="0"><?php echo lang('br_level'); ?></option>

        <?php

        if($get_level)

			{

				foreach($get_level as $Key=>$level)

				{


					$ID   = $level->LevelId;

					$Name = $level->LevelName;

					?>

					<option value="<?php echo $ID ; ?>"

                    ><?php echo $Name ; ?></option>

					<?php 

				  }

			   }

         ?>

    </select>

 </div>

</div>


<div class="form-group col-lg-5">

  <label class="control-label col-lg-3"><?php echo lang('am_percentage');?></label>

 <div class="col-lg-9">

<input class="form-control" type="number"  name="reg_percentage" min="0" max="100">

 </div>

</div>

          

 <div class="col-lg-2">                     



  <input type="submit" class="btn btn-success" value="<?php echo lang('br_save'); ?>" />  

   

</div>

 

        </form>





<div class="clearfix"></div>

<div id="result_table" >

            <div  class="panel panel-danger">


				<div class="panel-body no-padding">

                



	<table class="table table-bordered table-striped">

        <thead>

            <tr>

                <th><?php echo lang('br_Branche'); ?></th>

                <th><?php echo lang('br_level'); ?></th>

                <th><?php echo lang('am_percentage'); ?></th>
                
                <th><?php echo lang('am_delete'); ?></th>

            </tr>

        </thead>
        <?php 
        foreach($get_data as $value)
        {
            $ID               = $value->ID; 
            $school_id        = $value->school_id;
            $reg_level        = $value->reg_level;
            $reg_percentage   = $value->reg_percentage;
        ?>
        <tbody id="result_data">
            <tr>
                 <td>
                    <?php foreach ($get_school as $val) { if ($val->SchoolId == $school_id) { echo $val->SchoolName; } }?>

                </td>
                <td>
                    <?php foreach ($get_level as $val) { if ($val->LevelId == $reg_level) { echo $val->LevelName; } }?>

                </td>
                <td><?= "%" .$reg_percentage  ;?></td>
                <td><a class="btn btn-danger " href="<?= site_url('admin/Report_Register/delete_reg_per/'.$ID)?>" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a></td>
            </tr>

<?php } ?>
        </tbody>

    </table>

   </div>

   </div>

    

    

</div>

	



</div>

<div class="clearfix"></div>    

</div>

<div class="clearfix"></div>

</div>


