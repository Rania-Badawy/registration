<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script><script type="text/javascript" language="javascript" class="init">    $(function () {        $('#example').dataTable();    });</script> <script type="text/javascript">      /////////////////////////////////////////////////////////////////////////////////////////////////////function validateNumber(event) {var key = window.event ? event.keyCode : event.which;if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 9) {return true;}else if ( key ==46 ) {return true;}else if ( key < 48 || key > 57 ) {return false;}else return true;};////////////////////////////////////////////////////////////////////////////      </script><div class="clearfix"></div><div class="content margin-top-none container-page">    <div class="col-lg-12">        <div class="block-st">        <?php            if($this->session->flashdata('SuccessAdd')){echo  '<div class="alert alert-success">'. $this->session->flashdata('SuccessAdd').'</div>';}            if($this->session->flashdata('ErrorAdd')){echo  '<div class="alert alert-error">'. $this->session->flashdata('ErrorAdd').'</div>';}            ?>    <form action="<?php echo site_url('admin/cpanel/add_new_admin') ?>" method="post">            <div class="sec-title">                <h2><?=  lang("br_admin"); ?> </h2>            </div>            <div class="clearfix"></div>                 <div class="panel ">                    <div class="panel-body">           <div class="form-group col-lg-5" style="margin:0px;">            <label for="multiple-label-example"  class="label-control col-lg-2"><?php echo lang('br_contact'); ?></label>            <div class="col-lg-8">             <select  class="form-control selectpicker" data-live-search="true" tabindex="18" name="Contact"  id="Contact" >           <option value="0">---------</option>            <?php			if($EmpAdmin)			{				foreach($EmpAdmin as $Key=>$contact)				{										$ID   = $contact->ID ;					$Name = $contact->Name ;					$TypeArray = array('U'=> "أدمن ", 'E'=>'موظف');					?>					<option value="<?php echo $ID ; ?>"><?php echo $Name.'&nbsp;-&nbsp;'.$TypeArray[$contact->Type] ; ?></option>					<?php 				}			}			 ?>             </select>          			</div>                                              </div>                               <div class="form-group col-lg-5">            <label for="multiple-label-example"  class="label-control col-lg-2"><?php echo lang('br_Branches'); ?></label>            <div class="col-lg-8">             <select data-placeholder="<?php echo lang('br_Branches'); ?>"  class="form-control selectpicker" data-live-search="true" tabindex="18" name="SchoolID[]"  id="SchoolID" multiple>           <option value=""><?=lang('am_select')?></option>                  <?php 										if ($GetSchool) {											foreach ($GetSchool as $school) {										?>                                            <option value="<?=$school->SchoolId?>" <?php  if(is_array($Branch))	{	if(in_array($school->SchoolId , $Branch)){echo 'selected';}	}?>><?=$school->SchoolName?></option>                                            <?php											}										}										?>                </select>			</div>          </div>  <div class="form-group col-lg-2">            <input type="submit" class="btn btn-success" value="<?php echo lang('br_save') ?>" /> </div> 		  		                  </div>   	     </div>                          </form>   <div class="clearfix"></div>            <?php            if(is_array($Admin))            {?>                                                    <div class="clearfix"></div>                                                                <div class="panel panel-danger">                    <div class="panel-body no-padding">                        <table id="example" class="table table-striped table-bordered">                            <thead>                            <tr>                                <th><?php echo lang('br_n') ?></th>                                <th><?php echo lang('br_Name') ?></th>                                                                <th><?php echo lang('br_NumberID') ?></th>                                <th><?php echo lang('br_school_name') ?></th>                                                                <th><?php echo lang('br_last_log') ?></th>                                <th><?php echo lang('br_delete') ?></th>                            </tr>                            </thead>                            <tbody>                            <?php                            foreach($Admin as $Key=>$Row)                            {                                $KeyVal      = $Key+1 ;                                $ID          = $Row->ID ;                                $Name        = $Row->Name ;								$SchoolID    = $Row->SchoolID ;							    $LastLogin   = $Row->LastLogin ;							    							    $Number_ID   = $Row->Number_ID ;                                ?>                                <tr>                                    <td><?php echo $KeyVal ; ?></td>                                    <td><?php echo $Name ; ?></td>                                                                        <td><?php echo $Number_ID ; ?></td>									<td>									   	<?php													if ($GetSchool) {														foreach ($GetSchool as $Key => $val) {															$SchoolId  = $val->SchoolId;															$SchoolName = $val->SchoolName;															$school_id_array = explode(",", $Row->SchoolID);															if (in_array($SchoolId, $school_id_array)) {																echo $SchoolName . ",";															}														}													} ?>								    </td>								    								    <td><?php echo $LastLogin ; ?></td>                                    <td><a href="<?= site_url('admin/cpanel/change_type/'.$ID.'') ?>" onClick="return check_Request();" ><?php echo lang('br_delete') ; ?></a></td>                                </tr>                            <?php                            }                            ?>                            </tbody>                        </table>                    </div>                </div>   <div class="clearfix"></div>            <?php            }else{echo '<div class="alert alert-error">'.lang('br_check_add').'</div>';}            ?>            <div class="clearfix"></div>        </div>        <div class="clearfix"></div>    </div>    <div class="clearfix"></div></div><div class="clearfix"></div><script>    function check_Request()    {        var msg = confirm('<?= lang("br_confirm") ?>');        if(msg){return true ; }else{return false ; }    }</script>