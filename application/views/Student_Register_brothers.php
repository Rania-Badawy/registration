 
  
 <div id="load_student_data1">
    <div class="col-md-12 p-0 studentData1">
  <?php if ($val == true) { ?>
    <hr><button onclick="$(this).closest('.studentData1').remove();$('#addStudentValue'+'<?=$addStudentValue?>').remove();" type="button" class="btn btn-danger btn-lg deleteStudent"> <i class="fa fa-trash" aria-hidden="true"></i> <?=lang('na_delete_bro')?></button>
  <?php }
    else {
        //$addStudentValue = 0;
    }
     ?>
 <div class="col-xs-12 title_register mt-20" >
            <h5><i class="fa fa-user" aria-hidden="true"></i> <?=lang('bro_data')?> </h5>
        </div>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('na_bro_name')?> <span class="danger"></span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="bro_name<?=$addStudentValue?>" name="bro_name[]" maxlength="50" value="" onkeyup="checktext($(this));" class="form-control">
            </div>
        </div>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('am_level')?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select data-value="" id="bro_levelID<?=$addStudentValue?>" name="bro_levelID[]" class="form-control">
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                     <?php 
										
											foreach ($get_row_level as $row) {
										?>
                                            <option value="<?=$row->row_level_ID?>"><?=$row->rowName."-".$row->levelName?></option>
                                            <?php
											}
										
										?>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?=lang('school_Name')?> <span class="danger"></span></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <input type="text" id="bro_School<?=$addStudentValue?>"  name="bro_School[]" value="" class="form-control">
            </div>
        </div>
         <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
            <label class="control-label col-md-5 col-sm-12 col-xs-12"><?=lang('na_school_type')?></label>
            <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                <select id="school_type<?=$addStudentValue?>"  name="school_type[]" class="form-control">
                    <option value=""><?php echo lang('am_choose_select'); ?></option>
                    <option value="1"> <?= lang('governmental') ?>  </option>
                    <option value="2"> <?= lang('private') ?> </option>
                </select>
            </div>
        </div>
      
    </div> 
    
      </div>
 