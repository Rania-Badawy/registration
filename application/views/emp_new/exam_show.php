<style>
    .questions .question-card {
        width: 1000px;
    }
</style>
          <main class="col-8 text-center">
            <!-- all quiz question -->
            <div class="questions">
             <?php if(isset($questions)){
            
            foreach($questions as $key=>$row){
                $key                      = $key+1;
                $questions_content_ID     = $row->questions_content_ID;
                $questions_type_Name      = $row->questions_type_Name;
                $question                 = $row->Question;
                $Degree                   = $row->Degree;
                $attach                   = $row->Q_attach;
                $questions_types_ID       = $row->questions_types_ID;
                $degree_difficulty        = $row->degree_difficulty;
                $num_ques                 = $row->num_ques;
                $answers                  = $this->exam_new_model->get_answer($questions_content_ID,$questions_types_ID);
			
				    switch($questions_types_ID)
				    {
				        case 2:
				            $class='success fas fa-check';
				        break;
				        case 3:
				            $class='success fas fa-check-double';
				        break;
				        case 4:
				            $class='primary fas fa-pen-alt';
				        break;
				        case 6:
				            $class='purple fas fa-scroll';
				        break;
				        case 7:
				            $class='pink fas fa-expand-arrows-alt';
				        break;
				        case 8:
				            $class='blue fas fa-signature';
				        break;
				        default:
				            $class='blue fas fa-signature';
				    }
                               
                ?>
                
              <!-- choose question card -->
              <form  method="post" action="<?php echo site_url('emp/exam_new/edit_exam_question/'.$questions_content_ID."/".$test_id); ?>" >
                  <input  type="hidden" id="rowlevelid"         name="rowlevelid"         value="<?= $rowlevelid ;?>"/> 
                  <input type="hidden"  id="subjectid"          name="subjectid"          value="<?= $subjectid ;?>"/> 
                  <input type="hidden"  id="type"               name="type"               value="<?= $type ;?>"/> 
                  <input type="hidden"  id="Type_question_ID"   name="Type_question_ID"   value="<?= $questions_types_ID ;?>"/> 
              <div class="question-card choose-question" style="margin-right: 42px;width: 930px;">
                <!-- card header -->
                <div class="question-card__header flexbox align-between">
                  <div class="question-card__icon exam-box__type">
                    <i class="<?php echo $class;?>"></i>
                    <h3><?php echo lang('question').":".$key;?> <br><span class="danger-color"><?php echo $questions_type_Name ;?></span></h3>
                  </div>
                  <div class="question-card__action">
                      <!--<div>-->
                        <label class="mb10 strong-weight"><?php echo lang('Degree'); ?></label>
                        <input type="number" name="txt_Degree<?php echo $questions_content_ID; ?>" readonly value="<?= $Degree; ?>" min="0.5" style="float:none;clear:both;width:60px;height: 34px;border: solid;color: brown;"  id="txt_Degree"  step="0.5" >
                  <!--</div>-->
                  <?php $query=$this->db->query("select ID from test_student where test_id=$test_id")->result();
                  if(empty($query)){
                  ?>
                  <a href="<?php echo site_url('emp/exam_new/ques_type/'.$rowlevelid."/".$type."/".$test_id."/".$questions_types_ID."/".$questions_content_ID); ?>" class="btn outline success "><?php echo lang("br_edit"); ?></a>
                  <a type="button" href="<?php echo site_url('emp/exam_new/del_exam_question/'.$questions_content_ID); ?>" class="btn outline fas fa-trash primary " onclick="return confirm('Are you sure to delete?')"></a>
                  <?php } ?>
                  </div>
                </div>
                <!-- //card header -->
                <!-- card body -->
                <div class="question-card__body">
                  <div class="question-card__question">
                    <h3><?php echo $question ;?> </h3>
                  </div>
                  <hr/>
                  <?php 
                            if($questions_types_ID==2){ ?>
                  <div class="exam-box__multi-choices">
                      <?php 
                         foreach($answers as $key=>$ans){
                             $answers_ID       = $ans->answers_ID;
                             $Answer           = $ans->Answer;
                             $Answer_correct   = $ans->Answer_correct;
                             
                        ?>
                        <div class="choice">
                     <input type="checkbox" <?php if($Answer_correct==1){?>checked <?php } ?> value="<?php echo $Answer_correct; ?>" onclick="return false" readonly>
                     <br>
                      
                      <?php 
        				 $ImagePath =base_url().'assets/exam/'.$Answer;
        			       if(file_exists('./assets/exam/'.$Answer)&&$Answer!=""){
        				?>   
        				     <?php 
                            $imgarray =  array('gif','png' ,'jpg','jpeg','JPEG','PNG');
                            $files =  array('pdf','doc' ,'docx','txt','ppt','xlsx' , 'pptx');
                            $video = array('mp4','mp3' ,'wav','aif','aiff','ogg');
                            $fileCheck = pathinfo($Answer);
                            if(in_array($fileCheck['extension'],$imgarray) ) { ?>
                               <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>" style="height: 200px !important;"/>
                            <?php }
                            elseif(in_array($fileCheck['extension'],$files) ){ ?>
                                     <a class="btn btn-success" href="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>"  download >
                    	            <i class="fa fa-download"></i>   <?php echo lang('am_download');?></a>
                            <?php }elseif(in_array($fileCheck['extension'],$video)){ ?>
                                <video width="200" height="240" controls>
                                  <source src="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>" type="video/mp4" style="height: 200px !important;">
                                </video>
                            <?php } }else{?>
                            <div style="text-align: center;margin-top: 72px;font-size: large; word-break: break-all;" class="ql-editor">
                               <span><?php echo $Answer; ?></span>
                            </div>
                            <?php } ?>
                   
                    </div>
                    <?php } ?>
                  </div>
                  <?php }elseif($questions_types_ID==3){ ?>
                   <div class="question-card__answer flexbox flex-wrap">
                       <?php 
                         foreach($answers as $key=>$ans){
                             $answers_ID       = $ans->answers_ID;
                             $Answer           = $ans->Answer;
                             $Answer_correct   = $ans->Answer_correct;
                              if(($Answer=='الاجابة صحيحة '||$Answer=='Correct answer ')){
            			         $Answer=lang("right_answer");}
            				  else if(($Answer=='الاجابة خاطئة '||$Answer=='Wrong answer ')){
            						 $Answer=lang("wrong_answer");} ?>
                    <div  <?php if($Answer_correct==0){?>class="choose-answer"<?php }else{?>class="choose-answer correct"<?php }?>>
                      <i class="fal fa-check-circle"></i>
                      <span><?php echo $Answer; ?></span>
                    </div>
                    <?php } ?>
                  </div>
                   <?php }elseif($questions_types_ID==4){ ?>
                   <div class="question-card__answer flexbox flex-wrap">
                      <?php 
                         foreach($answers as $key=>$ans){
                             $answers_ID       = $ans->answers_ID;
                             $Answer           = $ans->Answer;
                             $Answer_correct   = $ans->Answer_correct;
                            
                        ?>
                    <div class="choose-answer " >
                      <input type="text" value=<?php echo $Answer; ?> style="text-align: center;font-size: inherit;" readonly>
                    </div>
                    <?php } ?>
                  </div>
                  <?php }elseif($questions_types_ID==7){ ?>
                  <div class="question-card__answer match-question">
                      
                    <div class="row">
                      <div class="col-6">
                        <label><?php echo lang('am_qus');?></label>
                        <?php 
                         foreach($answers as $key=>$ans){
                             $answers_ID       = $ans->answers_ID;
                             $Answer           = $ans->Answer;
                             $Answer_match     = $ans->Answer_match;
                             $Answer_correct   = $ans->Answer_correct;
                        ?>
                        <div class="item">
                          <div class="item-text"  <?php if($Answer_match!="" &&  file_exists('./assets/exam/'.$Answer_match)){ ?>style="height: 200px !important;"<?php }else{ ?>style="height: 80px;overflow:scroll;"<?php }?>>
                               <?php if(file_exists('./assets/exam/'.$Answer_match)){ ?>
                              <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $Answer_match;?>" style="height: 200px !important;"/><?php }else{?>
                             <?php echo $Answer_match;  }?>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-6">
                        <label><?php echo lang('am_answer');?></label>
                         <?php 
                         foreach($answers as $key=>$ans){
                             $answers_ID       = $ans->answers_ID;
                             $Answer           = $ans->Answer;
                             $Answer_match     = $ans->Answer_match;
                             $Answer_correct   = $ans->Answer_correct;
                        ?>
                        <div class="item">
                          <div class="item-text"   <?php if($Answer!="" && file_exists('./assets/exam/'.$Answer)){ ?>style="height: 200px !important;"<?php } else { ?>style="height: 80px;overflow:scroll;"<?php }?>>
                              <?php if(file_exists('./assets/exam/'.$Answer_match)){ ?>
                              <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>" style="height: 200px !important;"/><?php }else{?>
                             <?php echo $Answer;  }?>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                    
                  </div>
                  <?php }elseif($questions_types_ID==8){ ?>
                  <!--<div class="question-card__answer">-->
                  <!--  <div class="question-card__drawer"></div>-->
                  <!--</div>-->
                  <?php } ?>
                  <div style="text-align: end;">
                      <?php 
        				 $ImagePath =base_url().'assets/exam/'.$attach;
        			       if(file_exists('./assets/exam/'.$attach)&&$attach!=""){
        				?>   
        				 <label for="" class="mb10 strong-weight"><?php echo lang('am_attach');?></label>
        				     <?php 
                            $imgarray =  array('gif','png' ,'jpg','jpeg','JPEG','PNG');
                            $files =  array('pdf','doc' ,'docx','txt','ppt','xlsx' , 'pptx');
                            $video = array('mp4','mp3' ,'wav','aif','aiff','ogg');
                            $fileCheck = pathinfo($attach);
                            if(in_array($fileCheck['extension'],$imgarray) ) { ?>
                               <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" style="height: 200px !important;"/>
                            <?php }
                            elseif(in_array($fileCheck['extension'],$files) ){ ?>
                                     <a class="btn btn-success" href="<?php echo base_url()?>assets/exam/<?php echo $attach;?>"  download >
                    	            <i class="fa fa-download"></i>   <?php echo lang('am_download');?></a>
                            <?php }elseif(in_array($fileCheck['extension'],$video)){ ?>
                                <video width="320" height="240" controls>
                                  <source src="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" type="video/mp4" style="height: 200px !important;">
                                </video>
                            <?php } }?>
                </div>
                </div>
                <!-- //card body -->
              </div>
              </form>
              <?php } }?>
        </div>
    </main>
    