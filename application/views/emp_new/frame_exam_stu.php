<style>
    .img-thumbnail{
        width: 65%;
        margin-bottom: 15px;
    }
    .textarea {
        line-height: 20px;
        padding: 8px 6px;
        height: auto !important;
}
.form-container{
    display:none;
}
<?php if($this->session->userdata('language') != 'english'){ ?>
    .print{
        float: left;
        direction: ltr;
        margin: 0px 0px 30px 15px;
        background-color: #13c0db;
        color: white;
    }
    <?php }else{ ?>
    .print{
        float: right;
        direction: rtl;
        margin: 0px 0px 30px 15px;
        background-color: #13c0db;
        color: white;
    }
    <?php } ?>

    .controls-wrap{
        text-align: center;
    }
    .student-quiz__question p {
    display: inline-block;
}
</style> 
<div id="print_div">
<div class="page-head blue container-fluid pt30">
    <!-- Breadcrumb -->
    <a class="btn print fas fa-print" type="button" onclick="PrintElem('#print_div');"> <?php echo lang('am_print');?></a>
    <!-- Title -->
    <h1> <?= $test_data['Name'];?> </h1>
</div>
<!-- // Page Head -->
<?php if($this->session->flashdata('msg')){?>
<div class="alert danger tx-align-center"><?php echo $this->session->flashdata('msg');?> </div> 
<?php } ?>
<div class="padding-all-20 mb0">
<form  method="post" action="<?php echo site_url('emp/exam_new/add_exam/'.$rowlevelid."/".$subjectid."/".$type."/".$test_id); ?>" >
<!-- Page Content -->
     
        <div class="pagebreak container form-ui">
            <!-- Grid -->
            <div class="row">
                <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php if($type==1) { echo lang('homework_Name');} elseif($type==0){ echo lang('Exam_Name') ; }  ?> </label>
                    <input  readonly type="text" name="txt_exam" id="txt_exam" value="<?= $test_data['Name'];?>">
                </div>
                <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('Subject_Name'); ?> </label>
                        <?php
                        foreach($subjectEmp_details as $row){
                            $subject_ID   = $row->subject_ID;
                            $subject_Name = $row->subject_Name;
                            $row_Name     = $row->row_Name;
                            $level_Name   = $row->level_Name;
                            $SubEmpID     = $row->SubEmpID;
                            $R_L_ID       = $row->R_L_ID;
                        ?>
                    <input readonly value="<?php echo $subject_Name.' - '.$row_Name.' - '.$level_Name;?>" <?php  if($R_L_ID==$rowlevelid && $subject_ID==$subjectid)echo 'selected' ; ?>  ></input>
                    <?php }?>
                </div>
                <!-- Form Control -->
                <!--<div class="col-12 col-m-6 col-l-4">-->
                <!--    <label for="" class="mb10 strong-weight"><?php echo lang('Semester'); ?> </label>-->
                <!--    <input value=""></input>-->
                <!--</div>-->
                    <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('am_from'); ?> </label>
                    <input readonly type="date" name="Date_from" value="<?php if($test_data['date_from']){echo date("Y-m-d", strtotime($test_data['date_from']));}else{ echo date("Y-m-d");} ?>"  required>
                </div>
                <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('am_from'); ?></label>
                    <input readonly type="time" name="Time_from" id="Time_from" value="<?php if($test_data['date_from']){ echo date("H:i", strtotime($test_data['date_from']));}else{ echo date("H:i",strtotime($Timezone));} ?>" required>
                </div>
                 <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('am_to'); ?> </label>
                    <input readonly type="date" name="Date_to"  value="<?php if($test_data['date_to']){echo date("Y-m-d", strtotime($test_data['date_to']));}else{ echo date("Y-m-d");} ?>"  required>
                </div>
                <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('am_to'); ?></label>
                    <input readonly type="time" name="Time_to" id="Time_to" value="<?php if($test_data['date_to']){echo date("H:i", strtotime($test_data['date_to']));}else{ echo date("H:i",strtotime($Timezone));} ?>" required>
                </div>
                 <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('er_lessons'); ?></label>
                    <select name="slct_lesson" id="slct_lesson"  >
                        <option value="0"><?php echo lang('am_Choose_lesson'); ?> </option>
                            <?php
                            if( is_array($lessonsTitles)){
                                foreach($lessonsTitles as $row){
                                    $LessonID 	 = $row->LessonID ;
                                    $LessonTitle = $row->LessonTitle ;
                            ?>
                        <option value="<?php echo $LessonID ?>" <?php  if($LessonID==$test_data['lessonID'] )echo 'selected' ; ?>><?php echo $LessonTitle ; ?></option>
                        <?php }} ?> 
                    </select>       
                </div>
                <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('Exam_Time2'); ?></label>
                    <input readonly type="number" name="txt_time"  id="txt_time"  min="0"  max="999" value="<?php echo ($test_data['time_count']/60);?>" required>
                </div>
                <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('br_class'); ?></label>
                    <select name="slct_class[]" id="slct_class" multiple class="manual select_2" >
                        <option value="0"> </option>
                            <?php
                            if( is_array($get_classes)){
                                foreach($get_classes as $val){
                                    $className   = $val->Name; 
                                    $classID     = $val->ID; 
                                    $class_test  =explode("," ,$test_data['classID']);
                                    if(in_array($classID, $class_test)) {
                            ?>
                        <option value="<?php echo $classID ?>" <?php if (in_array($classID, $class_test)) { echo 'selected';  } ?>><?php echo $className ; ?></option>
                        <?php   }   } }?>
                    </select> 
                </div>
                            <!-- Form Control -->
                            <!--<div class="col-12 col-m-6 col-l-4">-->
                            <!--    <label for="" class="mb10 strong-weight"><?php echo lang('am_students'); ?></label>-->
                            <!--    <input readonly type="hidden" id="RowLevel" value="<?php echo $rowlevelid ;?>" />-->
                            <!--    <select name="slct_student[]" id="slct_student" multiple class="manual select_2"  > -->
                            <!--       <option value="0"> </option>-->
                            <!--       <php-->
                            <!--            foreach($exam_student as $val){-->
                            <!--               $studentName   = $val->Name; -->
                            <!--               $studentID     = $val->ID; -->
                            <!--               $student_test  =explode("," ,$test_data['Students'])-->
                            <!--               ?>-->
                            <!--      <option value="<?php echo $studentID ?>" <?php if (in_array($studentID, $student_test)) { echo 'selected';  } ?>><?php echo $studentName ; ?></option>-->
                            <!--            <php   } ?>-->
                            <!--    </select> -->
                            <!--</div>-->
                            <!-- Form Control -->
                <div class="col-12 col-m-6 col-l-4">
                    <label for="" class="mb10 strong-weight"><?php echo lang('br_active'); ?> </label>
                    <input readonly type="checkbox"  name="IsActive"  id="IsActive" <?php if ($test_data['IsActive'] == 1) {  echo 'checked'; }?> value="1"  >
                </div>
            </div>
        </div>
</form>

        <ul class="reset-block questions-list">
     <?php
	 
        if(isset($questions)){
           
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
                ?>
                
                            <!-- Item -->
                            <li class="pagebreak item white-bg border-1 round-corner mb15 padding-all-25">
                                <!-- Content -->
                                <h3 class="medium-text mb15">  <?php echo lang('question').":".$key;?> <br><span class="danger-color"><?php echo $questions_type_Name ;?></span></h3>
                                <hr />
                                <!-- Grid -->
                                <form  method="post" action="<?php echo site_url('emp/exam_new/edit_exam_question/'.$questions_content_ID."/".$test_id); ?>" >
                                         
                                <div class="row form-ui">
                                    <!-- Form Control -->
                                    <div class="col-12 col-m-6 col-l-6">
                                        <label for="" class="mb10 strong-weight"> <?php if($Type_question_ID!=7) { echo lang('question'); }else{echo lang('note');}?></label>
                                        <div class="question-card__question">
                                            <h3><?php echo $question ;?> </h3>
                                        </div>
                                    </div>
                                    
                                  
                            <div class="col-12 col-m-6 col-l-4" style="">
                                <div>
                                    <label class="mb10 strong-weight"><?php echo lang('Degree'); ?></label>
                                    <input readonly type="number" name="txt_Degree<?php echo $questions_content_ID; ?>" value="<?= $Degree; ?>" min="0.5" style="float:none;clear:both;"  id="txt_Degree"  step="0.5" >
                                </div>
                                <!--<label class="mb10 strong-weight">درجة الصعوبه</label>-->
                                <!--<div style="display: flex;">-->
                                <!--    <div class="col-4 col-s-3" style="width: 33%;">-->
                                <!--        <label class="control-radio">-->
                                <!--            <?php echo lang('am_easy'); ?>-->
                                <!--            <input readonly type="radio"  name="difficult_degree<?php echo $questions_content_ID; ?>"  value="1" style="width: 20%;"<?php if($degree_difficulty==1){?> checked disabled <?php }?> />-->
                                <!--        </label>-->
                                <!--    </div>-->
                                <!--    <div class="col-4 col-s-3" style="width: 33%;">-->
                                <!--        <label class="control-radio">-->
                                <!--            <?php echo lang('am_average'); ?>-->
                                <!--            <input readonly type="radio"  name="difficult_degree<?php echo $questions_content_ID; ?>" value="2" style="width: 20%;" <?php if($degree_difficulty==2){?> checked disabled <?php }?> /> 	-->
                                <!--        </label>	                 -->
                                <!--    </div>                -->
                                <!--    <div class="col-4 col-s-3" style="width: 33%;">-->
                                <!--        <label class="control-radio">-->
                                <!--            <?php echo lang('am_difficult'); ?>-->
                                <!--            <input readonly type="radio" name="difficult_degree<?php echo $questions_content_ID; ?>"   value="3"  style="width: 20%;" <?php if($degree_difficulty==3){?> checked disabled <?php }?>/>	-->
                                <!--        </label>-->
                                <!--    </div>   -->
                                <!--</div>-->
                            </div>
                            <?php 
                            if($questions_types_ID==1){ ?>
                            <div class="form-repeater col-12 col-m-6 col-l-8" style="margin-top: 20px;">
                                            <label for="" class="mb10 strong-weight"><?php echo lang('Choices'); ?></label>
                                            <!-- Repeater Item -->
                                             <?php 
                                                     foreach($answers as $key=>$ans){
                                                         $answers_ID       = $ans->answers_ID;
                                                         $Answer           = $ans->Answer;
                                                         $Answer_correct   = $ans->Answer_correct;
                                                    ?>
                                            <div class="repeater-item" >
                                                <!-- Controls to Repeate -->
                                                <div class="controls-wrap row">
                                                   
                                                    <!-- Control -->
                                                    <div class="col-12 col-m-8">
                                                        <input readonly type="text" name="txt_Choices_edit<?php echo $questions_content_ID; ?>[]" placeholder="" value="<?php echo $Answer; ?>">
                                                        <input readonly type="hidden" name="txt_Choices_ID_edit<?php echo $questions_content_ID; ?>[]" placeholder="" value="<?php echo $answers_ID; ?>">
                                                    </div>
                                                    <!-- Control -->
                                                    <label class="checkbox">
                                                        <input readonly type="radio"  name="slct_Correct_edit<?php echo $questions_content_ID; ?>[]" <?php if($Answer_correct==1){?>checked <?php } ?> value="<?php echo $answers_ID; ?>" >
                                                         <span> <?php echo lang('Correct_Answer'); ?></span>
                                                    </label>
                                                   
                                                    
                                                </div>
                                                <!-- Repeater Button -->
                                                
                                            </div>
                                            <!-- // Repeater Item -->
                                             <?php } ?>
                                        </div>
                                          <?php }elseif($questions_types_ID==2){ ?>
                                           <div class="form-repeater col-12 col-m-6 col-l-8" style="margin-top: 20px;">
                                            <label for="" class="mb10 strong-weight"><?php echo lang('Choices'); ?></label>
                                            <!-- Repeater Item --><?php 
                                                     foreach($answers as $key=>$ans){
                                                         $answers_ID       = $ans->answers_ID;
                                                         $Answer           = $ans->Answer;
                                                         $Answer_correct   = $ans->Answer_correct;
                                                    ?>
                                                <div class="repeater-item">
                                                <!-- Controls to Repeate -->
                                                <div class="controls-wrap row">
                                                    
                                                    <!-- Control -->
                                                    <div class="col-12 col-m-8">
                                                        <p>
                                                            <?php echo $Answer; ?>
                                                        </p>
                                                        <!-- <input readonly type="text" name="txt_multi_Choices_edit<?php echo $questions_content_ID; ?>[]"  placeholder="" value="<?php echo strip_tags($Answer); ?>"> -->
                                                        <input readonly type="hidden" name="txt_multi_Choices_ID_edit<?php echo $questions_content_ID; ?>[]"  value="<?php echo $answers_ID; ?>">
                                                    </div>
                                                    <!-- Control -->
                                                    <label class="checkbox">
                                                        <input readonly type="checkbox"  name="slct_multi_Correct_edit<?php echo $questions_content_ID; ?>[]" <?php if($Answer_correct==1){?>checked <?php } ?> value="<?php echo $answers_ID; ?>">
                                                         <span> <?php echo lang('Correct_Answer'); ?></span>
                                                    </label>
                                                </div>
                                                <!-- Repeater Button -->
                                                
                                            </div>
                                            <!-- // Repeater Item -->
                                            <?php }?>
                                        </div>
                                         <?php }elseif($questions_types_ID==3){?>
                                            <div class="col-12 col-m-6 col-l-7" style="margin-top: 20px;">
                                                <label for="" class="mb10 strong-weight">الاجابة</label>
                                                <a type="button" <?php if($answers[0]->Answer_correct==1){ ?>class="btn info"<?php }else{?> class="btn default"<?php }?> id="right_answer1<?php echo $questions_content_ID; ?>"><?php echo lang("right_answer"); ?></a> 
                                                <a type="button" <?php if($answers[1]->Answer_correct==1){ ?>class="btn danger"<?php }else{?> class="btn default"<?php }?> id="wrong_answer1<?php echo $questions_content_ID; ?>"><?php echo lang("wrong_answer"); ?></a>
                                                <input readonly type="hidden" name="true_txt_edit<?php echo $questions_content_ID; ?>" id="true_txt1<?php echo $questions_content_ID; ?>" value="<?php echo $answers[1]->Answer_correct ;?>"/> 
				                                <input readonly type="hidden" name="false_txt_edit<?php echo $questions_content_ID; ?>" id="false_txt1<?php echo $questions_content_ID; ?>" value="<?php echo $answers[0]->Answer_correct ;?>"/> 
                                           </div>
                                           <?php } elseif($questions_types_ID==4){ ?>
                                         <div class="col-12 col-m-6 col-l-8">
                                            <label for="" class="mb10 strong-weight"><?php echo lang('answer'); ?></label>
                                            <!-- Repeater Item -->
                                            <div class="repeater-item">
                                                <!-- Controls to Repeate -->
                                                <div class="controls-wrap row">
                                                    <?php 
                                                     foreach($answers as $key=>$ans){
                                
                                                         $key              = $key+1;
                                                         $answers_ID       = $ans->answers_ID;
                                                         $Answer           = $ans->Answer;
                                                         $Answer_correct   = $ans->Answer_correct;
                                                    ?>
                                                    <!-- Control -->
                                                    <div class="col-12 col-m-8">
                                                        <input readonly type="text" name="txt_answer_edit<?php echo $questions_content_ID; ?>[]"  value="<?php echo $Answer; ?>">
                                                    </div>
                                                    <?php } ?>
                                                    <!--&nbsp;&nbsp;&nbsp;&nbsp;-->
                                                    <!--<a href="#" type="button" class="btn btn warning add-item" style="width: auto"><?php echo lang('Create_Correct_Answers'); ?></a>-->
                                                </div>
                                                <!-- Repeater Button -->
                                                
                                            </div>
                                            <!-- // Repeater Item -->
                                        </div>
                                            <?php } elseif($questions_types_ID==7){ ?>
                                         <div class="col-12 col-m-6 col-l-7" style="margin-top: 27px;">
                                            <!-- Repeater Item -->
                                            <?php 
                                             foreach($answers as $key=>$ans){
                                                 $answers_ID       = $ans->answers_ID;
                                                 $Answer           = $ans->Answer;
                                                 $Answer_match           = $ans->Answer_match;
                                                 $Answer_correct   = $ans->Answer_correct;
                                            ?>
                                            <div class="repeater-item">
                                                <!-- Controls to Repeate -->
                                                <div class="controls-wrap row">
                                                   
                                                <div class="col-12 col-m-5 arrive">
                                                    <? if($Answer_match !== ' '){?>
                                                        <label for="" class="mb10 strong-weight"><?php echo lang('question'); ?></label>

  	                                                 <span class="textarea form-control" role="textbox"  name="txt_match_question[]" cols="120" rows="50" ><?php echo $Answer_match; ?></span>
                                                    <?}?>

  	                                         </div>
  	                                          &nbsp;<br>====
      	                                        <div class="col-12 col-m-5 arrive">
      	                                            <label for="" class="mb10 strong-weight"><?php echo lang('answer'); ?></label>
                                                   <? if($Answer !== ''){?>
                                                    <span class="textarea form-control" role="textbox"  name="txt_match_answer[]" cols="120" rows="50"><?php echo $Answer; ?></span>

                                                    <?}?>
      	                                       </div>
                                                </div>
                                                <!-- Repeater Button -->
                                                
                                            </div>
                                            <!-- // Repeater Item -->
                                            <?php }?>
                                        </div>
                                           <?php }?>
                                        <div class="col-12 col-m-6 col-l-4" style="margin-top: 20px;">
                                <label for="" class="mb10 strong-weight">المرفقات</label>
                            <div>
                                <?php if($attach){
                                 $ext = pathinfo($attach, PATHINFO_EXTENSION); 
                                if($ext=='xlsx' || $ext=='xls'){
                                             ?>
                                              <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url()?>assets/exam/<?php echo $attach;?>' width="300px" height="300px" ></iframe>
                                            
                                             <?php
                                        }elseif($ext=='pdf' || $ext=='txt'){?>
                                            <a  href="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" ><?php echo lang('am_attach');?></a>
                                            <iframe width="100%"  height="100%"src="https://docs.google.com/gview?url=<?php echo base_url().'assets/exam/'.$attach; ?>&embedded=true" style="border:2px solid #ddd"></iframe>
                
                   <? }else {
                                ?>
							          <img class="img-thumbnail" src="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" />
							          <?php } } ?>
                            </div>
                            </div>
                                 </div>
                                    <!-- // Form Control -->
                               
                                </form>
                                <!-- // Buttons -->
                            </li>
    
                             <?php } } ?>
                            
                            <!-- // Item -->
                        </ul>
        </div>                
        
</div>   
   <script>
    function PrintElem(elem)
    {
        Popup($(elem).html());
		this.align="center";
		
    }

    function Popup(data) 
    {
		
        var mywindow = window.open('', 'my div', 'height=800,width=1000');
        mywindow.document.write('<html><head><title></title>');
		mywindow.document.write('<link href="<?php echo base_url(); ?>assets_new/css/fontawsome.css" rel="stylesheet" crossorigin="anonymous" />');
		mywindow.document.write('<link href="<?php echo base_url(); ?>assets_new/css/select2.min.css" rel="stylesheet" />');
		mywindow.document.write('<link href="<?php echo base_url(); ?>assets_new/css/tornado-rtl.css" rel="stylesheet" />');
		mywindow.document.write('<style>.print{display:none;}.control-radio{width:100px;}.textarea {line-height: 20px;padding: 8px 6px;height: auto !important;}.pagebreak {clear: both;page-break-after: always;}.col-12{width:50%;}.img-thumbnail{height: 250px;width: 250px;}.arrive{width:45% !important;}</style>');

        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        setTimeout(function(){
            mywindow.print();
        }, 3500)
        
        return true;
    }
</script>
<script>
 function adjustTextDirection() {
    // تعديل اتجاه النص في عناصر <p>
    const elementsP = document.querySelectorAll('p');
    elementsP.forEach(element => {
        if (/[\u0600-\u06FF\u0750-\u077F]/.test(element.textContent)) {
            element.style.direction = 'rtl';
        } else {
            element.style.direction = 'ltr';
        }
    });

    const elementsH = document.querySelectorAll('.question-card__question');
    elementsH.forEach(element => {
        const paragraphs = element.querySelectorAll('p');
        if (paragraphs.length > 0) {
            let foundArabic = false;
            paragraphs.forEach(p => {
                if (/[\u0600-\u06FF\u0750-\u077F]/.test(p.textContent)) {
                    foundArabic = true;
                }
            });

            if (foundArabic) {
                element.style.textAlign = 'right';
            } else {
                element.style.textAlign = 'left';
            }
        }
    });
}


window.onload = adjustTextDirection;
</script>