<style>
    .form-control {
        width:70%;
        font-size: large;
        border-radius: 15px;
    }
    .control-label{
        font-size: 17px !important;
        width: auto;
    }
    .conDiv{
        background-color: #f2f2f2;
        border: 2px solid;
        padding: 15px;
        /*font-size: 17px;*/
        width: fit-content;
    }
    .saveBtn{
        float: right;
    }
    <?php if($this->session->userdata('language') != 'english'){?>
    .saveBtn{
        float: left;
    }
    <?php } ?>
</style>
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2> <?php echo lang('Additional data') ?> </h2>
            </div>

        	<div class="row form-group">               
 
  <form action="<?php echo site_url('admin/Report_Register/add_register_status/'.$id) ?>" method="post"  >
                <div class="col-xs-12">
                    <div class="col-md-12">
						<div class="row">
						
							<input  type ="hidden" id="parent_email" name="parent_email" class="form-control " value="<?=$getStudentR['parent_email'];?>" / >
							<div class="form-group col-lg-4">
								<label class="control-label col-lg-3"> <?php echo lang('am_Mobile') ?>  </label>
								<div class="col-md-12 col-sm-12 col-xs-12">
								    <input  name="parent_mobile" class="form-control " value="<?=$getStudentR['parent_mobile'];?>"  readonly/ >
								</div>						
							</div>
							<div class="form-group col-lg-4">
								<label class="control-label col-lg-3"><?php echo lang('status') ?> </label>
								<div class="col-md-12 col-sm-12 col-xs-12">
								    <select id="status" name="status" class="form-control" class="form-control ">
								        <option value="0"> <?php echo lang('add status') ?>  </option>
                                            <?php 
										       if ($status) {
											     foreach ($status as $val) {
										    ?>
                                            <option value="<?=$val->ID?>"<?php if($val->ID==$getStudent_status['Status']){echo 'selected' ;}?>><?=$val->Name?></option>
                                            <?php
											  }	}
										    ?>
                                         </select>	
								</div>						
							</div>							
						
							<div class="form-group col-lg-4">
								<label class="control-label col-lg-3"><?php echo lang('contacted') ?>   </label>
								<div class="col-md-12 col-sm-12 col-xs-12">	
									<div class="col-lg-4">
							           <label class="control-radio">  <?php echo lang('Yes') ?>
							 
							             <input type="radio"  name="contact" <?php if ($getStudent_status['is_contact'] ==  lang('Yes') ) { ?>   checked="checked"<?php }?> value="<?php echo lang('Yes') ?>"   />
								         <div class="control_indicator_radio"></div>
							           </label>
							         </div>

							        <div class="col-lg-4">
							         <label class="control-radio">لا
								      <input type="radio"  name="contact" <?php if ($getStudent_status['is_contact'] == 'لا') { ?> checked="checked" <?php }?> value="لا"<?php if(!$getStudent_status['is_contact']){?> checked="checked"<?php }?>  /> 	
								      <div class="control_indicator_radio"></div>
							         </label>	                 
							       </div>                
								</div>						
							</div>
							
								
							<div class="clearfix"></div>
							<br><br>
							<!--<div class="form-group col-lg-4">-->
							<!--	<label class="control-label col-lg-3">  <?php echo lang('add a reminder') ?>   </label>-->
							<!--	<div class="col-md-12 col-sm-12 col-xs-12">	-->
							<!--			<input type="datetime-local" name="date_remember"  class="form-control " value="<?php if($getStudent_status['remember_date']){echo date("Y-m-d\TH:i:s", strtotime($getStudent_status['remember_date']));}?>">-->
							<!--	</div>						-->
							<!--</div>-->
						
							<div class="form-group col-lg-4">
								<label class="control-label col-lg-3"> <?php echo lang('am_comments') ?>  </label>
								<div class="col-md-12 col-sm-12 col-xs-12">
								    	 <textarea name="comments" charset="UTF-8" class="form-control " id="comments" style="width: 100%;"><?=$getStudent_status['comments'];?></textarea> 
						
								</div>						
							</div>
							
							
							<div class="clearfix"></div>

								<div class="saveBtn">		
									<input type="submit" class="btn btn-success"   value="<?= lang('br_save');?>"/>
								</div>
	</form>
	</div>
	                         <?php
	                         $query=$this->db->query("select GroupID from contact where ID =".$this->session->userdata('id')."")->row_array();
	                         if(!empty($getStudent_status)&&$query['GroupID']!=18){ ?>
	                         
	                        <div class="form-group col-lg-4">
								    	<div class="conDiv">
								    	    <p><?php echo lang('contacted') ?> : <?= $getStudent_status['Name']; ?></p>
								    	    <p><?= lang('br_date')?>: <?=$getStudent_status['status_date'];?></p>
								    	</div>
								    	
								</div>	
							<?php }?>
						
						</div>
                    </div>      
                   
                 
                </div> 
                
        </div> 
</div>