  <?php
        if(isset($config_emp)){
			$subjectEmpIDSession =  $config_emp;
		      if(is_numeric($subjectEmpIDSession)){
				 $get_classes= $this->exam_new_emp_model->get_classes ($subjectEmpIDSession ); 
                   ?>
				  <div class="form-group col-lg-4">
                <label class="control-label col-lg-3"><div class="error pull-left">*</div> <?php echo lang('br_class'); ?></label>
                <div class="col-lg-9">
 <select name="slct_class" id="slct_class" multiple class="selectpicker form-control" >
         <?php
          if( is_array($get_classes)){
             foreach($get_classes as $row){
                $className   = $row->Name; 
                $classID   = $row->ID;
                ?>
                <option value="<?php echo $classID ?>"   <?php echo  set_select('slct_class',$classID); ?>  ><?php echo $className ; ?></option>
             <?php   }   } ?> 
			   
        </select>                
                </div>
                <div class="col-lg-9">
                <div class="error" id="errorslct_class" > </div>
                </div>
            </div>
				  <?php   }                                               
 			}?>