  	<div class="content margin-top-none container-page">  

       <div class="col-lg-12"> 

 <div class="block-st"> 

				<div class="sec-title">

				 <h2><?php echo lang('Create_request_status'); ?></h2>

				</div>
				  <div class="clearfix"></div>

        <!---------------------------------------------------------------------------------------------------------->

<br>
    <?php    extract($edit_Data) ; ?>
    
    <?php  if($record_id) { ?> 
     <form action="<?php echo site_url('admin/Report_Register/save_state/'.$record_id) ?>" method="post">
         <?php  } ?>
         
    
            <form action="<?php echo site_url('admin/Report_Register/save_state') ?>" method="post">

      <div class="block-st" >               

                <div style="display: flex;" class="form-group col-lg-5 col-md-6 col-sm-9 col-xs-10">

      <label class="control-label col-lg-2 col-md-2 col-sm-4 col-xs-4 " style="width: inherit;" ><?php echo lang('status_arabic'); ?></label>

                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">

                        <input type="text" onkeyup="checkLnag($(this), 'ar');" id="Name" class="form-control" name="Name"  value="<?php echo set_value('Name' , $Name ) ; ?>"   />

                    </div>

                   

                </div>


           <div style="display: flex;" class="form-group col-lg-5 col-md-6 col-sm-9 col-xs-10">

      <label class="control-label col-lg-2 col-md-2 col-sm-4 col-xs-4 " style="width: inherit;"><?php echo lang('status_english');  ?></label>

                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">

                        <input type="text" onkeyup="checkLnag($(this), 'en');" id="Name_en" class="form-control" name="Name_en"   value="<?php echo set_value('Name_en' , $Name_en ) ; ?>"  />

                    </div>

                   

                </div>
                



                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2 text-right">
                    <?php  if ($record_id) { ?>

                    <input type="submit" class="btn btn-success"  value="<?php echo lang('am_edit'); ?>"/>
                    <?php  }else {?>
                    
                    <input type="submit" class="btn btn-success"  value="<?php echo lang('br_save'); ?>"/>
                      <?php  } ?>
                </div>
                

            </form>



            <!----- Edit title -------->

            <div class="clearfix"></div>



            <div class="clearfix"></div>

            <div class="panel panel-danger">



                <div class="panel-body no-padding">



                   

                    <table class="table table-bordered table-striped" >

                        <thead>

                        <tr>

                            <th style="text-align: center !important;" >#</th>

                            <th style="text-align: center !important;" ><?php echo lang('br_Name') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('name_eng') ?></th>

                           

                            <th style="text-align: center !important;" ><?php echo lang('am_delete') ?></th>

                            <th style="text-align: center !important;" ><?php echo lang('br_edit') ?></th>

                        </tr>

                        </thead>



                        <tbody>

                        <?php

                        foreach ($typeData as $Key=>$row )

                        {

                            $Num		   = $Key+1 ;

                           

					    	$Name 	       = $row->Name ;

                          $Name_en 	       = $row->Name_en ;
             
                            

                            ?>

                            <tr>

                                <td> <?php echo $Num ?> </td>

                                <td>

                                   <?php echo $row->Name ?> 

                                </td>

                                <td>

                                   <?php echo $row->Name_en ?> 

                                </td>

                                


                                <td> 

                                    <a  class="btn btn-danger" href="<?php echo site_url("admin/Report_Register/delete_state/".$row->ID  ) ;?>"  onclick="return confirm('Are you sure to delete?')" ><?php echo lang('am_delete') ?>
                                    <i class="fa fa-trash"></i>
                                    </a>

                                </td>

                                <td> 

                                   <a  class="btn btn-primary" href="<?php echo site_url("admin/Report_Register/register_type/".$row->ID ) ;?>"   ><?php echo lang('am_edit') ?>
                                   <i class="fa fa-edit"></i>
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



        </div>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>



</div>
</div> 
<script type="text/javascript">
    function checkLnag(input, lang) {
        var userInput = input.val();
        
        if (lang == 'ar') {
            let regex = /^[؀-ۿ ]+$/;
            if (!userInput.match(regex)) {
               // alert("Only use Arabic characters!");
                input.val('');
            }
        } else {
            let regex = /[\u0600-\u06FF\u0750-\u077F^0-9]/;
            if (userInput.match(regex)) {
              //  alert("Only use English characters!");
                input.val('');
            }
        }
    }

</script>


