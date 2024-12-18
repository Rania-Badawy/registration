<script type="text/javascript">
function get_group_data(GroupID)

{

    window.location = "<?= site_url("admin/user_permission/group_page"); ?>/" + GroupID;

}
</script>
<?php $per=check_group_permission_page(); ?>
<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">

            <div class="sec-title">

                <h2><?php echo lang('br_permission_add'); ?></h2>

            </div>

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

            <form action="<?php echo site_url('admin/user_permission/add_group_page/'.$GroupID.''); ?>" method="post">

                <div class="form-group col-lg-6 col-xs-12 ">

                    <label for="multiple-label-example "
                        class="label-control col-lg-2 col-md-4 col-sm-4 col-xs-4 "><?php echo lang('br_group'); ?></label>

                    <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8">

                        <select data-placeholder="<?php echo lang('br_group'); ?>"
                            onchange="get_group_data(this.value);" class="form-control" data-live-search="true"
                            tabindex="18" name="GetGroup" id="GetGroup">

                            <option value="0"><?php echo lang('br_group'); ?></option>

                            <?php

			if($GetGroup)

			{

				foreach($GetGroup as $Key=>$Group)

				{

					$ID   = $Group->ID ;

					$Name = $Group->Name ;

					?>

                            <option value="<?php echo $ID ; ?>" <?php if($GroupID == $ID ){echo "selected" ;} ?>>
                                <?php echo $Name ; ?></option>

                            <?php 

				}

			}
			 ?>

                        </select>

                    </div>

                    <?php if($GroupID !=0)

			{

				?>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">

                        <input type="button" class="btn btn-success" value="<?= lang("br_per_copy"); ?>"
                            onClick="open_modal();" />

                    </div>

                    <?php

			} ?>

                    <script type="text/javascript">
                    function open_modal()

                    {

                        var GetGroup = $("#GetGroup").val();

                        $('#smallModal').modal('show');



                    }
                    </script>

                    <div class="modal modal_st fade" id="smallModal" tabindex="-1" role="dialog"
                        aria-labelledby="smallModal" aria-hidden="true">

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>

                                    <h4 class="modal-title" id="myModalLabel"><?= lang("br_per_copy"); ?></h4>

                                </div>

                                <div class="modal-body">

                                    <div class="form-group col-lg-12">

                                        <label for="multiple-label-example "
                                            class="label-control col-lg-2"><?php echo lang('br_group'); ?></label>

                                        <div class="col-lg-8">

                                            <select data-placeholder="<?php echo lang('br_group'); ?>"
                                                class="form-control selectpicker" data-live-search="true" tabindex="18"
                                                name="NewGroup" id="NewGroup">

                                                < <?php

			if($GetGroup)

			{

				foreach($GetGroup as $Key=>$Group)

				{

						

						$ID   = $Group->ID ;

						$Name = $Group->Name ;

						if($GroupID != $ID )

						{

						?> <option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>

                                                    <?php 

					}

				}

			}

			

			 ?>

                                            </select>

                                        </div>

                                        <div class="col-lg-2">

                                            <input type="button" class="btn btn-success"
                                                value="<?php echo lang('br_save'); ?>"
                                                onclick="return add_New_Per();" />

                                        </div>

                                        <script type="text/javascript">
                                        function add_New_Per()

                                        {

                                            window.location =
                                                "<?= site_url("admin/user_permission/copy_group_page"); ?>/" + $(
                                                    "#GetGroup").val() + "/" + $("#NewGroup").val();



                                        }
                                        </script>



                                    </div>

                                </div>
                                <div class="clearfix"></div>




                            </div>

                        </div>

                    </div>

                </div>

                <?php

		if($GroupID  != 0 )

		  {

          ?>

                <!--<div class="form-group col-lg-6 col-xs-12 ">-->

                <!--  <label for="multiple-label-example " class="label-control col-lg-12">-->
                <!--  <input style="display:inline-block!important" type="checkbox" name="IsAdmin" value="1" <?php if($CheckGroup['IsAdmin'] == 1 ){echo 'checked' ;} ?>/> -->
                <!--  <?php echo lang('br_check_admin'); ?> </label>-->


                <!--</div>-->

                <?php } ?>
                <div class="clearfix"></div>

                <?php

		if($GroupID  != 0 )

		  {

		  if($get_page)

		  {

			  ?>
                <div class="panel panel-danger">

                    <div class="panel-body no-padding">

                        <div class="form-group col-lg-6 col-xs-12 ">

                            <!--<label for="multiple-label-example " class="label-control col-lg-12"> <input type="checkbox" id="check_all" style="display:inline-block!important" /> <?php echo lang('br_check_all'); ?></label>-->

                            <script type="text/javascript">
                            $(document).ready(function() {



                                $("#check_all").on("click", function() {

                                    $('.check_add').prop("checked", $(this).prop("checked"));

                                    $('.check_edit').prop("checked", $(this).prop("checked"));

                                    $('.check_delete').prop("checked", $(this).prop("checked"));

                                    $('.check_view').prop("checked", $(this).prop("checked"));



                                    $('#check_all_add').prop("checked", $(this).prop("checked"));

                                    $('#check_all_edit').prop("checked", $(this).prop("checked"));

                                    $('#check_all_del').prop("checked", $(this).prop("checked"));

                                    $('#check_all_view').prop("checked", $(this).prop("checked"));

                                });

                                $("#check_all_add").on("click", function() {

                                    $('.check_add').prop("checked", $(this).prop("checked"));

                                });



                                $("#check_all_edit").on("click", function() {

                                    $('.check_edit').prop("checked", $(this).prop("checked"));

                                });



                                $("#check_all_del").on("click", function() {

                                    $('.check_delete').prop("checked", $(this).prop("checked"));

                                });



                                $("#check_all_view").on("click", function() {

                                    $('.check_view').prop("checked", $(this).prop("checked"));

                                });





                            });
                            </script>


                        </div>



                        <table class="table table-striped table-bordered tb-group">

                            <thead>

                                <tr>

                                    <th><?php echo lang('br_page_name'); ?></th>

                                    <th><?php echo lang('br_check_all'); ?><input style="display:inline-block!important"
                                            type="checkbox" id="check_all" /></th>

                                    <th><?php echo lang('br_page_add'); ?><input type="checkbox" id="check_all_add" />
                                    </th>

                                    <th><?php echo lang('br_page_edit'); ?><input type="checkbox" id="check_all_edit" />
                                    </th>

                                    <th><?php echo lang('br_page_delete'); ?><input type="checkbox"
                                            id="check_all_del" /></th>

                                    <th><?php echo lang('br_page_view'); ?><input type="checkbox" id="check_all_view" />
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
              $query_sidebar = $this->db->query("SELECT permission_page.CatName ,permission_page.CatNum , permission_page.Icon
                                    FROM permission_page
                                    where IsActive=1 and active_system=1
                                	GROUP BY permission_page.CatNum ORDER BY permission_page.CatNum ASC
                                    ")->result();
			   foreach($query_sidebar as $Key=>$Cat)
					  {?>

                                <tr>
                                    <td style="color:red"><?php echo lang($Cat->CatName) ?></td>
                                </tr>
                                <?php   foreach($get_page as $KeyPage=>$RowGetPage)
			  {
			      $query    = $this->db->query("select reg_type, IN_ERP,IN_HR from school_details limit 1")->row_array();

				  $PageID   = $RowGetPage->ID ; 

				  $PageUrl  = $RowGetPage->PageUrl ; 

				  $PageName = $RowGetPage->PageName ;
				  
				  $CatNum   = $RowGetPage->CatNum;
				  
				  $Icon     = $RowGetPage->Icon;
				  
				  $CatName   = $RowGetPage->CatName;

                  $system    = $RowGetPage->system;

                  $checkAdd  = $RowGetPage->PermissionAdd  ;

                 $checkEdit  = $RowGetPage->PermissionEdit  ;

                 $checkDelete= $RowGetPage->PermissionDelete  ;

                 $checkView  = $RowGetPage->PermissioView  ;

				  $CheckPage = $this->user_permission_model->check_group_page($GroupID,$PageID);

				  $Add    = 0  ;

				  $Edit   = 0  ;

				  $Delete = 0  ;

				  $View   = 0  ;
                 
                 if($CatNum==$Cat->CatNum){
                      if($Icon==0||($query['IN_ERP']==$Icon && ($CatNum==1 || $CatNum==9 || $CatNum==15) && ($system=='erp' || $system=='both') )||($query['IN_HR']==$Icon && ($CatNum==1 || $CatNum==9 || $CatNum==15) && ($system=='hr' || $system=='both'))||($query['reg_type']==$Icon && $CatNum==7)){
				  if(is_array($CheckPage))

				  {

					  $Add    = $CheckPage['PermissionAdd']  ;

					  $Edit   = $CheckPage['PermissionEdit']  ;

					  $Delete = $CheckPage['PermissionDelete']  ;

					  $View   = $CheckPage['PermissioView']  ;

				  }

				  ?>

                                <tr>

                                    <td><?php echo lang($PageName) ?><input type="hidden"
                                            name="pageID<?php echo $KeyPage ?>" value="<?php echo $PageID ?>" /> </td>

                                    <td>
                                        <div><input id="ChkAll<?php echo $KeyPage ?>" value="<?php echo $KeyPage ?>"
                                                type="checkbox"
                                                onChange="check_all_add_edit('<?php echo $KeyPage ?>')"  /><label></label>
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                        <?php if($checkAdd==1){?> 
                                            <input class="check_add" type="checkbox"
                                                <?php if($Add == 1 ){echo 'checked' ;} ?>
                                                name="ChkAdd<?php echo $KeyPage ?>" id="ChkAdd<?php echo $KeyPage ?>"
                                                value="1" />
                                        <?php }else{ ?>
                                            <i class="fa fa-ban"></i>
                                            <?php } ?>
                                        <label></label></div>
                                    </td>

                                    <td>
                                        <div>
                                        <?php if($checkEdit==1){?> 
                                            <input class="check_edit" type="checkbox"
                                                <?php if($Edit == 1 ){echo 'checked' ;} ?>
                                                name="ChkEdit<?php echo $KeyPage ?>" id="ChkEdit<?php echo $KeyPage ?>"
                                                value="1"  />
                                                <?php }else{ ?><i class="fa fa-ban"></i><?php } ?>
                                                <label></label></div>
                                    </td>

                                    <td>
                                        <div>
                                        <?php if($checkDelete==1){?> 
                                            <input class="check_delete" type="checkbox"
                                                <?php if($Delete == 1 ){echo 'checked' ;} ?>
                                                name="ChkDel<?php echo $KeyPage ?>" id="ChkDel<?php echo $KeyPage ?>"
                                                value="1"  />
                                                <?php }else{ ?><i class="fa fa-ban"></i><?php } ?>
                                                <label></label></div>
                                    </td>

                                    <td>
                                        <div>
                                        <?php if($checkView==1){?>
                                        <input class="check_view" type="checkbox"
                                                <?php if($View == 1 ){echo 'checked' ;} ?>
                                                name="ChkView<?php echo $KeyPage ?>" id="ChkView<?php echo $KeyPage ?>"
                                                value="1" />
                                                <?php }else{ ?><i class="fa fa-ban"></i><?php } ?>
                                                <label></label></div>
                                    </td>

                                </tr>

                                <?php  

			   }}}}

			  ?>

                            </tbody>

                        </table>

                        <input type="hidden" name="KeyPage" value="<?php echo $KeyPage ?>" />


                    </div>

                </div>
                <?php if($per['PermissionEdit']==1){?>
                <input type="submit" class="btn btn-success" value="<?php echo lang('br_save'); ?>"
                    onclick="return check_sub();" />
                <?php } ?>



                <?php

		   }

		  }
		  
		   ?>


            </form>

            <script type="text/javascript">
            function check_all_add_edit(count)

            {



                //alert(document.getElementById("ChkAll"+count).value);

                //var ckbox = $("#ChkAll"+count).checked;

                if (document.getElementById("ChkAll" + count).checked) {

                    $("#ChkAdd" + count).prop('checked', true);

                    $("#ChkEdit" + count).prop('checked', true);

                    $("#ChkDel" + count).prop('checked', true);

                    $("#ChkView" + count).prop('checked', true);

                } else {

                    $("#ChkAdd" + count).prop('checked', false);

                    $("#ChkEdit" + count).prop('checked', false);

                    $("#ChkDel" + count).prop('checked', false);

                    $("#ChkView" + count).prop('checked', false);

                }





            }
            </script>

        </div>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>

</div>