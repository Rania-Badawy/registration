<!-- Page Head -->
                 <div class="page-head container-fluid pt30">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                         <a href="<?php echo site_url('emp/cpanel'); ?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
                         <a href="#"><?php   if($type==1) { echo lang('am_homework') ; } elseif($type==0||$type==4||$type==5){ echo lang('Exams') ; } ?></a>
                    </div>
                    <!-- Title -->
                    <h1><?php if($type == 5){ echo $exam_details[0]->subject_Name ;}elseif($type == 4){ echo $exam_details[0]->level_Name.'_'.$exam_details[0]->row_Name ;}else{echo $exam_details[0]->level_Name.'_'.$exam_details[0]->row_Name.'_'.$exam_details[0]->subject_Name ;} ?> </h1>
                </div>
                <!-- // Page Head -->

                <!-- Buttons Box -->
                <div class="dt-filters-btn container-fluid row flexbox form-ui">
                     <a href="<?php echo site_url('emp/exam_new/create_exam/'.$type); ?>" class="btn purble-bg btn-icon fas fa-plus" ><?php  echo lang('Add_Exam'); ?> </a>

                    
                </div>
                <!-- // Buttons Box -->

                <!-- Data Table -->
                <div class="container-fluid responsive-sm-table white-bg padding-all-20 mb0">
                    <table class="table bordered-y  white-bg medium-spaces data-table-ex" data-items="6">
                        <!-- Table Head -->
                        <thead>
                            <tr class="purble-bg" >
                                <th class="width-50 tx-align-center hide-sort-arrow">#</th>
						        <th class="tx-align-center"><?php if($type==1) { echo lang('homework_Name');} elseif($type==0||$type==4|$type==5){ echo lang('Exam_Name') ; }  ?></th>
                                <th class="tx-align-center"><?php echo lang('time_per_minute'); ?></th>
                                <th class="tx-align-center"> <?php echo lang('school'); ?> </th>
                                <th class="tx-align-center"> <?php echo lang('br_row_level'); ?> </th>
                                <th class="tx-align-center"> <?php echo lang('br_emp_fathert_eval'); ?> </th>
                                <th class="tx-align-center"><?php echo lang('am_edit'); ?></th>
                                <th class="tx-align-center"><?php echo lang('am_delete'); ?></th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <?php
        
                                foreach($exam_details as $key => $row){
                                        $ke                     = $key+1;
				                        $Name                   = $row->Name;
				                        $Name_sms               = $row->Name_sms;
				                        $time_count             = $row->time_count/60;
				                        $ID                     = $row->ID;		
                                        $IsActive               = $row->IsActive;
                                        $date_from              = $row->date_from;
                                        $SchoolName             = $row->schoolName;
                                        $empID                  = $row->empID;
                                        $rowLevelName           = $row->rowLevelName;
                                        $empName                = $this->db->query("select Name from contact where ID=$empID")->row_array()['Name'];
                                        $exist_exam             = $this->exam_new_model->get_exist_exam($ID);
			                     ?>

                            <!-- Row -->
                            <tr>
                                <td class="tx-align-center"><?php echo $ke;?></td>
                                <td class="tx-align-center"><?php  echo $Name;?></td>
                                <td class="tx-align-center"><?php  echo $time_count;?></td>
                                <td class="tx-align-center"><?php  echo $SchoolName;?></td>
                                <td class="tx-align-center"><?php  echo $rowLevelName;?></td>
                                <td class="tx-align-center"><?php  echo $empName;?></td>
                                <td class="tx-align-center">
                                  <?php  if(!$exist_exam || $type==4){?>
                                          <a  title="Edit" href="<?php echo site_url('emp/exam_new/create_exam/'.$type."/".$ID); ?>" >
                                            <i class="fa fa-edit info-color"></i>
                                          </a>
                                 <?php }else{ ?>
                                  <span class="fa fa-ban"></span>
                                 <?php }?>
                                </td>
                                <td class="tx-align-center"> 
                                  <?php  if(!$exist_exam){?>
                                  <span class="tip" >
                                     <a  href="<?php echo site_url('emp/exam_new/del_exam/'.$ID."/".$type);?>" onclick="return confirm('Are you sure to delete?')" name="Band ring" title="Delete"  >
                                         <i class="fas fa-trash-alt danger-color"></i>
                                     </a>
                                  </span> 
                                    <?php  }else{ ?>
                                 <span class="fa fa-ban"></span>
                                  <?php }?>
                                </td>
                               
                          </tr>
                           
                            <!-- // Row -->
                        </tbody>
                        	<?php
								 }?>
                        <!-- // Table Body -->
                    </table>
                </div>
<script>

    function chang_semester(Rl , Sub ,type,SemesterID)
    {
       window.location = "<?= site_url('emp/exam_new/index') ?>/"+Rl+"/"+Sub+"/"+type+"/"+SemesterID ;
    }

</script>